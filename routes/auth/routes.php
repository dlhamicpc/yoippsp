<?php

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/home', function(){
        return redirect( 'http://account.yoippsp.com/login');
});

//Personal Account Registration
//view 
Route::get('/pa-register', 'Auth\Registration\PersonalRegisterController@showRegistrationForm');
    
Route::post('/pa-register', 'Auth\Registration\PersonalRegisterController@register')->name('pa_register');


//BillPayment Account Registration
//view
Route::get('/bpa-register', 'Auth\Registration\BillPaymentRegisterController@showRegistrationForm');

//register
Route::post('/bpa-register', 'Auth\Registration\BillPaymentRegisterController@register')->name('bpa_register');


//Website Account Registration
//view
Route::get('/wa-register', 'Auth\Registration\WebsiteRegisterController@showRegistrationForm');
//register
Route::post('/wa-register', 'Auth\Registration\WebsiteRegisterController@register')->name('wa_register');



//Bank Account Registration
//view
Route::get('/bank-register/{id}', 'Auth\Registration\BankRegisterController@showRegistrationForm');
//register
Route::post('/bank-register', 'Auth\Registration\BankRegisterController@register')->name('bank_register');


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