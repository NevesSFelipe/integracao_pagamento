<?php

namespace App;

use PDO;
use PDOException;

class Connection
{
    public $connect;

    public function __construct()
    {
        try {
            $this->connect = new PDO("pgsql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>