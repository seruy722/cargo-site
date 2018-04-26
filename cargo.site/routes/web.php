<?php

use App\Exports\InvoicesExport;

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

// Route::get('/', function () {
//     return view('welcome');
// });
//  Route::post('importfile', 'ExelController@getImport')->name('importfile');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'CargoController@home');
Route::get('/cargos', 'CargoController@cargos')->name('cargo');
Route::get('/debts', 'CargoController@debts')->name('debt');

Route::post('/search', 'CargoController@search')->name('search');
Route::post('/downloadexcel', 'ExcelController@saveToExcel');

Route::resource('api/clients', 'Api\ClientController');
Route::resource('api/cargos', 'Api\CargoController');
Route::resource('api/debts', 'Api\DebtController');
Route::post('api/search/cargos', 'Api\CargoController@search');
Route::post('api/search/debts', 'Api\DebtController@search');