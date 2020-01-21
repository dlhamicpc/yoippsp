<?php
namespace App\YoippspFunctions\Collection;


class FindDomain 
{
    public static function find_domain( $baseUrl )
    {
        if( request()->ip() != '127.0.0.1'  ){
            return "http://192.168.43.98/";
        }
        return $baseUrl;
    }
}