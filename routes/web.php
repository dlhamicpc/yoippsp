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

Route::get('/', function () {
    return view('auth.login');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::view('sample','sample')->middleware('auth');
//Route::get('sample','sidebar@show');
Route::view('tansacton','teller.transaction');
Route::view('deposite','teller.deposite.deposite')->middleware('auth');
Route::post('deposite','deposite@show');
Route::view('deposite/check-account','teller/deposite/checkForAccount');
Route::view('transfer','teller.transfer');
Route::post('depositeMoney','deposite@store');

///withdrawal
Route::view('withdrawal','teller.withdrawal.withdrawal')->middleware('auth');
Route::get('withdrawal.check-account','withdrawal@show');
Route::post('withdrawal','withdrawal@list');
Route::post('withdrawalMoney','withdrawal@update');

//transaction
Route::view('transaction','teller.transaction.transaction')->middleware('auth');
Route::view('transactions/show','teller.transaction.showResult')->middleware('auth');
Route::post('transactions','transactionController@check');
Auth::routes();

///transfer
Route::view('transfer','teller.transfer.transfer');
Route::post('transfer','transferController@check');
Route::patch('checktransfer','transferController@update');

Route::view('sample-login','login');
Route::get('/home', 'HomeController@index')->name('home');
