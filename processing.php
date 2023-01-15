<?php

require_once __DIR__ . '/config/app.php';

use App\PagCompleto;
$pagCompleto = new PagCompleto();
$pagCompleto->send_API_request();
header('Location: index.php');

?>