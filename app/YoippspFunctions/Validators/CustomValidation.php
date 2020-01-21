<?php
namespace App\YoippspFunctions\Validators;

//use Illuminate\Support\Facades\Validator;

class CustomValidation{

    public function name($attribute,$value, $parameters)
    {
        return preg_match("/^[a-zA-Z ]*$/",$value);
    }

    public function gender($attribute,$value, $parameters)
    {
        return $value === 'M' || $value === 'F';
    }

    public function mobile_number($attribute,$value, $parameters)
    {
        if( $value[0] == '0' && strlen($value) > 9 ){
            $value = substr( $value, 1 );
        }

        return preg_match("/^[0-9 ]*$/",$value);
    }

  /*   public function city($attribute,$value, $parameters)
    {
        return preg_match("/^[a-zA-Z ]*$/",$value);
    }

    public function state($attribute,$value, $parameters)
    {
        return preg_match("/^[a-zA-Z ]*$/",$value);
    }

    public function country($attribute,$value, $parameters)
    {
        return preg_match("/^[a-zA-Z ]*$/",$value);
    } */

}
