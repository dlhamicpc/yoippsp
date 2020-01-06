<?php
use Illuminate\Http\Request;
use App\YoippspFunctions\Collection\RegistrationHelper;


function tryException($request, $tableName, $colName, $validationRule){
    try{
        $request->validate([
            'data' => "$validationRule:$tableName,$colName"
        ]);
        return '1';
    }
    catch(Exception $exception){
        return '0';
    }
}


Route::post('/email', function(Request $request){
    return tryException($request ,'users', 'email', 'unique');
});

Route::post('/{any}_mobile_number', function(Request $request , $any){
    $request['data'] = RegistrationHelper::fix_mobile_number($request['data']);
    return tryException($request, 'users', 'mobile_number', 'unique');
});

Route::post('/mobile_number', function(Request $request){
    $request['data'] = RegistrationHelper::fix_mobile_number($request['data']);
    return tryException($request, 'users', 'mobile_number', 'unique');
});

Route::post('/card_number', function(Request $request){
    $request->card_number = rtrim( chunk_split( $request->card_number , 4, "-" ), '-' );
    return tryException($request, 'user_card_links', 'card_number', 'unique');
});

//Checing for both mobile number and email
Route::post('/receiver_address', function(Request $request){

    if( (boolean)( tryException($request, 'users', 'mobile_number', 'exists') ) ){
        return "1";
    }
    else if( (boolean)( tryException($request, 'users', 'email', 'exists') ) ){
        return "1";
    }
    else{
        return "0";
    }
});

//Checing for both mobile number and email
Route::post('/receiver_address_request', function(Request $request){

    if( (boolean)( tryException($request, 'users', 'mobile_number', 'exists') ) ){
        return "1";
    }
    else if( (boolean)( tryException($request, 'users', 'email', 'exists') ) ){
        return "1";
    }
    else{
        return "0";
    }
});
