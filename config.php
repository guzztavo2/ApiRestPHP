<?php
// CONFIGURAÇÕES GERAIS
ini_set('memory_limit', '-1');

if(!defined('HOME'))
    define('HOME', 'Projeto');

    if(!defined('URL'))
    define('URL', 'http://localhost/');

spl_autoload_register(function ($className) {
    $className = explode("\\", $className);
 
    if (file_exists($className[0].'/' . $className[1] . '.php'))
        require_once($className[0].'/' . $className[1] . '.php');

});

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
session_regenerate_id();
date_default_timezone_set('America/Sao_Paulo');
if (!defined('DATABASE'))
    define('DATABASE', array(
        'HOST' => 'localhost',
        'USERNAME' => 'root',
        'PASSWORD' => '',
        'DATABASE' => 'produtosAlimenticios'
    ));

// URL
if (!defined('HOME_URL'))
    define('HOME_URL', URL.HOME.'/');


// REDIRECIONAR POR SEGURANÇA
function redirectSecurity()
{
    ob_clean();
    header('location: ' . HOME_URL);
    die();
}


//REESCREVER O HTACCESS

reescreverHTACCESS();
function reescreverHTACCESS()
{
    $strHtaccess = "Options -Indexes
    RewriteEngine On
    RewriteCond %{SCRIPT_FILENAME} !-f
    RewriteCond %{SCRIPT_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [NC,L]
    SetEnvIf Referer ".HOME_URL." localreferer
    <FilesMatch \.(jpg|jpeg|png|gif|css|json|gz)$>
    Order deny,allow
    Deny from all
    Allow from env=localreferer
    </FilesMatch>
    ErrorDocument 403 /".HOME."/index.php
    ";
    $file = fopen('.htaccess', 'w');
    fwrite($file, $strHtaccess);
    fclose($file);


}
