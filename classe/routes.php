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

    private $requestMethod;
    public function __construct()
    {
        $this->validarMethodRequest();
        $this->validarRotas();
    }
    private function verificarGetRequest(string $url)
    {
        if (count($_GET) > 0) {
            if ($url === 'produtos') {
                foreach ($_GET as $key => $value) {
                    if (in_array($key, self::listOFGETREQUEST))
                        return;
                }
                routes::redirect(routes::HOME_URL);
            } else
                routes::redirect(routes::HOME_URL);
        }
    }
    private function validarRotas()
    {

        if (gettype(self::getLocation())  === 'array' && count(self::getLocation()) >= 3)
            $url = self::getLocation()[1];
        else if (!isset(self::getLocation()[1]))
            $url = '/';
        else
            $url = self::getLocation();


        switch ($url) {
            case '/':
                self::verificarGetRequest('home');
                $this->home();
                return;
            case 'produtos':
                self::verificarGetRequest('produtos');
                $this->produtos();
                return;
            case 'CronUpdateWindowsTask':

                $this->CronUpdateWindowsTask();
                break;
            case 'css':
                if (count(self::getLocation()) == 3) {

                    header("Content-type: text/css", true);

                    switch (self::getLocation()[2]) {

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
                } else
                    self::redirect(self::HOME_URL);
                break;
            case 'js':
                if (count(self::getLocation())  == 3) {

                    header("Content-type: text/javascript", true);

                    switch (self::getLocation()[2]) {

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
                } else
                    self::redirect(self::HOME_URL);
                break;

            default:
                self::redirect(HOME_URL);
        }
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
        
        if (gettype(self::getLocation()) === 'array' && isset(self::getLocation()[2])) {
            if(count(self::getLocation()) > 4 )
                self::redirect(self::HOME_URL.'produtos');
            
            if (self::getLocation()[2] === 'id') {
                if (!isset(self::getLocation()[3]))
                    $codigoProduto = null;
                else
                    $codigoProduto = strlen(self::getLocation()[3]) > 0 ? (string) self::getLocation()[3] : null;
            } else {
                self::redirect(self::HOME_URL . 'produtos');
            }
        }     

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

        $url = str_replace('/' . HOME, '', $url);
        $url = explode('/', $url);


        $url_test = $url[1];

        if (strlen($url_test) === 1) {
            self::redirect(self::HOME_URL);
        }

        if (gettype($url) === 'array') {

            if (count($url) >= 3) {
                self::$url = $url;
                return;
            }
            $url = explode('?', $url[1]);

            self::$url = $url[0];
            return;
        }

        self::$url = $url;
    }

    public static function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }
}
