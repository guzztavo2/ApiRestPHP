<?php
require_once('./config.php');
use model\produto as Produto;
use model\status as Status;

use controller\ProdutoController;



new ProdutoController();


// try{
// database::verificarCriarTabelas();
// }catch(Exception $e){
    
//     echo ($e->getMessage());
// }
// $a = new files();
// $a->execute(0);
//new routes();
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
