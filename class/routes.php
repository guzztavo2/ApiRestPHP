<?php

class routes
{
    private static $url;
    const ROTAS = ['/', 'Produtos'];
    const REQUESTS = ['GET', 'PUT', 'DELETE'];
    public function __construct()
    {
        $this->validarMethodRequest();

        switch (self::getLocation()) {
            case '/':
                $this->home();
                return;

            case 'Produtos':
                $this->produtos();
                return;
            default:
                throw new OutOfRangeException('Essa rota não existe');
        }


    }
    public function home()
    {
        die('home');
    }
    public function produtos()
    {

        die('produtos');
    }

    public function validarMethodRequest()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (self::$url === '/') {
            if ($requestMethod !== 'GET')
                throw new UnexpectedValueException('O tipo de método:' . $requestMethod . '. Não é valido aqui.');
        } else if (self::$url === 'Produtos') {
            $codigoProduto = (isset($_GET['codigo'])) ? filter_input(INPUT_GET, 'codigo', FILTER_VALIDATE_INT) : null;
            switch ($requestMethod) {
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
                    throw new UnexpectedValueException('O tipo de método:' . $requestMethod . '. Não é valido aqui.');
            }
        }

    }
    public static function getLocation()
    {
        self::setLocation();
        return self::$url;
    }
    private static function setLocation()
    {
        self::$url = (isset($_GET['url'])) ? (string) filter_input(INPUT_GET, 'url', FILTER_DEFAULT) : '/';
    }
    public static function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }


}