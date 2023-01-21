<?php

namespace controller;

use classe\routes;
class ProdutoController{

    private const Header = 'view\componentes\header.php';
    private const Footer = 'view\componentes\footer.php';



    public function __construct(){
        new routes();
    }
    public static function home(){
        $ola = 'AAA';

        self::renderView('home', ['ola' => $ola]);
    }


    public static function renderView(string $document, array $data = null,string $header = self::Header,string $footer = self::Footer){
        extract($data);
        require_once($header);
        require_once('view/'.$document.'.php');
        require_once($footer);
    }



}