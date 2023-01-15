<?php

namespace App;

use App\Connection;

class Dashboard
{
    private $database;

    public function __construct()
    {
        $this->database = new Connection();
    }

    public function show_orders_by_status(int $id_situacao)
    {
        $sql = "SELECT 
                pd.id, 
                gt.descricao as gateway,
                pd.id_loja,
                pgto.descricao as forma_pagamento, 
                ps.descricao as situacao,
                pdp.retorno_intermediador,
                pdp.data_processamento
            FROM pedidos pd
            INNER JOIN pedidos_pagamentos pdp ON pdp.id_pedido = pd.id
            INNER JOIN formas_pagamento pgto ON pgto.id = pdp.id_formapagto
            INNER JOIN pedido_situacao ps ON ps.id = pd.id_situacao
            INNER JOIN lojas_gateway lj ON lj.id_loja = pd.id_loja
            INNER JOIN gateways gt ON gt.id = lj.id_gateway
            WHERE ps.id = $id_situacao
            ORDER BY gt.descricao ASC";

        echo
            '<table class="table text-center table-striped table-bordered">' .
                '<thead class="thead-dark">' .
                    '<tr>' .
                        '<th scope="col">#</th>' .
                        '<th scope="col">Gateway</th>' .
                        '<th scope="col">Loja</th>' .
                        '<th scope="col">Forma Pgto.</th>' .
                        '<th scope="col">Situação</th>' .
                        '<th scope="col">Retorno</th>' .
                        '<th scope="col">Dt. Processamento</th>' .
                    '</tr>' .
            '</thead>'
        ;

        foreach($this->database->connect->query($sql) as $itens) { 
            echo 
                '<tbody>' .
                    '<tr>' . 
                        '<th scope="row">' . $itens['id'] . '</th>' .
                        '<td>' . $itens['gateway'] . '</td>' .
                        '<td>' . $itens['id_loja'] . '</td>' .
                        '<td>' . $itens['forma_pagamento'] . '</td>' .
                        '<td>' . $itens['situacao'] . '</td>' .
                        '<td>' . $itens['retorno_intermediador'] . '</td>' .
                        '<td>' . $itens['data_processamento'] . '</td>' .
                    '</tr>' . 
                '</tbody>'
            ; 
        }

        echo '</table>';
    }
}


?>