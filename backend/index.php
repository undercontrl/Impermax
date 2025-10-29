<?php
namespace App\Impermax;
require __DIR__.'/../vendor/autoload.php';
date_default_timezone_set('America/Sao_Paulo');
require_once __DIR__ . '/Core/Session.php';
use App\Impermax\Rotas\Rotas;
 
use Bramus\Router\Router;
$router = new Router();
 
$rotas = Rotas::get();
$router->setNamespace('App\Impermax\Controllers');
require_once __DIR__ . '/bootstrap.php';
 
foreach ($rotas as $metodhoHTTp => $rota) {
    foreach ($rota as $uri => $acao) {
        $metodoBramus = strtolower($metodhoHTTp);
        $router->{$metodoBramus}($uri, $acao); // a mágica acontece aqui
    }
}
 
$router->set404(function() {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '404, Rota não Encontrada';
});
 
$router->run();