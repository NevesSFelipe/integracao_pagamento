<?php


require_once 'vendor/autoload.php';
require_once 'vendor/pear/http_request2/HTTP/Request2.php';

use App\PagCompleto;

$teste = new PagCompleto;
$teste->send_API_request();







?>

