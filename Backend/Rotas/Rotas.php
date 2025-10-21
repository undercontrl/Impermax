<?php

namespace App\Impermax\Rotas;

class Rotas
{
    public static function get()
    {
    return [
    "GET" => [
       // O caminho da url   O nome do controller que e o metodo do controller
       "/usuario" => "UsuarioController@index",
       "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
       "/usuario/listar" => "UsuarioController@viewListarUsuarios",
        "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
        "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
        "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",

        "/servico" => "ServicoController@index",
       "/servico/criar" => "servicoController@viewCriarServicos",
       "/servico/listar" => "servicoController@viewListarServicos",
        "/servico/editar/{id}" => "servicoController@viewEditarServicos",
        "/servico/excluir/{id}" => "ServicoController@viewExcluirServicos",

        "/projeto" => "projetoController@index",
       "/projeto/criar" => "projetoController@viewCriarProjetos",
       "/projeto/listar" => "projetoController@viewListarProjetos",
        "/projeto/editar/{id}" => "projetoController@viewEditarProjetos",
        "/projeto/excluir/{id} " => "projetoController@viewExcluirProjetos",

        "/pagamento" => "pagamentoController@index",
       "/pagamento/criar" => "pagamentoController@viewCriarPagamentos",
       "/pagamento/listar" => "pagamentoController@viewListarPagamentos",
        "/pagamento/editar/{id}" => "pagamentoController@viewEditarPagamentos",
        "/pagamento/excluir/{id}" => "pagamentoController@viewExcluirPagamentos",

        "/orcamento" => "orcamentoController@index",
       "/orcamento/criar" => "orcamentoController@viewCriarOrcamentos",
       "/orcamento/listar" => "orcamentoController@viewListarOrcamentos",
        "/orcamento/editar/{id}" => "orcamentoController@viewEditarOrcamentos",
        "/orcamento/excluir/{id}" => "orcamentoController@viewExcluirOrcamentos",

        "/material" => "materialController@index",
       "/material/criar" => "materialController@viewCriarMateriais",
       "/material/listar" => "materialController@viewListarMateriais",
        "/material/editar/{id}" => "materialController@viewEditarMateriais",
        "/material/excluir/{id}" => "materialController@viewExcluirMateriais",
        
    ],
    "POST" => [
        "/usuario/salvar" => "UsuarioController@salvarUsuario",
        "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
        "/usuario/deletar/{id}" => "UsuarioController@deletarUsuario",

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
        
    ]
        ];
    }
}
