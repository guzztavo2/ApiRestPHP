<?php
use model\CRON;
require_once('./config.php');
use model\produto as Produto;

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
$produto = new Produto();
$produto = $produto->buscarPorCodigo('0000000000017');
$novoProduto = new Produto();
$novoProduto->code = '0005';
$produto->atualizar($novoProduto);
//$produto->salvar();


// for ($n = 0; $n < count($a->arquivos); $n++)
//     $a->execute($n);






//database::verificarCriarTabelas();



?>