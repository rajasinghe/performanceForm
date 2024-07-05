<?php
class DB
{
    public static $connection;
    static $hostName;
    static $userName;
    static $password;
    static $dbName;

    public function __construct()
    {
        try {
            //self::$connection = new mysqli(self::$hostName, self::$userName, self::$password, self::$dbName);
            $dbName = "./Database/database.accdb";
            if (!file_exists($dbName)) {
                throw new Exception("db connection file not found");
            }
            //data source name for microsoft access
            $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};DBQ=$dbName;";
            self::$connection = new PDO($dsn);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }



    public static function getConnection()
    {
        return self::$connection;
    }

    public static function initialize()
    {
    }
}
