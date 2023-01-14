<?php

namespace App;

use App\Connection;

class PagCompleto {

    private $database;

    public function __construct()
    {
        $this->database = new Connection;
    }

    public function select_payment_orders()
    {
        $sql = "SELECT lj.id_gateway, pd.id_loja, pdp.id_formapagto, pd.id_situacao FROM lojas_gateway lj INNER JOIN pedidos pd ON pd.id_loja = lj.id_loja INNER JOIN pedidos_pagamentos pdp ON pdp.id_pedido = pd.id WHERE lj.id_gateway = 1 AND pd.id_situacao = 1 AND pdp.id_formapagto = 3";

        foreach($this->database->connect->query($sql) as $row) {
            print "<br/>";
            print $row['id_gateway'] . " / " . $row['id_loja'] . " / " . $row['id_formapagto'] . " / " . $row['id_situacao'];
        }

    }

}


?>