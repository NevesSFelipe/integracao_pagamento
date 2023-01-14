<?php

namespace App;

use Exception;

class Connection {

    const HOST = "localhost";
    const USER = "postgres";
    const PASS ="qwe@123";
    const BANK = "teste";

    private $connect;

    public function __construct()
    {
        $this->connect = pg_connect("host=" . self::HOST . " dbname=" . self::BANK . " user=" . self::USER . " password=" . self::PASS);
        echo "Conexão efetuada com sucesso!!";  
    }



}

?>