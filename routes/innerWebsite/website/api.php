<?php
use Illuminate\Http\Request;


//load bank names for link card get_languages
Route::get('/get_bank_names', 'API\InnerWebsite\UserCardLinkController@index');


//load Language
Route::get('/get_languages', 'LanguageController@index');


//load Time zone
Route::get('/get_time_zones', 'TimeZoneController@index');


//link card
Route::post('/link_card', 'API\InnerWebsite\UserCardLinkController@store');


//update card
Route::put('/update_card/{id}', 'API\InnerWebsite\UserCardLinkController@update');


//delete card
Route::delete('/delete_card/{id}', 'API\InnerWebsite\UserCardLinkController@destroy');


//link bank account
Route::post('/link_bank', 'API\InnerWebsite\UserBankLinkController@store');


//delete bank account
Route::delete('/delete_bank_account/{id}', 'API\InnerWebsite\UserBankLinkController@destroy');

//update_website_detail
Route::put('/update_website_details', 'API\InnerWebsite\WebsiteUserController@update_website_details');

//update languages,time_zone
Route::put('/update_languages_time_zone', 'API\InnerWebsite\WebsiteUserController@update_languages_time_zone');


//update email
Route::put('/update_email', 'API\InnerWebsite\WebsiteUserController@update_email');


//update mobile_number
Route::put('/update_mobile_number', 'API\InnerWebsite\WebsiteUserController@update_mobile_number');


//update password
Route::put('/update_password', 'API\InnerWebsite\WebsiteUserController@update_password');


//update notification
Route::put('/update_notification_settings', 'API\InnerWebsite\WebsiteUserController@update_notification_settings');


//update security
Route::put('/update_security_settings', 'API\InnerWebsite\WebsiteUserController@update_security_settings');


//update profile avatar
Route::put('/update_avatar', 'API\InnerWebsite\WebsiteUserController@update_avatar');


//get card and bank link
Route::get('/get_card_bank_link', 'API\InnerWebsite\DepositController@index');


//return transaction table
Route::get('/transactions', 'API\InnerWebsite\Transaction\TransactionController@index');


//Transfering Money
Route::post('/send_money', 'API\InnerWebsite\Transaction\SendTransactionController@send_transaction');


//Request Money
Route::post('/request_money', 'API\InnerWebsite\Transaction\RequestMoneyTransactionController@request_money_transaction');


//Transfering-Deposit Money
Route::post('/deposit_money', 'API\InnerWebsite\Transaction\DepositTransactionController@deposit_transaction');


//Transfering-Withdraw Money
Route::post('/withdraw_money', 'API\InnerWebsite\Transaction\WithdrawTransactionController@withdraw_transaction');


//Notification and Notify online existance
Route::get('/fetch_notification_and_notify_online', 'NotificationMessageController@fetch_notification_and_notify_online');


//make_notification_seen
Route::get('/make_notification_seen', 'NotificationMessageController@make_notification_seen');

Route::patch('/update_api_key', 'API\InnerWebsite\WebsiteUserController@update_api_key');