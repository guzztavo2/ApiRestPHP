<?php

namespace controller;

use classe\routes;
use Exception;
use model\app;
use model\CRON;
use model\produto;

class ProdutoController
{
    const porPagina = 5;
    private const Header = 'view\componentes\header.php';
    private const Footer = 'view\componentes\footer.php';
    public const assetsDir = 'view\assets';

    public function __construct(array $hasError = null)
    {
        $_SESSION['error'] = $hasError !== null ? $hasError : [];
        try {
            new routes();
        } catch (Exception $e) {
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
    public static function getPaginaAtual()
    {
        return isset($_GET['pagina']) ? (int)filter_input(INPUT_GET, 'pagina', FILTER_DEFAULT) : 1;
    }
    private static function gerarProdutos()
    {        
        $todosProdutos = produto::selecioneTodos();
        if(count($todosProdutos) > 0){
        $totalPaginas = (int)ceil(count($todosProdutos) / self::porPagina);
        $pagina = (int)self::getPaginaAtual();
        $inicio = $pagina - 1;
        $inicio = $inicio * self::porPagina;

        if($pagina <= 0 || $pagina > $totalPaginas || gettype($pagina) !== 'integer')
            routes::redirect(routes::HOME_URL.'produtos');

  

        $todosProdutos = produto::find(['LIMIT ' . $inicio . ',' . self::porPagina]);

        if (self::gerarBuscaSQL() !== false) {
            $todosProdutos = produto::find([self::gerarBuscaSQL()]);
            $totalPaginas = (int)ceil(count($todosProdutos) / self::porPagina);
            $todosProdutos = produto::find([self::gerarBuscaSQL() . ' LIMIT ' . $inicio . ',' . self::porPagina]);
        }

        return (object) ['totalPaginas' => $totalPaginas, 'todosProdutos' => $todosProdutos];
    }
    return false;
    }
    private static function gerarBuscaSQL(): string | false
    {
        $buscar = isset($_GET['buscar']) ? filter_input(INPUT_GET, 'buscar', FILTER_DEFAULT) : null;
        $codeSQL = '';
        
        if ($buscar !== null && strlen($buscar) > 0 && strlen($buscar) < 30) {
            $keysProduto = new produto();
            $keysProduto = array_keys($keysProduto->getListProperties());
            $keysProduto = array_map(function ($val) {
                return $val .= ' LIKE "%?%" OR ';
            }, $keysProduto);
            $keysProduto = implode('', $keysProduto);
            $keysProduto = substr($keysProduto, 0, -3);
            $keysProduto = str_replace('?', $buscar, $keysProduto);
            $codeSQL = 'WHERE ' . $keysProduto;
            return $codeSQL;
        } else
            return false;
    }
    public static function editarProduto($codigoProduto){
        // Qualquer valor está sendo aceito em qualquer coluna!!!!....
        $produto = new produto();
        $keys = array_keys($produto->getListProperties());
        if(file_get_contents('php://input') === null || strlen(file_get_contents('php://input')) === 0){
            echo 'Para atualizar esse produto, você precisa enviar uma requisição JSON, nessa seguinte ordem: <br>';
            $keys = array_keys($produto->getListProperties());
            foreach($keys as $key)
            echo $key.'<br>';
            echo 'PS: campos vazios serão ignorados! E as chaves não precisam ser nomeadas. Apenas enviar os dados enumerados. <br>Se você quiser atualizar uma coluna única, será necessário adicionar valores vazios até chegar na informação desejada.';
        }
        $produtoAntigo = produto::find(['WHERE `code` = ?', [$codigoProduto]]);
        if(count($produtoAntigo) == 0)
            exit('Esse produto não existe ou foi removido!');
        
        $produtoAntigo = $produtoAntigo[0];
        $produto = clone $produtoAntigo;       

       $arrayUpdates = (array)json_decode(file_get_contents('php://input'));
       if(count($arrayUpdates) === 0 || count($arrayUpdates) > count($keys))
       exit('A requisição está em formato incorreto.');

       $arrayUpdates = array_values($arrayUpdates);       

       for($n = 0; $n < count($arrayUpdates); $n++){
        if(strlen($arrayUpdates[$n]) > 0)
            $produto->{$keys[$n]} = $arrayUpdates[$n];
        }
        $produto->setStatus(produto::DRAFT);
    
      $produto->salvar($produtoAntigo->{'code'});
      exit('Produto atualizado com sucesso!');
    }
    public static function deletarProduto($codigoProduto){
        $produtoAntigo = produto::find(['WHERE `code` = ?', [$codigoProduto]]);
        $produtoAntigo = $produtoAntigo[0];
        $produto = clone $produtoAntigo;    

        $produto->setStatus(produto::TRASH);
        $produto->salvar($produtoAntigo->{'code'});
        exit('Produto atualizado com sucesso!');
    }
    public static function todosProdutos()
    {
        
        $paginacao = self::gerarProdutos();
        if($paginacao == false){
            self::renderView('produtos');
        }
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
        if($data !== null)
        extract($data);

        require_once($header);
        require_once('view/' . $document . '.php');
        require_once($footer);
    }
    public static function gerarPaginaURL($getRequest): string
    {
        
        $buscar = isset($_GET['buscar']) ? filter_input(INPUT_GET, 'buscar', FILTER_DEFAULT) : null;
        if ($buscar !== null)
            return routes::HOME_URL . routes::getLocation()[0] . '/?' . http_build_query(['buscar' => $buscar, 'pagina' => $getRequest]);
        else
            return routes::HOME_URL . routes::getLocation()[0] . '/?' . http_build_query(['pagina' => $getRequest]);
    }
    public static function visualizarPaginaProduto($idProduto)
    {
        $produto = new produto();
        $produto = $produto->find(['WHERE `code` = ?', [$idProduto]])[0];  
        $cron = new CRON();
        $cron = $cron->selecione();
        if (isset($_SESSION['error'][0]['bancoDadosError']))
            self::renderView('produto', [
                'bancoErro' => $_SESSION['error'][0]['bancoDadosError'],

            ]);
        else
            self::renderView('produto', [
              'produto' => $produto,
              'ultimaVezAtualizado' => $cron->ultimaExecucao
            ]);
    }
    public static function primeiraConexao()
    {
        require_once('view/primeiraConexao.php');
        $_SESSION['primeiraConexao'] = true;
        exit;
    }
    public static function sobre(){
        self::renderView('sobre');
    }
}
