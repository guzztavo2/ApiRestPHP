<?php
require_once('./config.php');
require_once('./model/produto.php');
require_once('./class/database.php');
use model\produto as Produto;
use model\status as Status;

$produto = new Produto();
database::verificarCriarTabelas();

$a = new files();
$a->execute(0);


$a->getResultFiles();



try{
new routes();
}catch(Exception $e){
    echo $e->getMessage();
}



//database::verificarCriarTabelas();



?>