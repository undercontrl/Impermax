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
       "/esqueci-senha" => "AuthController@viewEsqueciSenha",
       "/redefinir-senha" => "AuthController@viewRedefinirSenha",
       '/admin/dashboard' => 'Admin\DashboardController@index',
       '/funcionario/dashboard' => 'Funcionario\DashboardController@index',
       
       //perfil
       '/perfil' => 'PerfilController@index',
       
       //usuarios
        "/usuarios" => "UsuarioController@index",
        "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
        "/usuario/listar" => "UsuarioController@viewListarUsuarios",
        "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
        "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
        "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",
        "/usuario/visualizar/{id}" => "UsuarioController@viewVisualizarUsuario",
        '/api/usuarios/{pagina}' => 'APIUsuarioController@getUsuarios',
        '/api/usuarios' => 'APIUsuarioController@getUsuarios',
        //agendamentos
        "/agendamentos" => "AgendamentoController@index",
        "/agendamento/criar" => "AgendamentoController@viewCriarAgendamentos",
        "/agendamento/criar-publico" => "AgendamentoController@viewCriarAgendamentos",
        "/agendamento/ver/{id}" => "AgendamentoController@viewVerAgendamento",
        "/agendamento/listar" => "AgendamentoController@viewListarAgendamentos",
        "/agendamento/editar/{id}" => "AgendamentoController@viewEditarAgendamentos",
        "/agendamento/excluir/{id}" => "AgendamentoController@viewExcluirAgendamentos",
        "/agendamento/{id}/relatorio/{dataInicial}/{dataFinal}" => "AgendamentoController@relatorioAgendamento",
        '/agendamento/deletar-multiplos' => 'AgendamentoController@deletarMultiplos',
        //avaliações
        "/avaliacao" => "AvaliacaoController@index",
        "/avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacoes",
        "/avaliacao/listar" => "AvaliacaoController@viewListarAvaliacoes",
        "/avaliacao/editar/{id}" => "AvaliacaoController@viewEditarAvaliacoes",
        "/avaliacao/excluir/{id}" => "AvaliacaoController@viewExcluirAvaliacoes",
        "/avaliacao/{id}/relatorio/{dataInicial}/{dataFinal}" => "AvaliacaoController@relatorioAvaliacao",
        "/avaliar" => "AvaliacaoPublicaController@viewFormularioPublico",
        "/avaliacao/ativar/{id}" => "AvaliacaoController@ativarAvaliacao",
        "/avaliacao/desativar/{id}" => "AvaliacaoController@desativarAvaliacao",
        "/cliente/avaliacao" => "ClienteAvaliacaoController@index",
        "api/avaliacoes" => "PublicApiController@getAvaliacoes",
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
        "/projeto/ativar/{id}" => "ProjetoController@ativarProjeto",
        "/projeto/desativar/{id}" => "ProjetoController@desativarProjeto",
        "api/projetos" => "PublicProjetoController@getProjetos",
        //pagina projeto 
        "/pagina-projeto" => "PaginaProjetoController@index",                   
        "/pagina-projeto/listar" => "PaginaProjetoController@listar",           
        "/pagina-projeto/listar/{pagina}" => "PaginaProjetoController@listar",  
        "/pagina-projeto/criar" => "PaginaProjetoController@criar",             
        "/pagina-projeto/editar/{id}" => "PaginaProjetoController@editar",      
        "/pagina-projeto/alternar/{id}" => "PaginaProjetoController@alternar",
        "api/pagina-projeto" => "PublicPaginaProjetoController@getProjetos",
        //pagamento
        "/pagamento" => "PagamentoController@index",
        "/pagamento/criar" => "PagamentoController@viewCriarPagamentos",
        "/pagamento/listar" => "PagamentoController@viewListarPagamentos",
        "/pagamento/ver/{id}" => "PagamentoController@viewVerPagamento",
        "/pagamento/editar/{id}" => "PagamentoController@viewEditarPagamentos",
        "/pagamento/excluir/{id}" => "PagamentoController@viewExcluirPagamentos",
        '/api/pagamento/{pagina}' => 'APIPagamentoController@getPagamentos',
        '/api/pagamentos' => 'APIPagamentoController@getPagamentos',
        //orcamento
        "/orcamento" => "OrcamentoController@index",
        "/orcamento/criar" => "OrcamentoController@viewCriarOrcamentos",
        "/orcamento/listar" => "OrcamentoController@viewListarOrcamentos",
        "/orcamento/visualizar/{id}" => "OrcamentoController@viewVisualizarOrcamento",
        "/orcamento/editar/{id}" => "OrcamentoController@viewEditarOrcamentos",
        "/orcamento/excluir/{id}" => "OrcamentoController@viewExcluirOrcamentos",
        //material
        "/material" => "MaterialController@index",
        "/material/criar" => "MaterialController@viewCriarMateriais",
        "/material/listar" => "MaterialController@viewListarMateriais",
        "/material/editar/{id}" => "MaterialController@viewEditarMateriais",
        "/material/excluir/{id}" => "MaterialController@viewExcluirMateriais",

        
    ],
    "POST" => [
        //login
        '/register' => 'AuthController@cadastrarUsuario',
        '/login' => 'AuthController@authenticar',
        "/authenticar" => "AuthController@authenticar",
        "/processar-esqueci-senha" => "AuthController@processarEsqueciSenha",
        "/processar-redefinir-senha" => "AuthController@processarRedefinirSenha",
        
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
        "/enviar-avaliacao" => "AvaliacaoPublicaController@enviarAvaliacaoPublica",
        "/cliente/avaliacao/salvar" => "ClienteAvaliacaoController@salvarAvaliacao",
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
        "/projeto/deletar/{id}" => "ProjetoController@deletarProjeto",
        "/projeto/deletar-multiplos" => "ProjetoController@deletarMultiplos",
        //pagina projeto 
        "/pagina-projeto/salvar" => "PaginaProjetoController@salvar",
        "/pagina-projeto/atualizar/{id}" => "PaginaProjetoController@atualizar",
        //pagamento
        "/pagamento/salvar" => "PagamentoController@salvarPagamento",
        "/pagamento/atualizar/{id}" => "PagamentoController@atualizarPagamento",
        "/pagamento/deletar/{id}" => "PagamentoController@deletarPagamento",
        "/pagamento/deletar-multiplos" => "PagamentoController@deletarMultiplos",
        //orcamento
        "/orcamento/salvar" => "OrcamentoController@salvarOrcamento",
        "/orcamento/atualizar/{id}" => "OrcamentoController@atualizarOrcamento",
        "/orcamento/deletar/{id}" => "OrcamentoController@deletarOrcamento",
        "/orcamento/alterar-status-massa" => "OrcamentoController@alterarStatusEmMassa",
        "/orcamento/excluir-massa" => "OrcamentoController@excluirEmMassa",
        //material 
        "/material/salvar" => "MaterialController@salvarMaterial",
        "/material/atualizar/{id}" => "MaterialController@atualizarMaterial",
        "/material/deletar/{id}" => "MaterialController@deletarMaterial",
        "/material/deletar-multiplos" => "MaterialController@deletarMultiplos"
    ]
        ];
    }
}