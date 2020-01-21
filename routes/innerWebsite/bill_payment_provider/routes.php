<?php


Route::get('/', 'API\InnerWebsite\BillPaymentUserController@index');

Route::get('/dashboard', 'API\InnerWebsite\BillPaymentUserController@index');

Route::get('/transactions', 'API\InnerWebsite\BillPaymentUserController@index');

Route::get('/exchange-rate', 'API\InnerWebsite\BillPaymentUserController@index');

//settings
Route::get('/card', 'API\InnerWebsite\BillPaymentUserController@index');

Route::get('/profile', 'API\InnerWebsite\BillPaymentUserController@index');

Route::get('/notification_settings', 'API\InnerWebsite\BillPaymentUserController@index');

Route::get('/bill_payment_settings', 'API\InnerWebsite\BillPaymentUserController@index');

Route::get('/notification_history', 'API\InnerWebsite\BillPaymentUserController@index');


Route::get('/customer_list', 'API\InnerWebsite\BillPaymentUserController@customer_list');
Route::get('/payment_detail', 'API\InnerWebsite\BillPaymentUserController@payment_detail');
Route::get('/bill_summary', 'API\InnerWebsite\BillPaymentUserController@bill_summary');


//tickets
Route::get('/airplane_ticket', 'API\InnerWebsite\BillPaymentUserController@index');

Route::get('/bus_ticket', 'API\InnerWebsite\BillPaymentUserController@index');

Route::get('/cinema_ticket', 'API\InnerWebsite\BillPaymentUserController@index');


Route::group(['prefix' => 'api'], __DIR__.'/api.php');

