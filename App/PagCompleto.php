<?php

namespace App;

use App\Connection;

class PagCompleto {

    private $database;

    public function __construct()
    {
        $this->database = new Connection;
    }

    public function send_API_request()
    {
        $sql = "SELECT pd.valor_total, pdp.*, cl.id as id_cliente, cl.nome, CASE WHEN cl.tipo_pessoa = 'F' THEN 'Individual' WHEN cl.tipo_pessoa = 'J' THEN 'Corporation' END as tipo_pessoa, cl.email, cl.cpf_cnpj, cl.data_nasc FROM lojas_gateway lj INNER JOIN pedidos pd ON pd.id_loja = lj.id_loja INNER JOIN pedidos_pagamentos pdp ON pdp.id_pedido = pd.id INNER JOIN clientes cl ON cl.id = pd.id_cliente WHERE lj.id_gateway = 1 AND pd.id_situacao = 1 AND pdp.id_formapagto = 3";

        foreach($this->database->connect->query($sql) as $row) {

            $body = [                
                'external_order_id' => $row['id'],
                'amount' => $row['valor_total'],
                'card_number' => $row['num_cartao'],
                'card_cvv' => $row['codigo_verificacao'],
                'card_expiration_date' => $row['vencimento'],
                'card_holder_name' => $row['nome_portador'],
                'customer' => [
                    'external_id' => $row['id_cliente'],
                    'name' => $row['nome'],
                    'type' => $row['tipo_pessoa'],
                    'email' => $row['email'],
                    'documents' => [
                            'type' => $this->set_type_person($row['cpf_cnpj']),
                            'number' => $row['cpf_cnpj']
                        
                    ],
                    'birthday' => $row['data_nasc']
                ]
            ];

            $call_API = json_encode($body);
        }

    }

    private function set_type_person(string $cpf_cnpj_rh)
    {
        if(strlen($cpf_cnpj_rh) == 11 || strlen($cpf_cnpj_rh) == 14) {
            return 'cpf';
        }

        return 'rg';
    }

}


?>