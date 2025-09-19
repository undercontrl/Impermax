<?php
require_once __DIR__.'/../Models/agendamento.php';
require_once __DIR__.'/../Models/avaliacao.php';
require_once __DIR__.'/../Models/contato.php';
require_once __DIR__.'/../Models/endereco.php';
require_once __DIR__.'/../Models/item_agendamento.php';
require_once __DIR__.'/../Models/item_orcamento.php';
require_once __DIR__.'/../Database/database.php';
 
$item_orcamento = new item_orcamento($db);
// $resultado = $agendamento->buscarAgendamentosPorStatus('Pendente');
// $resultado = $agendamento->buscarAgendamentos();
// $resultado = $usuario->buscarUsuariosPorEmail('malu@xxxxx.com');
// $resultado = $usuario->excluirUsuario(1);
// $resultado = $agendamento->buscarAgendamentosPorData(2025-06-10);
// $resultado = $avaliacao->buscarAvaliacao();
// $resultado = $contato->buscarContatos();
// $resultado = $endereco->buscarEnderecos();
// $resultado = $item_agendamento->buscarItemAgendamento();
$resultado = $item_orcamento->buscarItemOrcamento();
var_dump($resultado);