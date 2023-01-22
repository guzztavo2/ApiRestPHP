<?php
namespace classe;

use controller\ProdutoController as ProdutoController;

class routes
{
    private static $url;
    const HOME_URL = HOME_URL;
    const ROTAS = ['/', 'Produtos'];
    const REQUESTS = ['GET', 'PUT', 'DELETE'];

    private $requestMethod;
    public function __construct()
    {
      
        $this->validarMethodRequest();
        $this->validarCaminho();
      


    }
    private function validarCaminho(){
        $url = '';
        if (!isset(self::getLocation()[1]))
            $url = '/';
        else
            $url = self::getLocation()[1];

        switch ($url) {
            case '/':
                $this->home();
                return;
            case 'css':
                if(count(self::getLocation())  == 3){
                 
                    header("Content-type: text/css", true);                                            

                    switch(self::getLocation()[2]){

                        case 'bootstrap':
                            $dir = ProdutoController::assetsDir.'\\css\\bootstrap.min.css';
                            include($dir);
                            exit;
                        case 'bootstrap_map':
                            $dir = ProdutoController::assetsDir.'\\css\\bootstrap.min.css.map';
                            include($dir);
                            exit;
                        case 'style':
                            $dir = ProdutoController::assetsDir.'\\css\\style.css';
                            include($dir);
                            exit;
                        default:
                        self::redirect(self::HOME_URL);
                    }
                }else
                    self::redirect(self::HOME_URL);               
            break;
            case 'js':
                if(count(self::getLocation())  == 3){
                 
                    header("Content-type: text/javascript", true);                                            

                    switch(self::getLocation()[2]){

                        case 'bootstrap':
                            $dir = ProdutoController::assetsDir.'\\js\\bootstrap.bundle.min.js';
                            include($dir);
                            exit;
                        case 'bootstrap_map':
                            $dir = ProdutoController::assetsDir.'\\js\\bootstrap.bundle.min.js.map';
                            include($dir);
                            exit;
                        case 'code':
                            $dir = ProdutoController::assetsDir.'\\js\\code.js';
                            include($dir);
                            exit;
                        default:
                        self::redirect(self::HOME_URL);
                    }
                }else
                    self::redirect(self::HOME_URL);   
            break;
            case 'Produtos':
                $this->produtos();
                return;
            default:
                self::redirect(HOME_URL);
        }
    }
    public function home()
    {
        if ($this->requestMethod !== 'GET')
        throw new \UnexpectedValueException('O tipo de método:' . $this->requestMethod . '. Não é valido aqui.');

        ProdutoController::home();
    }
    public function produtos()
    {
        $codigoProduto = (isset($_GET['codigo'])) ? filter_input(INPUT_GET, 'codigo', FILTER_VALIDATE_INT) : null;
        switch ($this->requestMethod) {
            case 'GET':
                if ($codigoProduto === null)
                    exit('Todos os produtos');
                else
                    exit('Mostrar o produto de id:' . $codigoProduto);
                break;
            case 'PUT':
                if ($codigoProduto === null)
                    throw new \InvalidArgumentException('É necessário fornecer o código do produto para ser atualizado.');
                else
                    exit('Atualizar o produto de id:' . $codigoProduto);
                break;
            case 'DELETE':
                if ($codigoProduto === null)
                    throw new \InvalidArgumentException('É necessário fornecer o código do produto para ser deletado.');
                else
                    exit('Deletar o produto de id:' . $codigoProduto);
                break;
            default:
                throw new \UnexpectedValueException('O tipo de método:' . $this->requestMethod . '. Não é valido aqui.');
        }

    }

    public function validarMethodRequest()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach(self::REQUESTS as $request){
            if ($this->requestMethod === $request)
                return;
        }
        throw new \UnexpectedValueException('Esse tipo de método não é permitido nessa aplicação.');
    }
    public static function getLocation()
    {
        self::setLocation();
        return self::$url;
    }
    private static function setLocation()
    {
        $url = (string)\filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
        $url = str_replace('/' . HOME, '', $url);
        $url = explode('/', $url);
        $url_test = $url[1];
        if (strlen($url_test) === 0)
            $url = '/';
            self::$url = $url;
    }

    public static function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }


}