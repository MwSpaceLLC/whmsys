<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param Request $request
     * @return void
     */
    public function boot(Request $request)
    {
        if (!file_exists(base_path('.env')) && $request->userAgent() !== 'Symfony') {
            return abort(503, 'PLEASE INSTALL WHMSYS');
        }

        Schema::defaultStringLength(191);

        if (!$request->secure() && env('APP_SSL') && !strpos($request->url(), 'localhost') !== false) {
            return redirect()->secure($request->getRequestUri());
        }

    }
}
