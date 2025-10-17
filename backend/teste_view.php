
<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Impermax\Core\View;

error_reporting(E_ALL);
ini_set('display_errors', 1);

View::render("contato/index", ["contatos" => [["nome_contato" => "Teste", "email_contato" => "teste@teste.com"]]]);
