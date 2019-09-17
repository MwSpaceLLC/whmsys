<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use App\Setting;
use App\Ticket;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @return Factory|View
     */
    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function home()
    {
        return view('home');
    }

    /**
     * @return Factory|View
     */
    public function clients()
    {
        return view('clients')->with('clients', Client::orderBy('datecreated', 'DESC')->paginate(15));
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function client(Request $request)
    {
        return view('client')
            ->with('client', Client::findOrFail($request->id));
    }

    public function clientCleanly(Request $request)
    {
        return view('client-cleanly')
            ->with('client', Client::findOrFail($request->id));
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function clientInvoices(Request $request)
    {
        $client = Client::findOrFail($request->id);

        $invoices = $client->invoice()->get()->map(function ($item) {
            return $item->setAttribute('invoice_items', $item->item()->get());
        });

        return view('client-invoices')
            ->with('invoices', $invoices)
            ->with('client', $client);
    }

    /**
     * @return Factory|View
     */
    public function invoices()
    {
        return view('invoices')->with('invoices', Invoice::orderBy('date', 'DESC')->paginate(15));
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function invoicesFinder(Request $request)
    {

        if ($request->status === 'Overdue') {

            return view('invoices')
                ->with('invoices',
                    Invoice::whereIn('status', [$request->status, 'Unpaid'])
                        ->whereDate('duedate', '<=', Carbon::today()->toDateString())
                        ->orderBy('date', 'DESC')
                        ->paginate(15)
                );
        }

        return view('invoices')->with('invoices', Invoice::where('status', $request->status)->orderBy('date', 'DESC')->paginate(15));
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function invoice(Request $request)
    {
        $invoice_child = Invoice::findOrFail($request->id);

        $invoice_child->setAttribute('invoice_item', $invoice_child->item()->get());

        return view('invoice')
            ->with('invoice_child', $invoice_child)
            ->with('invoice', Invoice::findOrFail($request->id));
    }

    public function invoiceCleanly(Request $request)
    {
        $invoice_child = Invoice::findOrFail($request->id);

        $invoice_child->setAttribute('invoice_item', $invoice_child->item()->get());

        return view('invoice-cleanly')
            ->with('invoice_child', $invoice_child)
            ->with('invoice', Invoice::findOrFail($request->id));
    }

    public function tickets()
    {
        return view('tickets')->with('tickets', Ticket::orderBy('date', 'DESC')->paginate(15));
    }

    public function ticketsFinder(Request $request)
    {
    }

    public function ticket(Request $request)
    {
        return view('ticket')->with('ticket', Ticket::findOrFail($request->id));
    }

    public function ticketOpen()
    {
        return view('ticket-open');
    }

    public function ticketCleanly(Request $request)
    {
        return view('ticket-cleanly')->with('ticket', Ticket::findOrFail($request->id));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|void
     */
    public function script(Request $request)
    {

        $model = $request->model;
        $model = "App\\$model";

        if (!is_array(unserialize($request->selectors))) {
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
        } catch (Exception $exception) {


            return back()->with('danger', $exception->getMessage());
        }
    }

    /**
     * @return Factory|View
     */
    public function settings()
    {
        return view('settings')->with('settings', Setting::all());
    }

    public function export()
    {
        return view('export')->with('export', Client::all()->take(10));
    }

    public function exportCommand(Request $request)
    {
        foreach (Client::all()->pluck('email') as $email) {
            if ('' !== $email) {
                echo "$email,\n";
            }
        }
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

        $tickets = Ticket::where('email', 'like', '%' . $request->q . '%')
            ->orWhere('name', 'like', '%' . $request->q . '%')
            ->orWhere('message', 'like', '%' . $request->q . '%')->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'category' => __('tickets'),
                    'display' => ucfirst(strtolower($item->name)),
                    'description' => "{$item->title}",
                    'url' => "/ticket/$item->id",
                ];
            })->toArray();

        return response()->json([
            'items' => mb_convert_encoding(array_merge($tickets, array_merge($clients, $invoices)), 'UTF-8', 'UTF-8')
        ]);
    }

}
