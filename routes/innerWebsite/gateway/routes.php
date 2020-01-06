<?php

$url = 'API\InnerWebsite\Transaction\WebsitePaymentTransactionTemporaryController';

Route::get('/pay/{payer_identification}', $url.'@index');

Route::post('/store_payment_data', $url.'@store_payment_data');

Route::post('/get_payment_data', $url.'@get_payment_data');

Route::post('/pay', 'API\InnerWebsite\Transaction\WebsitePaymentTransactionController@store')->name('pay');