<?php

namespace App;

use PDO;
use PDOException;

class Connection {

    const HOST = "localhost";
    const USER = "postgres";
    const PASS ="qwe@123";
    const DB_NAME = "teste";

    public $connect;

    public function __construct()
    {
        try {
            $this->connect = new PDO("pgsql:host=" . self::HOST . ";dbname=" . self::DB_NAME, self::USER, self::PASS);
        } catch(PDOException $e) {
            echo $e->getMessage();
        } 
    }



}

?>