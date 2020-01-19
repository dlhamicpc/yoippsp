<?php

$url_temp = 'API\InnerWebsite\Transaction\WebsitePaymentTransactionTemporaryController';

$url_real = 'API\InnerWebsite\Transaction\WebsitePaymentTransactionController';

$url_check_credential = 'API\InnerWebsite\Gateway\WebsitePaymentCredentialCheckController';

Route::post('/store_payment_data', $url_temp.'@store_payment_data');

Route::get('/pay/{payer_identification}', $url_real.'@index');

Route::post('/get_payment_data/{payer_identification}', $url_real.'@get_payment_data');

Route::post('/pay', $url_check_credential.'@login')->name('pay');