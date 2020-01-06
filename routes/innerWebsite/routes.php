<?php
$dir = __DIR__;


Route::get('/' , function()
{
    $role_id = auth()->user()->role_id;
    
    switch($role_id){
        case 1:
            return redirect('http://admin.yoippsp.com'); //yoippsp admin
        case 2:
            return redirect('/bank/dashboard'); // bank user
        case 3:
            return redirect('/ba/dashboard'); // business user
        case 4:
            return redirect('/wa/dashboard'); // website user
        case 5:
            return  redirect('/pa/dashboard'); // personal user
        case 6:
            return redirect('/bpa/dashboard'); // bill payment user
        case 7:
            return redirect('/spa/dashboard'); // service provider user
        default:
            return redirect('http://yoippsp.com');
    }

});

Route::group(['prefix' => 'pa', 'middleware' => 'is_personal_user'], $dir.'/personal/routes.php');

Route::group(['prefix' => 'bpa', 'middleware' => 'is_bill_payment_provider_user'], $dir.'/bill_payment_provider/routes.php');

Route::group(['prefix' => 'wa', 'middleware' => 'is_website_user'], $dir.'/website/routes.php');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');
