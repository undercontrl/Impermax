<?php
require_once __DIR__.'/../Models/agendamento.php';
require_once __DIR__.'/../Models/avaliacao.php';
require_once __DIR__.'/../Models/contato.php';
require_once __DIR__.'/../Models/endereco.php';
require_once __DIR__.'/../Models/item_agendamento.php';
require_once __DIR__.'/../Models/item_orcamento.php';
require_once __DIR__.'/../Models/Usuario.php';
require_once __DIR__.'/../Models/servico.php';
require_once __DIR__.'/../Models/projeto.php';
require_once __DIR__.'/../Models/pagamento.php';
require_once __DIR__.'/../Models/orcamento.php';
require_once __DIR__.'/../Models/material.php';
require_once __DIR__.'/../Database/database.php';
 



// $item_orcamento = new item_orcamento($db);
// $resultado = $item_orcamento->buscarItemOrcamento();
// $resultado = $item_orcamento->buscarItemOrcamentoPorOrcamento(1);
// $resultado = $item_orcamento->buscarItemOrcamentoPorServico(1);
// $resultado = $item_orcamento->buscarItemOrcamentoPorStatus('ativo');
// $resultado = $item_orcamento->buscarItemOrcamentoPorId(1);
// $resultado = $item_orcamento->excluirAgendamento();
// var_dump($resultado);


// $item_agendamento = new item_agendamento($db);
// $resultado = $item_agendamento->buscarItemAgendamento();
// $resultado = $item_agendamento->buscarItemAgendamentoPorAgendamento(1);
// $resultado = $item_agendamento->buscarItemAgendamentosPorCliente(1);
// $resultado = $item_agendamento->buscarItemAgendamentoPorId(1);
// $resultado = $item_agendamento->excluirAgendamento();
// var_dump($resultado);


// $endereco = new Endereco($db);
// $resultado = $endereco->buscarEnderecos();
// $resultado = $endereco->buscarEnderecoPorCEP('01001-000');
// $resultado = $endereco->buscarEnderecoPorLogadouro('Rua das Flores');
// $resultado = $endereco->buscarEnderecoPorBairro('Centro');
// $resultado = $endereco->buscarEnderecoPorCidade('São Paulo');
// $resultado = $endereco->buscarEnderecoPorUsuario(1);
// $resultado = $endereco->buscarEnderecoPorId(1);
// $resultado = $endereco->excluirEndereco();
// var_dump($resultado);


// $contato = new Contato($db);
// $resultado = $contato->buscarContatos();
// $resultado = $contato->buscarContatosPorEmail('joao.silva@mail.com');
// $resultado = $contato->buscarContatosPorStatus('novo');
// $resultado = $contato->buscarContatosPorData('2025-06-02 09:10:00');
// $resultado = $contato->buscarContatosPorCliente('João Silva');
// $resultado = $contato->buscarContatoPorId(1);
// $resultado = $contato->excluirContato();
// var_dump($resultado);

// $agentamento = new Agendamento($db);
// $resultado = $agendamento->buscarAgendamentos();
// $resultado = $agendamento->buscarAgendamentosPorStatus('Pendente');
// $resultado = $agendamento->buscarAgendamentosPorData(2025-06-10);
// $resultado = $avaliacao->buscarAvaliacao();