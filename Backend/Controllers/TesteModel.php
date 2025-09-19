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
require_once __DIR__.'/../Database/Database.php';

// $usuario = new Usuario($db);
// $resultado = $usuario->buscarUsuarios();
// $resultado = $usuario->buscarUsuariosPorEmail('');
// $resultado = $usuario->buscarUsuariosPorTipo('admin');
// $resultado = $usuario->buscarUsuariosPorStatus('');
// $resultado = $usuario->inserirUsuario('Ariane', 'ariane@impermax.com', '32hrfkjwe', 'funcionario', 'ativo');
// $resultado = $usuario->atualizarUsuario($nome, $email, $senha, $tipo, $status);
// $resultado=$usuario ->excluirUsuario(21);





// $servico = new Servicos($db);
// $resultado = $servico->buscarServicos();
// $resultado = $servico->buscarServicosPorNome('');
// $resultado = $servico->buscarServicosPorStatus('ativo');
// $resultado = $usuario->inserirServico($nome, $descricao, $valor, $foto, $status);
// $resultado = $usuario->atualizaServico($nome, $descricao, $valor, $foto, $status);
// $resultado = $servico ->excluirServico(1);





// $projeto = new Projeto($db);
// $resultado = $projeto->buscarProjetos();
// $resultado = $projeto->buscarProjetosPorDescricao('');
// $resultado = $usuario->inserirProjeto($foto_antes, $foto_depois, $descricao));
// $resultado = $usuario->atualizarProjeto($foto_antes, $foto_depois, $descricao));
// $resultado = $projeto ->excluirProjeto(1);





// $pagamento = new Pagamento($db);
// $resultado = $pagamento->buscarPagamentos();
// $resultado = $pagamento->buscarPagamentosPorStatus('aberto');
// $resultado = $usuario->inserirPagamento($id_cliente, $total_devedor, $dinheiro, $credito, $debito, $pix, $status_pagamento, $data_pagamento);
// $resultado = $usuario->atualizarPagamento($id_cliente, $total_devedor, $dinheiro, $credito, $debito, $pix, $status_pagamento, $data_pagamento);
// $resultado = $pagamento ->excluirPagamentos(1);





// $orcamento = new Orcamento($db);
// $resultado = $orcamento->buscarOrcamentos();
// $resultado = $orcamento->buscarOrcamentosPorStatus('aguardando');
// $resultado = $orcamento->buscarOrcamentosPorIdCliente('9');
// $resultado = $usuario->inserirOrcamento($id_cliente, $descricao_orcamento, $status_orcamento, $data_orcamento, $valor_orcamento, $total_item_orcamento);
// $resultado = $usuario->atualizarOrcamentos($id_cliente, $descricao_orcamento, $status_orcamento, $data_orcamento, $valor_orcamento, $total_item_orcamento);
// $resultado = $orcamento ->excluirOrcamentos(1);





// $material = new Material($db);
// $resultado = $material->buscarMateriais();
// $resultado = $material->buscarMateriaisPorNome('Calha Metálica Galvanizada');
// $resultado = $material->buscarMateriaisIdServico('1');
// $resultado = $usuario->inserirMaterial($nome_material, $qtd_material, $descricao_material, $id_servico);
// $resultado = $usuario->atualizarMateriais($nome_material, $qtd_material, $descricao_material, $id_servico);
// $resultado = $material ->excluirMateriais(1);


var_dump($resultado);
