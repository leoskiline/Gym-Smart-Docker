<?php

namespace Config;

use PDO;

Class Connection {
    private $driver = "mysql";
    private $host = "host.docker.internal";
    private $database = "feminina";
    private $user = "root";
    private $password = "root";
    public static $singletonConnection = null;


    public function __construct()
    {
       if(!self::$singletonConnection)
            self::$singletonConnection = new PDO("$this->driver:dbname=$this->database;host=$this->host", $this->user, $this->password); 
    }
 
    public static function getConnection()
    {
        return self::$singletonConnection;
    }
}
?>