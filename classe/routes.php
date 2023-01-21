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
        switch (self::getLocation()) {
            case '/':
                $this->home();
                return;

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
        throw new UnexpectedValueException('O tipo de método:' . $this->requestMethod . '. Não é valido aqui.');

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
                    throw new InvalidArgumentException('É necessário fornecer o código do produto para ser atualizado.');
                else
                    exit('Atualizar o produto de id:' . $codigoProduto);
                break;
            case 'DELETE':
                if ($codigoProduto === null)
                    throw new InvalidArgumentException('É necessário fornecer o código do produto para ser deletado.');
                else
                    exit('Deletar o produto de id:' . $codigoProduto);
                break;
            default:
                throw new UnexpectedValueException('O tipo de método:' . $this->requestMethod . '. Não é valido aqui.');
        }

    }

    public function validarMethodRequest()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach(self::REQUESTS as $request){
            if ($this->requestMethod === $request)
                return;
        }
        throw new UnexpectedValueException('Esse tipo de método não é permitido nessa aplicação.');
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
        $url = $url[1];
        if (strlen($url) === 0)
            $url = '/';
        self::$url = $url;
    }
    public static function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }


}