<?php
require_once __DIR__ . '/config/app.php';
use App\Dashboard;
$dashboard = new Dashboard();
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>FSN | API PagCompleto</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    </head>
    <body>
        <div class="container mt-3">
            
            <div class="row">
                <div class="col-lg-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-lg-6">
                    <a href="processing.php">
                        <button class="btn btn-info float-right">
                            Processar Pagamentos
                        </button>
                    </a>
                </div>
            </div>

            <h3 class="text-info mb-3">Pedidos (1 - Aguardando Pagamento)</h3>
            <?php $dashboard->show_orders_by_status(1); ?>

            <h3 class="text-info mb-3">Pedidos (2 - Pagamento Identificado)</h3>
            <?php $dashboard->show_orders_by_status(2); ?>

            <h3 class="text-info mb-3">Pedidos (3 - Pedido Cancelado)</h3>
            <?php $dashboard->show_orders_by_status(3); ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>