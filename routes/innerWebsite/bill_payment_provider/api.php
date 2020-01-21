<?php
use Illuminate\Http\Request;


//load bank names for link card get_languages
Route::get('/get_bank_names', 'API\InnerWebsite\UserCardLinkController@index');


//load Language
Route::get('/get_languages', 'LanguageController@index');


//load Time zone
Route::get('/get_time_zones', 'TimeZoneController@index');


//load Water Payment Provider
Route::get('/get_water_service_providers', 'API\InnerWebsite\BillPaymentUserController@get_water_service_providers');


//load Electricity Payment Provider
Route::get('/get_electricity_service_providers', 'API\InnerWebsite\BillPaymentUserController@get_electricity_service_providers');


//load DSTV Payment Provider
Route::get('/get_dstv_service_providers', 'API\InnerWebsite\BillPaymentUserController@get_dstv_service_providers');


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


//update bill_payment_provider details
Route::put('/update_bill_payment_provider_details', 'API\InnerWebsite\BillPaymentUserController@update_bill_payment_provider_details');


//update languages,time_zone
Route::put('/update_languages_time_zone', 'API\InnerWebsite\BillPaymentUserController@update_languages_time_zone');


//update email
Route::put('/update_email', 'API\InnerWebsite\BillPaymentUserController@update_email');


//update mobile_number
Route::put('/update_mobile_number', 'API\InnerWebsite\BillPaymentUserController@update_mobile_number');


//update password
Route::put('/update_password', 'API\InnerWebsite\BillPaymentUserController@update_password');


//update notification
Route::put('/update_notification_settings', 'API\InnerWebsite\BillPaymentUserController@update_notification_settings');


//update security
Route::put('/update_security_settings', 'API\InnerWebsite\BillPaymentUserController@update_security_settings');


//update profile avatar
Route::put('/update_avatar', 'API\InnerWebsite\BillPaymentUserController@update_avatar');


//update_water_payment_info
Route::put('/update_water_payment_info', 'API\InnerWebsite\UserBillPaymentLinkController@update_water_payment_info');


//update_electricity_payment_info
Route::put('/update_electricity_payment_info', 'API\InnerWebsite\UserBillPaymentLinkController@update_electricity_payment_info');


//update_dstv_payment_info
Route::put('/update_dstv_payment_info', 'API\InnerWebsite\UserBillPaymentLinkController@update_dstv_payment_info');


//delete_bill_payment_link
Route::post('/delete_bill_payment_link', 'API\InnerWebsite\UserBillPaymentLinkController@delete_bill_payment_link');


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

//start_accepting_payment
Route::post('/start_accepting_payment', 'API\InnerWebsite\BillPaymentPostController@store');