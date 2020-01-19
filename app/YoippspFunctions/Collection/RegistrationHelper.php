<?php
namespace App\YoippspFunctions\Collection;

use Illuminate\Support\Carbon;

class RegistrationHelper 
{


    public static function find_age($date_of_birth)
    {
        $age = Carbon::now()->addYear()->diffForHumans($date_of_birth);
        return (int)explode(' ' ,$age)[0];
    }

    public static function fix_mobile_number($mobile_number)
    {
        if( $mobile_number[0] == '0' ){

            return (int) $mobile_number;

        }else if( $mobile_number[0] == '+' ){

            return substr( $mobile_number, 4 );

        }else if( $mobile_number[0] == '2' ){

            return substr( $mobile_number, 3 );

        }
        else{
            return $mobile_number;
        }
    }

    public static function fix_date( $date )
    {
        if( substr_count($date,'-') == 2 ){
            $month_day_year = explode('-', $date);
            return $month_day_year[2].'-'.$month_day_year[0].'-'.$month_day_year[1];
        }
        return $date;   
    }
}