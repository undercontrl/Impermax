<?php
require_once __DIR__.'/../Models/agendamento.php';
require_once __DIR__.'/../Models/avaliacao.php';
require_once __DIR__.'/../Models/contato.php';
require_once __DIR__.'/../Models/endereco.php';
require_once __DIR__.'/../Models/item_agendamento.php';
require_once __DIR__.'/../Models/item_orcamento.php';
require_once __DIR__.'/../Database/database.php';
 
$agendamento = new Agendamento($db);
// $resultado = $agendamento->buscarAgendamentosPorStatus('Pendente');
// $resultado = $agendamento->buscarAgendamentos();
// $resultado = $usuario->buscarUsuariosPorEmail('malu@xxxxx.com');
// $resultado = $usuario->excluirUsuario(1);
// $resultado = $agendamento->buscarAgendamentosPorData(2025-06-10);
var_dump($resultado);