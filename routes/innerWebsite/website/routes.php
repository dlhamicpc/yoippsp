<?php


Route::get('/', 'API\InnerWebsite\WebsiteUserController@index');

Route::get('/dashboard', 'API\InnerWebsite\WebsiteUserController@index');

Route::get('/transactions', 'API\InnerWebsite\WebsiteUserController@index');

Route::get('/exchange-rate', 'API\InnerWebsite\WebsiteUserController@index');

Route::get('/customer_list', 'API\InnerWebsite\WebsiteUserController@customer_list');

Route::get('/payment_detail', 'API\InnerWebsite\WebsiteUserController@payment_detail');

Route::get('/api_documentation', 'API\InnerWebsite\WebsiteUserController@index');

//settings
Route::get('/card', 'API\InnerWebsite\WebsiteUserController@index');

Route::get('/profile', 'API\InnerWebsite\WebsiteUserController@index');

Route::get('/notification_settings', 'API\InnerWebsite\WebsiteUserController@index');

Route::get('/notification_history', 'API\InnerWebsite\WebsiteUserController@index');


//website management
Route::get('/customer_list', 'API\InnerWebsite\WebsiteUserController@customer_list');

Route::group(['prefix' => 'api'], __DIR__.'/api.php');

