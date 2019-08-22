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

Route::get('/invoices', 'HomeController@invoices')->name('invoices')->middleware('auth');

Route::get('/invoices/{status}', 'HomeController@invoicesFinder')->name('invoices.find')->middleware('auth');

Route::get('/invoice/{id}', 'HomeController@invoice')->name('invoice')->middleware('auth');

Route::get('/settings', 'HomeController@settings')->name('settings')->middleware('auth');

Route::get('/search/{q}', 'HomeController@search')->name('search')->middleware('auth');

// Script Run model based
Route::get('/script/{model}/{id}/{selectors}', 'HomeController@script')->name('script')->middleware('auth');
