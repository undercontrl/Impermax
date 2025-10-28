<?php

namespace App\Impermax\Rotas;

class Rotas
{
    public static function get()
    {
    return [
    "GET" => [
       // O caminho da url   O nome do controller que e o metodo do controller
       "/usuarios" => "UsuarioController@index",
       "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
       "/usuario/listar" => "UsuarioController@viewListarUsuarios",
        "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
        "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
        "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",
        //login e register
         '/register' => 'AuthController@register',
        '/login' => 'AuthController@login',
        '/logout' => 'AuthController@logout',
        '/authenticar'    => 'AuthController@authenticar',
        '/admin/dashboard' => 'Admin\DashboardController@index',


        "/servico" => "ServicoController@index",
       "/servico/criar" => "ServicoController@viewCriarServicos",
       "/servico/listar" => "ServicoController@viewListarServicos",
      "api/servicos" => "PublicApiController@getServicos",
        "/servico/editar/{id}" => "ServicoController@viewEditarServicos",
        "/servico/excluir/{id}" => "ServicoController@viewExcluirServicos",

        // Dashboard do Site
        "/servico-site" => "ServicoSiteController@index",
        "/servico-site/listar" => "ServicoSiteController@listar",
        "/servico-site/editar/{id}" => "ServicoSiteController@editar",
        "/servico-site/atualizar/{id}" => "ServicoSiteController@atualizar",
        "/servico-site/alternar/{id}" => "ServicoSiteController@alternarStatus",

        "/projeto" => "ProjetoController@index",
       "/projeto/criar" => "ProjetoController@viewCriarProjetos",
       "/projeto/listar" => "ProjetoController@viewListarProjetos",
        "/projeto/editar/{id}" => "ProjetoController@viewEditarProjetos",
        "/projeto/excluir/{id}" => "ProjetoController@viewExcluirProjetos",

        "/pagamento" => "PagamentoController@index",
       "/pagamento/criar" => "PagamentoController@viewCriarPagamentos",
       "/pagamento/listar" => "PagamentoController@viewListarPagamentos",
        "/pagamento/editar/{id}" => "PagamentoController@viewEditarPagamentos",
        "/pagamento/excluir/{id}" => "PagamentoController@viewExcluirPagamentos",

        "/orcamento" => "OrcamentoController@index",
       "/orcamento/criar" => "OrcamentoController@viewCriarOrcamentos",
       "/orcamento/listar" => "OrcamentoController@viewListarOrcamentos",
        "/orcamento/editar/{id}" => "OrcamentoController@viewEditarOrcamentos",
        "/orcamento/excluir/{id}" => "OrcamentoController@viewExcluirOrcamentos",

        "/material" => "MaterialController@index",
       "/material/criar" => "MaterialController@viewCriarMateriais",
       "/material/listar" => "MaterialController@viewListarMateriais",
        "/material/editar/{id}" => "MaterialController@viewEditarMateriais",
        "/material/excluir/{id}" => "MaterialController@viewExcluirMateriais",

        //agendamentos
        "/agendamentos" => "AgendamentoController@index",
        "/agendamento/criar" => "AgendamentoController@viewCriarAgendamentos",
        "/agendamento/listar" => "AgendamentoController@viewListarAgendamentos",
        "/agendamento/editar/{id}" => "AgendamentoController@viewEditarAgendamentos",
        "/agendamento/excluir/{id}" => "AgendamentoController@viewExcluirAgendamentos",
        "/agendamento/{id}/relatorio/{dataInicial}/{dataFinal}" => "AgendamentoController@relatorioAgendamento",
        //avaliações
        "/avaliacoes" => "AvaliacaoController@index",
        "/avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacao",
        "/avaliacao/listar" => "AvaliacaoController@viewListarAvaliacao",
        "/avaliacao/editar/{id}" => "AvaliacaoController@viewEditarAvaliacao",
        "/avaliacao/excluir/{id}" => "AvaliacaoController@viewExcluirAvaliacao",
        "/avaliacao/{id}/relatorio/{dataInicial}/{dataFinal}" => "AvaliacaoController@relatorioAvaliacao",
        // contatos
        "/contatos" => "ContatoController@index",
        "/contato/listar" => "ContatoController@viewListarContatos",
        "/contato/criar" => "ContatoController@viewCriarContato",
        "/contato/editar/{id}" => "ContatoController@viewEditarContato",
        "/contato/excluir/{id}" => "ContatoController@viewExcluirContato",
        "/contato/{id}/relatorio/{dataInicial}/{dataFinal}" => "ContatoController@relatorioContato",
        // enderecos
        "/enderecos" => "EnderecoController@index",
        "/endereco/listar" => "EnderecoController@viewListarEnderecos",
        "/endereco/criar" => "EnderecoController@viewCriarEndereco",
        "/endereco/editar/{id}" => "EnderecoController@viewEditarEndereco",
        "/endereco/excluir/{id}" => "EnderecoController@viewExcluirEndereco",
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


        
    ],
    "POST" => [
        "/usuario/salvar" => "UsuarioController@salvarUsuario",
        "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
        "/usuario/deletar/{id}" => "UsuarioController@deletarUsuario",


        '/register' => 'AuthController@cadastrarUsuario',
        '/login' => 'AuthController@authenticar',
        "/authenticar" => "AuthController@authenticar",


        "/servico/salvar" => "ServicoController@salvarServico",
        "/servico/atualizar/{id}" => "ServicoController@atualizarServico",
        "/servico/deletar/{id}" => "ServicoController@deletarServico",

        "/projeto/salvar" => "projetoController@salvarProjeto",
        "/projeto/atualizar/{id}" => "projetoController@atualizarProjeto",
        "/projeto/deletar/{id}" => "projetoController@deletarProjeto",
        
        "/pagamento/salvar" => "pagamentoController@salvarPagamento",
        "/pagamento/atualizar/{id}" => "pagamentoController@atualizarPagamento",
        "/pagamento/deletar/{id}" => "pagamentoController@deletarPagamento",

        "/orcamento/salvar" => "orcamentoController@salvarOrcamento",
        "/orcamento/atualizar/{id}" => "orcamentoController@atualizarOrcamento",
        "/orcamento/deletar/{id}" => "orcamentoController@deletarOrcamento",

        "/material/salvar" => "materialController@salvarMaterial",
        "/material/atualizar/{id}" => "materialController@atualizarMaterial",
        "/material/deletar/{id}" => "materialController@deletarMaterial",

          //agendamentos
        "/agendamento/salvar" => "AgendamentoController@salvarAgendamento",
        "/agendamento/atualizar/{id}" => "AgendamentoController@atualizarAgendamento",
        "/agendamento/deletar/{id}" => "AgendamentoController@deletarAgendamento",
        //avaliações
        "/avaliacao/salvar" => "AvaliacaoController@salvarAvaliacao",
        "/avaliacao/atualizar/{id}" => "AvaliacaoController@atualizarAvaliacao",
        "/avaliacao/deletar/{id}" => "AvaliacaoController@deletarAvaliacao",
        // contatos
        "/contato/salvar" => "ContatoController@salvarContato",
        "/contato/atualizar/{id}" => "ContatoController@atualizarContato",
        "/contato/deletar/{id}" => "ContatoController@deletarContato",
        // endereços
        "/endereco/salvar" => "EnderecoController@salvarEndereco",
        "/endereco/atualizar/{id}" => "EnderecoController@atualizarEndereco",
        "/endereco/deletar/{id}" => "EnderecoController@deletarEndereco",
        // itens de agendamento
        "/item_agendamento/salvar" => "ItemAgendamentoController@salvarItemAgendamento",
        "/item_agendamento/atualizar/{id}" => "ItemAgendamentoController@atualizarItemAgendamento",
        "/item_agendamento/deletar/{id}" => "ItemAgendamentoController@deletarItemAgendamento",
        // item_orcamento
        "/item_orcamento/salvar" => "ItemOrcamentoController@salvarItemOrcamento",
        "/item_orcamento/atualizar/{id}" => "ItemOrcamentoController@atualizarItemOrcamento",
        "/item_orcamento/deletar/{id}" => "ItemOrcamentoController@deletarItemOrcamento",
        
    ]
        ];
    }
}
