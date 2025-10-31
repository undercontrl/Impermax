<?php

namespace App\Impermax\Rotas;

class Rotas
{
    public static function get()
    {
    return [
    "GET" => [
       // O caminho da url   O nome do controller que e o metodo do controller
       //login
       '/register' => 'AuthController@register',
       '/login' => 'AuthController@login',
       '/logout' => 'AuthController@logout',
       '/admin/dashboard' => 'Admin\DashboardController@index',
       '/funcionario/dashboard' => 'Funcionario\DashboardController@index',
       
       //perfil
       '/perfil' => 'PerfilController@index',
       
       //usuarios
        "/usuarios" => "UsuarioController@index",
        "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
        "/usuario/listar" => "UsuarioController@viewListarUsuarios",
        "/agendamento/ver/{id}" => "AgendamentoController@viewVerAgendamento",
        "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
        "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
        "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",
        "/usuario/visualizar/{id}" => "UsuarioController@viewVisualizarUsuario",
        //agendamentos
        "/agendamentos" => "AgendamentoController@index",
        "/agendamento/criar" => "AgendamentoController@viewCriarAgendamentos",
        "/agendamento/listar" => "AgendamentoController@viewListarAgendamentos",
        "/agendamento/editar/{id}" => "AgendamentoController@viewEditarAgendamentos",
        "/agendamento/excluir/{id}" => "AgendamentoController@viewExcluirAgendamentos",
        "/agendamento/{id}/relatorio/{dataInicial}/{dataFinal}" => "AgendamentoController@relatorioAgendamento",
        '/agendamento/deletar-multiplos' => 'AgendamentoController@deletarMultiplos',
        //avaliações
        "/avaliacoes" => "AvaliacaoController@index",
        "/avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacao",
        "/avaliacao/listar" => "AvaliacaoController@viewListarAvaliacao",
        "/avaliacao/editar/{id}" => "AvaliacaoController@viewEditarAvaliacao",
        "/avaliacao/excluir/{id}" => "AvaliacaoController@viewExcluirAvaliacao",
        "/avaliacao/{id}/relatorio/{dataInicial}/{dataFinal}" => "AvaliacaoController@relatorioAvaliacao",
        // contatos
        "/contatos" => "ContatoController@index",
        "/contato" => "ContatoController@viewListarContatos",
        "/contato/listar" => "ContatoController@viewListarContatos",
        "/contato/criar" => "ContatoController@viewCriar",
        "/contato/editar/{id}"=> "ContatoController@viewEditar",
        "/contato/excluir/{id}" => "ContatoController@viewExcluirContato",
        "/contato/{id}/relatorio/{dataInicial}/{dataFinal}" => "ContatoController@relatorioContato",
        "/teste-salvar" => "TesteController@salvar",
        '/contato/deletar-multiplos' => 'ContatoController@deletarMultiplos',
        // enderecos
        "/enderecos" => "EnderecoController@index",
        "/endereco/listar" => "EnderecoController@viewListarEnderecos",
        "/endereco/visualizar/{id}" => "EnderecoController@viewVisualizarEndereco",
        "/endereco/criar" => "EnderecoController@viewCriarEndereco",
        "/endereco/editar/{id}" => "EnderecoController@viewEditarEndereco",
        "/endereco/excluir/{id}" => "EnderecoController@viewExcluirEndereco",
        "/endereco/buscar-cep" => "EnderecoController@buscarCep",
        // itens de agendamento
        "/item_agendamento" => "ItemAgendamentoController@index",
        "/item_agendamento/listar" => "ItemAgendamentoController@viewListarItemAgendamento",
        "/item_agendamento/criar" => "ItemAgendamentoController@viewCriarItemAgendamento",
        "/item_agendamento/editar/{id}" => "ItemAgendamentoController@viewEditarItemAgendamento",
        "/item_agendamento/excluir/{id}" => "ItemAgendamentoController@viewExcluirItemAgendamento",
        "/item_agendamento/{id}/relatorio/{dataInicial}/{dataFinal}" => "ItemAgendamentoController@relatorioItemAgendamento",        
        // item_orcamento
        "/item_orcamento" => "ItemOrcamentoController@index",
        "/item_orcamento/listar" => "ItemOrcamentoController@viewListarItemOrcamento",
        "/item_orcamento/criar" => "ItemOrcamentoController@viewCriarItemOrcamento",
        "/item_orcamento/editar/{id}" => "ItemOrcamentoController@viewEditarItemOrcamento",
        "/item_orcamento/excluir/{id}" => "ItemOrcamentoController@viewExcluirItemOrcamento",
        //servico
        "/servico" => "ServicoController@index",
       "/servico/criar" => "ServicoController@viewCriarServicos",
       "/servico/listar" => "ServicoController@viewListarServicos",
        "/servico/listar/{pagina}" => "ServicoController@viewListarServicos",
        "/servico/buscar" => "ServicoController@buscar",
        "api/servicos" => "PublicApiController@getServicos",
        "/servico/editar/{id}" => "ServicoController@viewEditarServicos",
        "/servico/excluir/{id}" => "ServicoController@viewExcluirServicos",

        "/servico/sugestoes" => "ServicoController@sugestoes",

        // Dashboard do Site
        "/servico-site" => "ServicoSiteController@index",                   
        "/servico-site/listar" => "ServicoSiteController@listar",           
        "/servico-site/listar/{pagina}" => "ServicoSiteController@listar",  
        "/servico-site/criar" => "ServicoSiteController@criar",             
        "/servico-site/editar/{id}" => "ServicoSiteController@editar",      
        "/servico-site/alternar/{id}" => "ServicoSiteController@alternar",
        //projeto
        "/projeto" => "ProjetoController@index",
        "/projeto/criar" => "ProjetoController@viewCriarProjetos",
        "/projeto/listar" => "ProjetoController@viewListarProjetos",
        "/projeto/ver/{id}" => "ProjetoController@viewVerProjeto",
        "/projeto/editar/{id}" => "ProjetoController@viewEditarProjetos",
        "/projeto/excluir/{id}" => "ProjetoController@viewExcluirProjetos",
        //pagamento
        "/pagamento" => "PagamentoController@index",
        "/pagamento/criar" => "PagamentoController@viewCriarPagamentos",
        "/pagamento/listar" => "PagamentoController@viewListarPagamentos",
        "/pagamento/ver/{id}" => "PagamentoController@viewVerPagamento",
        "/pagamento/editar/{id}" => "PagamentoController@viewEditarPagamentos",
        "/pagamento/excluir/{id}" => "PagamentoController@viewExcluirPagamentos",
        //orcamento
        "/orcamento" => "orcamentoController@index",
        "/orcamento/criar" => "orcamentoController@viewCriarOrcamentos",
        "/orcamento/listar" => "orcamentoController@viewListarOrcamentos",
        "/orcamento/visualizar/{id}" => "OrcamentoController@viewVisualizarOrcamento",
        "/orcamento/editar/{id}" => "orcamentoController@viewEditarOrcamentos",
        "/orcamento/excluir/{id}" => "orcamentoController@viewExcluirOrcamentos",
        //material
        "/material" => "materialController@index",
        "/material/criar" => "materialController@viewCriarMateriais",
        "/material/listar" => "materialController@viewListarMateriais",
        "/material/editar/{id}" => "materialController@viewEditarMateriais",
        "/material/excluir/{id}" => "materialController@viewExcluirMateriais",

        
    ],
    "POST" => [
        //login
        '/register' => 'AuthController@cadastrarUsuario',
        '/login' => 'AuthController@authenticar',
        "/authenticar" => "AuthController@authenticar",
        
        //perfil
        '/perfil/atualizar' => 'PerfilController@atualizar',
        '/perfil/atualizar-senha' => 'PerfilController@atualizarSenha',
        '/perfil/atualizar-foto' => 'PerfilController@atualizarFoto',
        '/perfil/remover-foto' => 'PerfilController@removerFoto',
        
        //usuarios
        "/usuario/salvar" => "UsuarioController@salvarUsuario",
        "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
        "/usuario/deletar/{id}" => "UsuarioController@deletarUsuario",
        "/usuario/alterar-status-massa" => "UsuarioController@alterarStatusEmMassa",
        "/usuario/excluir-massa" => "UsuarioController@excluirEmMassa",
        //agendamentos
        "/agendamento/salvar" => "AgendamentoController@salvarAgendamento",
        "/agendamento/atualizar/{id}" => "AgendamentoController@atualizarAgendamento",
        "/agendamento/deletar/{id}" => "AgendamentoController@deletarAgendamento",
        "/agendamento/deletar-multiplos" => "AgendamentoController@deletarMultiplos",
        "/agendamento/buscar-orcamentos-ajax" => "AgendamentoController@buscarOrcamentosPorClienteAjax",
        //avaliações
        "/avaliacao/salvar" => "AvaliacaoController@salvarAvaliacao",
        "/avaliacao/atualizar/{id}" => "AvaliacaoController@atualizarAvaliacao",
        "/avaliacao/deletar/{id}" => "AvaliacaoController@deletarAvaliacao",
        "/avaliacao/deletar-multiplos" => "AvaliacaoController@deletarMultiplos",
        // contatos
        "/contato/salvar" => "ContatoController@salvar",
        "/contato/atualizar/(\d+)" => "ContatoController@atualizar",
        "/contato/deletar/{id}" => "ContatoController@deletarContato",
        "/enviar-contato" => "PublicContatoController@enviar",
        "/contato/converter/{id}" => "ContatoController@converterEmCliente",
        "/contato/deletar-multiplos" => "ContatoController@deletarMultiplos",
        "/contato/excluir-confirmado/(\d+)" => "ContatoController@excluirContatoConfirmado",
        // endereços
        "/endereco/salvar" => "EnderecoController@salvarEndereco",
        "/endereco/atualizar/{id}" => "EnderecoController@atualizarEndereco",
        "/endereco/deletar/{id}" => "EnderecoController@deletarEndereco",
        "/endereco/excluir-massa" => "EnderecoController@excluirEmMassa",
        // itens de agendamento
        "/item_agendamento/salvar" => "ItemAgendamentoController@salvarItemAgendamento",
        "/item_agendamento/atualizar/{id}" => "ItemAgendamentoController@atualizarItemAgendamento",
        "/item_agendamento/deletar/{id}" => "ItemAgendamentoController@deletarItemAgendamento",
        // item_orcamento
        "/item_orcamento/salvar" => "ItemOrcamentoController@salvarItemOrcamento",
        "/item_orcamento/atualizar/{id}" => "ItemOrcamentoController@atualizarItemOrcamento",
        "/item_orcamento/deletar/{id}" => "ItemOrcamentoController@deletarItemOrcamento",
        //servico
       "/servico/salvar" => "ServicoController@salvarServico",
        "/servico/atualizar/{id}" => "ServicoController@atualizarServico",
        "/servico/deletar/{id}" => "ServicoController@deletarServico",
        //Servico Site
        "/servico-site/salvar" => "ServicoSiteController@salvar",
        "/servico-site/atualizar/{id}" => "ServicoSiteController@atualizar",
        //projeto
        "/projeto/salvar" => "ProjetoController@salvarProjeto",
        "/projeto/atualizar/{id}" => "ProjetoController@atualizarProjeto",
        "/projeto/deletar" => "ProjetoController@deletarProjeto",
        "/projeto/deletar-multiplos" => "ProjetoController@deletarMultiplos",
        //pagamento
        "/pagamento/salvar" => "PagamentoController@salvarPagamento",
        "/pagamento/atualizar/{id}" => "PagamentoController@atualizarPagamento",
        "/pagamento/deletar" => "PagamentoController@deletarPagamento",
        "/pagamento/deletar-multiplos" => "PagamentoController@deletarMultiplos",
        //orcamento
        "/orcamento/salvar" => "orcamentoController@salvarOrcamento",
        "/orcamento/atualizar/{id}" => "orcamentoController@atualizarOrcamento",
        "/orcamento/deletar/{id}" => "orcamentoController@deletarOrcamento",
        "/orcamento/alterar-status-massa" => "orcamentoController@alterarStatusEmMassa",
        "/orcamento/excluir-massa" => "orcamentoController@excluirEmMassa",
        //material 
        "/material/salvar" => "materialController@salvarMaterial",
        "/material/atualizar/{id}" => "materialController@atualizarMaterial",
        "/material/deletar/{id}" => "materialController@deletarMaterial",
    ]
        ];
    }
}