<?php

//YoippspCompany Admin
Route::group(['domain' => 'admin.yoippsp.com'], __DIR__.'/yoippspCompany/Admin/routes.php');

/* Route::group(['domain' => 'bank-manager.yoippsp.com'], __DIR__.'/yoippspCompany/Admin/routes.php'); */

//OuterWebsite
Route::group(['domain'=>'yoippsp.com'], __DIR__.'/outerWebsite/routes.php');

//OuterWebsite text for mobile
// Route::group(['middleware' => 'guest', 'domain'=>'192.168.43.98'], __DIR__.'/outerWebsite/routes.php');

//Authentication/ Registration for users
Route::group(['middleware' => 'guest', 'domain' => 'account.yoippsp.com'], __DIR__.'/auth/routes.php');

/* Route::group(['middleware' => 'guest', 'domain' => '192.168.43.98'], __DIR__.'/auth/routes.php');

 */
Route::get('/login', function(){
    return redirect( 'http://account.yoippsp.com/login');
});

Route::get('/{any}-register', function($type){
    return redirect('http://account.yoippsp.com/'.$type.'-register');
});

//For account users
Route::group([ 'middleware' => 'auth', 'domain' => 'account.yoippsp.com' ], __DIR__.'/innerWebsite/routes.php');

/* //For account users
Route::group([ 'middleware' => 'auth', 'domain' => '192.168.43.98' ], __DIR__.'/innerWebsite/routes.php'); */

//for testing error page
Route::group(['middleware' => 'guest'], __DIR__.'/errors/routes.php');

//Auth::routes();

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['domain' => 'gateway.yoippsp.com' ], __DIR__.'/innerWebsite/gateway/routes.php');

/* Route::group(['domain' => '192.168.43.98' ], __DIR__.'/innerWebsite/gateway/routes.php'); */