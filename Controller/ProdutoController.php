<?php

namespace controller;

use classe\routes;
use Exception;
use model\app;
use model\CRON;
use model\produto;

class ProdutoController
{
    const porPagina = 10;
    private const Header = 'view\componentes\header.php';
    private const Footer = 'view\componentes\footer.php';
    public const assetsDir = 'view\assets';

    public function __construct(array $hasError = null)
    {
        $_SESSION['error'] = $hasError !== null ? $hasError : [];
        try{
        new routes();
    }catch(Exception $e){
        echo $e->getMessage();
        exit;
    }
    
    }

    public static function home()
    {
        $cron = new CRON();
        $app = new app();
        $app = $app->selecione();
        $cron = $cron->selecione();


        if (isset($_SESSION['error'][0]['bancoDadosError']))
            self::renderView('home', [
                'bancoErro' => $_SESSION['error'][0]['bancoDadosError'],

            ]);
        else
            self::renderView('home', [
                'cron' => $cron,
                'app' => $app
            ]);
    }
    public static function getPaginaAtual(){
        return isset($_GET['pagina']) ? (int)filter_input(INPUT_GET, 'pagina', FILTER_DEFAULT) : 1;

    }
    private static function gerarProdutos()
    {
        $buscar = isset($_GET['buscar']) ? filter_input(INPUT_GET, 'buscar', FILTER_DEFAULT) : null;
        $codeSQL = '';
        if ($buscar !== null && strlen($buscar) > 0) {
            $keysProduto = new produto();
            $keysProduto = array_keys($keysProduto->getListProperties());
            $keysProduto = array_map(function($val){
                return $val .= ' LIKE "%?%" OR ';
            },$keysProduto);
            $keysProduto = implode('', $keysProduto);
            $keysProduto = substr($keysProduto, 0, -3);
            $keysProduto = str_replace('?', $buscar, $keysProduto);
            $codeSQL = 'WHERE '. $keysProduto;

            $pagina = self::getPaginaAtual();
            
            $inicio = $pagina - 1;
            $inicio = $inicio * self::porPagina;
            $todosProdutos = produto::find([$codeSQL.' LIMIT ' . $inicio . ',' . self::porPagina]);
            $totalPaginas = (int)ceil(count($todosProdutos) / self::porPagina);


        }else{
            $pagina = self::getPaginaAtual();
            $todosProdutos = produto::selecioneTodos();
            $totalPaginas = (int)ceil(count($todosProdutos) / self::porPagina);

            $inicio = $pagina - 1;
            $inicio = $inicio * self::porPagina;
            $todosProdutos = produto::find(['LIMIT ' . $inicio . ',' . self::porPagina]);

        }
        return (object) ['totalPaginas' => $totalPaginas, 'todosProdutos' => $todosProdutos];
    }
    public static function todosProdutos()
    {

        $paginacao = self::gerarProdutos();

        if (isset($_SESSION['error'][0]['bancoDadosError']))
            self::renderView('produtos', [
                'bancoErro' => $_SESSION['error'][0]['bancoDadosError'],

            ]);
        else
            self::renderView('produtos', [
                'Produtos' => $paginacao
            ]);
    }
    public static function renderView(string $document, array $data = null, string $header = self::Header, string $footer = self::Footer)
    {
       
        extract($data);

        require_once($header);
        require_once('view/' . $document . '.php');
        require_once($footer);
    }
    public static function gerarPaginaURL($getRequest):string{
        $buscar = isset($_GET['buscar']) ? filter_input(INPUT_GET, 'buscar', FILTER_DEFAULT) : null;
        if($buscar !== null)
            return routes::HOME_URL.routes::getLocation().'?'.http_build_query(['buscar' => $buscar, 'pagina' => $getRequest]);
        else
            return routes::HOME_URL.routes::getLocation().'?'.http_build_query(['pagina' => $getRequest]);

    

    }
    public static function primeiraConexao()
    {
        require_once('view/primeiraConexao.php');
        $_SESSION['primeiraConexao'] = true;
        exit;
    }
}
