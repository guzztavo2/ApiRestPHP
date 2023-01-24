<?php

namespace controller;

use classe\routes;
use model\app;
use model\CRON;

class ProdutoController
{

    private const Header = 'view\componentes\header.php';
    private const Footer = 'view\componentes\footer.php';
    public const assetsDir = 'view\assets';

    public function __construct(array $hasError = null)
    {
        $_SESSION['error'] = $hasError !== null ? $hasError : [];
        new routes();
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


    public static function renderView(string $document, array $data = null, string $header = self::Header, string $footer = self::Footer)
    {
        extract($data);
        require_once($header);
        require_once('view/' . $document . '.php');
        require_once($footer);
    }

    public static function primeiraConexao()
    {        
        require_once('view/primeiraConexao.php');
        $_SESSION['primeiraConexao'] = true;
        exit;
    }

}