<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function clients()
    {
        return view('clients')->with('clients', \App\Client::orderBy('datecreated', 'DESC')->paginate(15));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function client(Request $request)
    {
        return view('client')
            ->with('client', \App\Client::findOrFail($request->id));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function clientInvoices(Request $request)
    {
        $client = \App\Client::findOrFail($request->id);

        $invoices = $client->invoice()->get()->map(function ($item) {
            return $item->setAttribute('invoice_items', $item->item()->get());
        });

        return view('client-invoices')
            ->with('invoices', $invoices)
            ->with('client', $client);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoices()
    {
        return view('invoices')->with('invoices', \App\Invoice::orderBy('date', 'DESC')->paginate(15));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoicesFinder(Request $request)
    {

        if ($request->status === 'Overdue') {

            return view('invoices')
                ->with('invoices',
                    \App\Invoice::whereIn('status', [$request->status, 'Unpaid'])
                        ->whereDate('duedate', '<=', Carbon::today()->toDateString())
                        ->orderBy('date', 'DESC')
                        ->paginate(15)
                );
        }

        return view('invoices')->with('invoices', \App\Invoice::where('status', $request->status)->orderBy('date', 'DESC')->paginate(15));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoice(Request $request)
    {
        $invoice_child = \App\Invoice::findOrFail($request->id);

        $invoice_child->setAttribute('invoice_item', $invoice_child->item()->get());

        return view('invoice')
            ->with('invoice_child', $invoice_child)
            ->with('invoice', \App\Invoice::findOrFail($request->id));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function script(Request $request)
    {

        $model = $request->model;
        $model = "App\\$model";

        if(!is_array(unserialize($request->selectors))){
            return abort(404);
        }

        if (!class_exists("\\$model"))
            return abort(404);

        try {
            $script = $model::findOrFail($request->id);

            foreach (unserialize($request->selectors) as $key => $value) {
                $script->$key = $value;
            }

            $script->save();

            return back()->with('success', __("the {$request->model}'s script was succesful done!"));
        } catch (\Exception $exception) {

            return back()->with('danger', $exception->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings()
    {
        return view('settings')->with('settings', \App\Setting::all());
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function search(Request $request)
    {

        $invoices = Invoice::where('invoicenum', 'like', '%' . $request->q . '%')
            ->orWhere('subtotal', 'like', '%' . $request->q . '%')->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'category' => __('invoices'),
                    'display' => "#{$item->client()->first()->companyname}",
                    'description' => "{$item->duedate->format(config('app.time_format'))} - {$item->status}",
                    'url' => "/invoice/$item->id",
                ];
            })->toArray();

        $clients = Client::where('firstname', 'like', '%' . $request->q . '%')
            ->orWhere('lastname', 'like', '%' . $request->q . '%')
            ->orWhere('companyname', 'like', '%' . $request->q . '%')
            ->orWhere('email', 'like', '%' . $request->q . '%')
            ->orWhere('postcode', 'like', '%' . $request->q . '%')
            ->orWhere('tax_id', 'like', '%' . $request->q . '%')
            ->orWhere('phonenumber', 'like', '%' . $request->q . '%')->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'category' => __('clients'),
                    'display' => ucfirst(strtolower($item->firstname)) . ' ' . ucfirst(strtolower($item->lastname)) . ' '
                    . empty($item->firstname) ? $item->companyname : null,
                    'description' => "{$item->email}",
                    'url' => "/client/$item->id",
                ];
            })->toArray();

        return response()->json([
            'items' => array_merge($clients, $invoices)
        ]);
    }

}
