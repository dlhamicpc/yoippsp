<?php

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Auth::routes();


//Personal Account Registration
//view 
Route::get('/pa-register', 
    'Auth\Registration\PersonalRegisterController@showRegistrationForm'
)->name('pa_register');
    
Route::post('/pa-register', 'Auth\Registration\PersonalRegisterController@register');


//BillPayment Account Registration
//view
Route::get('/bpa-register', 
        'Auth\Registration\BillPaymentRegisterController@showRegistrationForm'
)->name('bpa_register');

//register
Route::post('/bpa-register', 'Auth\Registration\BillPaymentRegisterController@register');


//Website Account Registration
//view
Route::get('/wa-register', 
        'Auth\Registration\WebsiteRegisterController@showRegistrationForm'
)->name('wa_register');
//register
Route::post('/wa-register', 'Auth\Registration\WebsiteRegisterController@register');


/* 
//Business Account Registration
//view
Route::get('/ba-register', 
        'Auth\Registration\BusinessRegisterController@showRegistrationForm'
)->name('ba_register');
//register
Route::post('/ba-register', 'Auth\Registration\BusinessRegisterController@register');



//ServiceProvider Account Registration
//view
Route::get('/spa-register', 
        'Auth\Registration\ServiceProviderRegisterController@showRegistrationForm'
)->name('spa_register');
//register
Route::post('/spa-register', 'Auth\Registration\ServiceProviderRegisterController@register');



//Bank Account Registration
//view
Route::get('/bka-register', 
        'Auth\Registration\BankRegisterController@showRegistrationForm'
)->name('bka_register');
//register
Route::post('/bka-register', 'Auth\Registration\BankRegisterController@register');

*/




 

/*
|--------------------------------------------------------------------------
| End of Authentication Routes
|--------------------------------------------------------------------------
*/