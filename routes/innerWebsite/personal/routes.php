<?php


Route::get('/', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/dashboard', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/transactions', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/exchange-rate', 'API\InnerWebsite\PersonalUserController@index');

//settings
Route::get('/card', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/profile', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/notification_settings', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/bill_payment_settings', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/notification_history', 'API\InnerWebsite\PersonalUserController@index');

//billpayments
Route::get('/water_payment', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/electricity_payment', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/dstv_payment', 'API\InnerWebsite\PersonalUserController@index');


//tickets
Route::get('/airplane_ticket', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/bus_ticket', 'API\InnerWebsite\PersonalUserController@index');

Route::get('/cinema_ticket', 'API\InnerWebsite\PersonalUserController@index');


Route::group(['prefix' => 'api'], __DIR__.'/api.php');

