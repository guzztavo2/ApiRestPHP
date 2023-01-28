<?php

namespace classe;

use controller\ProdutoController as ProdutoController;
use model\app;
use model\CRON;

class routes
{
    private static $url;
    const HOME_URL = HOME_URL;
    const REQUESTS = ['GET', 'PUT', 'DELETE'];
    const listOFGETREQUEST = ['buscar', 'pagina'];
    const ROTAS = ['home', 'produtos', 'sobre', 'css', 'js'];
    private $requestMethod;
    public function __construct()
    {
        $this->validarMethodRequest();
        $this->validarRotas();
    }

    private function validarRotas()
    {
        $localAtual = self::getLocation();


        switch ($localAtual[0]) {

            case 'home':
                if (count($localAtual) > 1)
                    self::redirect(self::HOME_URL . 'home');
                $this->home();
                break;
            case 'sobre':

                $this->sobre();
            break;
            case 'produtos':
                if (count($localAtual) > 3)
                    self::redirect(self::HOME_URL . 'produtos');

                if (isset($localAtual[1]) && $localAtual[1] === 'id') {

                    if ($localAtual[2] === null || strlen($localAtual[2]) === 0)
                        self::redirect(self::HOME_URL . 'produtos');

                } else if (isset($localAtual[1]) && strpos($localAtual[1], '?') !== false) {

                    $requestGET = $_GET;
                    $resultado = [];

                    foreach (array_keys($requestGET) as $request) {
                        foreach (self::listOFGETREQUEST as $_request) {
                            if ($request == $_request)
                                $resultado[] = $request;
                        }
                    }
                    if (count($resultado) !== count($requestGET))
                        self::redirect(self::HOME_URL . 'produtos');

                }
                $this->produtos();
                break;

            case 'js':
                header("Content-type: text/javascript", true);

                switch ($localAtual[1]) {
                    case 'bootstrap':
                        $dir = ProdutoController::assetsDir . '\\js\\bootstrap.bundle.min.js';
                        include($dir);
                        exit;
                    case 'code':
                        $dir = ProdutoController::assetsDir . '\\js\\code.js';
                        include($dir);
                        exit;
                    default:
                        self::redirect(self::HOME_URL);
                }
                break;

            case 'css':
                header("Content-type: text/css", true);

                switch ($localAtual[1]) {

                    case 'bootstrap':
                        $dir = ProdutoController::assetsDir . '\\css\\bootstrap.min.css';
                        include($dir);
                        exit;
                    case 'style':
                        $dir = ProdutoController::assetsDir . '\\css\\style.css';
                        include($dir);
                        exit;
                    default:
                        self::redirect(self::HOME_URL);
                }
                break;
        }
        exit;
    }

    private function checkFirstConnectInServer()
    {


        if (!app::checkExist()) {
            if (!database::verificarErros()) {
                database::verificarCriarAPPTabela();
                $app = new app();
                $app->salvar();
            }

            ProdutoController::primeiraConexao();
        }
    }

    public function home()
    {
        $this->checkFirstConnectInServer();
        if ($this->requestMethod !== 'GET')
            throw new \UnexpectedValueException('O tipo de método:' . $this->requestMethod . '. Não é valido aqui.');

        ProdutoController::home();
    }
    public function sobre()
    {
        $this->checkFirstConnectInServer();
        if ($this->requestMethod !== 'GET')
            throw new \UnexpectedValueException('O tipo de método:' . $this->requestMethod . '. Não é valido aqui.');

        ProdutoController::sobre();
    }
    public function CronUpdateWindowsTask()
    {
        $datetime = new \DateTime('now');
        $datetime = $datetime->format('h');

        if ($datetime == '04') {
            $cron = new CRON();
            $cron->executarCron();
            routes::redirect(routes::HOME_URL);
        } else {

            if ($this->requestMethod === 'PUT') {

                $cron = new CRON();
                $cron->executarCron();
                exit('finalizado');
            } else
                exit('Esse método: ' . $this->requestMethod . '.<br>Não é valido para atualizar o serviço. <br> <a href="' . routes::HOME_URL . '">Clique aqui e volte para o inicio</a>');
        }
    }
    public function produtos()
    {
        $this->checkFirstConnectInServer();

        if (gettype(self::getLocation()) === 'array') {
            if (!isset(self::getLocation()[2]))
                $codigoProduto = null;
            else
                $codigoProduto = strlen(self::getLocation()[2]) > 0 ? (string) self::getLocation()[2] : null;
        } else
            $codigoProduto = null;


        switch ($this->requestMethod) {
            case 'GET':
                if (!isset($codigoProduto)) {
                    ProdutoController::todosProdutos();
                } else {
                    ProdutoController::visualizarPaginaProduto($codigoProduto);
                }
                break;
            case 'PUT':
                if ($codigoProduto === null)
                    throw new \InvalidArgumentException('É necessário fornecer o código do produto para ser atualizado.');
                else
                    ProdutoController::editarProduto($codigoProduto);
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

        foreach (self::REQUESTS as $request) {
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

        $url = explode('/', $url);
        array_shift($url);
        array_shift($url);
        foreach (self::ROTAS as $rota) {
            if ($url[0] == $rota) {
                self::$url = $url;
                return;
            }
        }

        self::redirect(self::HOME_URL . 'home');
    }

    public static function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }
}
