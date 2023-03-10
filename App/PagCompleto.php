<?php

namespace App;

use App\Connection;
use HTTP_Request2;
class PagCompleto
{
    private $database;

    public function __construct()
    {
        $this->database = new Connection();
    }

    public function send_API_request()
    {
        $sql =
            "SELECT pd.valor_total, pdp.*, cl.id as id_cliente, cl.nome, CASE WHEN cl.tipo_pessoa = 'F' THEN 'Individual' WHEN cl.tipo_pessoa = 'J' THEN 'Corporation' END as tipo_pessoa, cl.email, cl.cpf_cnpj, cl.data_nasc FROM lojas_gateway lj INNER JOIN pedidos pd ON pd.id_loja = lj.id_loja INNER JOIN pedidos_pagamentos pdp ON pdp.id_pedido = pd.id INNER JOIN clientes cl ON cl.id = pd.id_cliente WHERE lj.id_gateway = 1 AND pd.id_situacao = 1 AND pdp.id_formapagto = 3";

        foreach ($this->database->connect->query($sql) as $row) {

            $body = [
                'external_order_id' => $row['id_pedido'],
                'amount' => floatval($row['valor_total']),
                'card_number' => $row['num_cartao'],
                'card_cvv' => strval($row['codigo_verificacao']),
                'card_expiration_date' => $this->format_date($row['vencimento']),
                'card_holder_name' => $row['nome_portador'],
                'customer' => [
                    'external_id' => strval($row['id_cliente']),
                    'name' => $row['nome'],
                    'type' => $row['tipo_pessoa'],
                    'email' => $row['email'],
                    'documents' => [
                        'type' => $this->set_type_person($row['cpf_cnpj']),
                        'number' => $row['cpf_cnpj'],
                    ],
                    'birthday' => $row['data_nasc'],
                ],
            ];

            $return_api = $this->call_API(json_encode($body));
            $this->update_order_status($row['id_pedido'], $return_api);
            $this->update_intermediate_return($row['id_pedido'], $return_api);
        }
    }

    private function call_API(string $body)
    {
        $request = new HTTP_Request2();
        $request->setUrl(getenv('API_ENDPOINT_PAGCOMPLETO') . getenv('API_TOKEN_PAGCOMPLETO'));
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setBody($body);

        $response = $request->send();
        return $response->getBody();
    }

    private function update_order_status(int $id_pedido, string $return_api)
    {
        $array_return_api = json_decode($return_api, true);
        
        if(!$array_return_api['Error']) {

            if($array_return_api['Transaction_code'] == '00') {
                $sql = "UPDATE pedidos SET id_situacao = 2 WHERE id = $id_pedido";
            }

            if(
                $array_return_api['Transaction_code'] == '02' || 
                $array_return_api['Transaction_code'] == '03' || 
                $array_return_api['Transaction_code'] == '04'
            ) { 
                $sql = "UPDATE pedidos SET id_situacao = 3 WHERE id = $id_pedido";
            }

            $this->database->connect->query($sql);
        }
    }

    private function update_intermediate_return(int $id_pedido, string $return_api)
    {
        $array_return_api = json_decode($return_api, true);

        if(!$array_return_api['Error']) {
            $sql = "UPDATE pedidos_pagamentos SET retorno_intermediador = '" . $array_return_api['Transaction_code'] . " - " . $array_return_api['Message'] . "', data_processamento = '" . date('d-m-Y') . "' WHERE id_pedido = $id_pedido";

            $this->database->connect->query($sql);
        }
    }

    private function format_date(string $old_card_expiration_date)
    {
        $dismantled_date = explode('-', $old_card_expiration_date);

        $year = $dismantled_date[0];
        $year = substr($year, 2);

        $day = $dismantled_date[1];

        return $day . $year;
    }

    private function set_type_person(string $cpf_cnpj_rh)
    {
        if (strlen($cpf_cnpj_rh) == 11 || strlen($cpf_cnpj_rh) == 14) {
            return 'cpf';
        }

        return 'rg';
    }
}

?>