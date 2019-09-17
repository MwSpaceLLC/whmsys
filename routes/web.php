<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@welcome')->name('welcome');

Route::post('/'.config('app.login_path'), 'Auth\LoginController@login');

Route::get('/'.config('app.login_path'), 'Auth\LoginController@showLoginForm')->name('login');

Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');

Route::get('/logout', 'HomeController@logout')->name('logout')->middleware('auth');

Route::get('/clients', 'HomeController@clients')->name('clients')->middleware('auth');

Route::get('/client/{id}', 'HomeController@client')->name('client')->middleware('auth');

Route::get('/client/{id}/invoices', 'HomeController@clientInvoices')->name('client.invoices')->middleware('auth');

Route::get('/client/{id}/cleanly', 'HomeController@clientCleanly')->name('client.cleanly')->middleware('auth');

Route::get('/client/{id}/invoices/cleanly', 'HomeController@clientInvoicesCleanly')->name('client.invoices.cleanly')->middleware('auth');

Route::get('/invoices', 'HomeController@invoices')->name('invoices')->middleware('auth');

Route::get('/invoices/{status}', 'HomeController@invoicesFinder')->name('invoices.find')->middleware('auth');

Route::get('/invoice/{id}', 'HomeController@invoice')->name('invoice')->middleware('auth');

Route::get('/invoice/{id}/cleanly', 'HomeController@invoiceCleanly')->name('invoice.cleanly')->middleware('auth');

Route::get('/tickets', 'HomeController@tickets')->name('tickets')->middleware('auth');

Route::get('/ticket/open', 'HomeController@ticketOpen')->name('tickets.open')->middleware('auth');

Route::get('/tickets/{status}', 'HomeController@ticketsFinder')->name('tickets.find')->middleware('auth');

Route::get('/ticket/{id}', 'HomeController@ticket')->name('ticket')->middleware('auth');

Route::get('/ticket/{id}/cleanly', 'HomeController@ticketCleanly')->name('ticket.cleanly')->middleware('auth');

Route::get('/settings', 'HomeController@settings')->name('settings')->middleware('auth');

Route::get('/export', 'HomeController@export')->name('export')->middleware('auth');

Route::get('/export/{comand}', 'HomeController@exportCommand')->name('export.comand')->middleware('auth');

Route::get('/search/{q}', 'HomeController@search')->name('search')->middleware('auth');

// Script Run model based
Route::get('/script/{model}/{id}/{selectors}', 'HomeController@script')->name('script')->middleware('auth');
