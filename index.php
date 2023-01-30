<?php
use model\CRON;
require_once('./config.php');
use classe\database;
use controller\ProdutoController;

CRON::criarAgendaCRON();
$error = [];
try {
    database::verificarCriarTabelas();
} catch (PDOException $e) {
    $error[] = ['bancoDadosError' => $e->getMessage()]; 
}

if(count($error) > 0)
    new ProdutoController($error);
else
    new ProdutoController();

exit;

?>