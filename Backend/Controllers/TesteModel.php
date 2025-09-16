<?php
require_once __DIR__.'/../Models/servico.php';
require_once __DIR__.'/../Models/Usuario.php';
require_once __DIR__.'/../Database/Database.php';

$servico = new Servicos($db);
// $resultado = $servico->buscarServicos();
// $resultado = $servico->buscarServicosPorNome('Laudo Técnico de Infiltração');
$resultado = $servico->buscarServicosPorStatus('ativo');
// $resultado=$usuario ->excluirUsuario(1);
var_dump($resultado);
