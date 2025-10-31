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













// namespace App\Impermax;
// require __DIR__.'/../vendor/autoload.php';


// use Bramus\Router\Router;
// use App\Impermax\Rotas\Rotas;

// $router = new Router();
// $rotas = Rotas::get();

// $router->setNamespace('App\Impermax\Controllers');

// foreach($rotas as $metodoHttp => $rota){
//     foreach($rota as $uri => $acao){
//         $router->{$metodoHttp}($uri, $acao);
//     }
// }

// $router->set404(function() {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
//     echo '404, Página não encontrada';
// });

// $router->run();






// if(!isset($_SESSION)){
//             session_start();
//         }




// $rotas = Rotas::get();

// $metodoHttp = $_SERVER["REQUEST_METHOD"];
// $rota = $_SERVER["REQUEST_URI"];
// if(array_key_exists($rota, $rotas[$metodoHttp]) == false){
//     http_response_code(404);
//     echo "Página nao encontrada";
//     exit;
// }

// //              retorno string para separar em partes
// $partes = explode("@", $rotas[$metodoHttp][$rota]);
// $nomeController = $partes[0];
// $metodoController = $partes[1];
// $nomeCompletoController = "App\\Impermax\\Controllers\\" . $nomeController;
// if(!class_exists($nomeCompletoController)){
//     http_response_code(500);
//     echo "O controlador não encontrado";
//     exit;
// }
// $controller = new $nomeCompletoController();
// $controller->$metodoController();