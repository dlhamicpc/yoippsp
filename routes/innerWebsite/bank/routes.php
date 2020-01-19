<?php


Route::get('/', 'API\InnerWebsite\BankUserController@index');

Route::get('/dashboard', 'API\InnerWebsite\BankUserController@index');

Route::get('/transactions', 'API\InnerWebsite\BankUserController@index');

Route::get('/exchange-rate', 'API\InnerWebsite\BankUserController@index');

//settings

Route::get('/profile', 'API\InnerWebsite\BankUserController@index');

Route::get('/notification_settings', 'API\InnerWebsite\BankUserController@index');

Route::get('/notification_history', 'API\InnerWebsite\BankUserController@index');

////
Route::get('/bank_managers', 'BankManagerController@index');

Route::get('/add_new_bank_manager', 'BankManagerController@create');

Route::post('/add_new_bank_manager', 'BankManagerController@store')->name('add_new_bank_manager');

Route::get('/bank_managers/{bankManager}','BankManagerController@show');

Route::get('/bank_managers/{bankManager}/edit','BankManagerController@edit');

Route::patch('/bank_managers/{bankManager}','BankManagerController@update')->name('update_bank_manager');

Route::delete('/bank_managers/{bankManager}','BankManagerController@destroy');

///////



Route::get('/customer_list_card', 'API\InnerWebsite\BankUserController@customer_list_card');

Route::get('/customer_list_account', 'API\InnerWebsite\BankUserController@customer_list_account');

Route::get('/payment_detail', 'API\InnerWebsite\BankUserController@payment_detail');

Route::group(['prefix' => 'api'], __DIR__.'/api.php');

