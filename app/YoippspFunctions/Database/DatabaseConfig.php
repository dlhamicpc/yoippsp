<?php
namespace App\YoippspFunctions\Database;


class DatabaseConfig
{

    /**
     * !!!!!!!!!!!!-----------CAUTION----------!!!!!!
     * Every database config name must start with the ff format => 
     * " external_database_DATABASE_TYPE_name "
     * DATABASE_TYPE = [bank, bill_payment, ticket]
     * */

    public static function bank_databases()
    {

        return [
            'external_database_bank_cbe' => [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'bank_cbe_db',
                'username'  => 'root',
                'password'  => 'secret',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
                'strict'    => false,
            ],

            'external_database_bank_awash' => [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'bank_awash_db',
                'username'  => 'root',
                'password'  => 'secret',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
                'strict'    => false,
            ]
            ,

            'external_database_bank_dashen' => [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'bank_dashen_db',
                'username'  => 'root',
                'password'  => 'secret',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
                'strict'    => false,
            ]
            ,

            'external_database_bank_oromia' => [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'dlhambank_db',
                'username'  => 'root',
                'password'  => 'secret',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
                'strict'    => false,
            ]
        ];
    
    }


    public const BILL_PAYMENT_DATABASES = array(

    );

    public const TICKET_DATABASES = array(

    );

    

}

