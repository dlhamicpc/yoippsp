<?php
namespace App\YoippspFunctions\Database;


use App\Models\InnerWebsite\BankCredentials;

class ExternalDatabaseConnector
{
    private $bankCredentials;

    public $connection;

    private $host;
    private $driverType; //mysql, oracle....
    private $port;

    private $databaseName;
    private $userName;
    private $password;

    private $serverStatus;
    

    public function __construct( $bankID )
    {
        $this->bankCredentials = BankCredentials::where(['bank_id' =>$bankID ])->first()->get();
        $this->set_credentials();
        $this->make_connection();
    }

    private function set_credentials()
    {
        $this->driverType = $this->bankCredentials->driver_type;
        $this->host = $this->bankCredentials->host;
        $this->port = $this->bankCredentials->port;

        $this->databaseName = $this->bankCredentials->database_name;
        $this->userName = $this->bankCredentials->user_name;
        $this->password = $this->bankCredentials->password;
    }

    private function make_connection()
    {
        try {

            if( $this->serveStatus == true ){

                $this->connection = new PDO(
                    "$this->driverType:host=$this->host;$this->port;$this->databaseName", $this->userName, $this->password
                );

                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            dd('reached');
            $this->connection = false;

        } catch (PDOException $error) {

            $this->connection = false;
            //return $error->getMessage();

        }

    }

    final public static function connection()
    {
        return $this->connection;
    }





} 

