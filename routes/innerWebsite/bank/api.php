<?php
use Illuminate\Http\Request;

//load Language
Route::get('/get_languages', 'LanguageController@index');


//load Time zone
Route::get('/get_time_zones', 'TimeZoneController@index');


//update bank_user details
Route::put('/update_bank_user_details', 'API\InnerWebsite\BankUserController@update_bank_user_details');


//update languages,time_zone
Route::put('/update_languages_time_zone', 'API\InnerWebsite\BankUserController@update_languages_time_zone');


//update email
Route::put('/update_email', 'API\InnerWebsite\BankUserController@update_email');


//update mobile_number
Route::put('/update_mobile_number', 'API\InnerWebsite\BankUserController@update_mobile_number');


//update password
Route::put('/update_password', 'API\InnerWebsite\BankUserController@update_password');


//update notification
Route::put('/update_notification_settings', 'API\InnerWebsite\BankUserController@update_notification_settings');


//update security
Route::put('/update_security_settings', 'API\InnerWebsite\BankUserController@update_security_settings');


//update profile avatar
Route::put('/update_avatar', 'API\InnerWebsite\BankUserController@update_avatar');


//update bank_logo
Route::put('/update_bank_logo', 'API\InnerWebsite\BankUserController@update_bank_logo');


//return transaction table
Route::get('/transactions', 'API\InnerWebsite\Transaction\TransactionController@index');


//Notification and Notify online existance
Route::get('/fetch_notification_and_notify_online', 'NotificationMessageController@fetch_notification_and_notify_online');


//make_notification_seen
Route::get('/make_notification_seen', 'NotificationMessageController@make_notification_seen');
