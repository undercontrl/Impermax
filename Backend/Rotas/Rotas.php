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
        "/projeto/editar" => "projetoController@viewEditarProjetos",
        "/projeto/excluir" => "projetoController@viewExcluirProjetos",

        "/pagamento" => "pagamentoController@index",
       "/pagamento/criar" => "pagamentoController@viewCriarPagamentos",
       "/pagamento/listar" => "pagamentoController@viewListarPagamentos",
        "/pagamento/editar" => "pagamentoController@viewEditarPagamentos",
        "/pagamento/excluir" => "pagamentoController@viewExcluirPagamentos",

        "/orcamento" => "orcamentoController@index",
       "/orcamento/criar" => "orcamentoController@viewCriarOrcamentos",
       "/orcamento/listar" => "orcamentoController@viewListarOrcamentos",
        "/orcamento/editar" => "orcamentoController@viewEditarOrcamentos",
        "/orcamento/excluir" => "orcamentoController@viewExcluirOrcamentos",

        "/material" => "materialController@index",
       "/material/criar" => "materialController@viewCriarMateriais",
       "/material/listar" => "materialController@viewListarMateriais",
        "/material/editar" => "materialController@viewEditarMateriais",
        "/material/excluir" => "materialController@viewExcluirMateriais",
        
    ],
    "POST" => [
        "/usuario/salvar" => "UsuarioController@salvarUsuario",
        "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
        "/usuario/deletar/{id}" => "UsuarioController@deletarUsuario",

        "/servico/salvar" => "ServicoController@salvarServico",
        "/servico/atualizar/{id}" => "ServicoController@atualizarServico",
        "/servico/deletar/{id}" => "ServicoController@deletarServico",

        "/projeto/salvar" => "projetoController@salvarProjeto",
        "/projeto/atualizar" => "projetoController@atualizarProjeto",
        "/projeto/deletar" => "projetoController@deletarProjeto",
        
        "/pagamento/salvar" => "pagamentoController@salvarPagamento",
        "/pagamento/atualizar" => "pagamentoController@atualizarPagamento",
        "/pagamento/deletar" => "pagamentoController@deletarPagamento",

        "/orcamento/salvar" => "orcamentoController@salvarOrcamento",
        "/orcamento/atualizar" => "orcamentoController@atualizarOrcamento",
        "/orcamento/deletar" => "orcamentoController@deletarOrcamento",

        "/material/salvar" => "materialController@salvarMaterial",
        "/material/atualizar" => "materialController@atualizarMaterial",
        "/material/deletar" => "materialController@deletarMaterial",
        
    ]
        ];
    }
}
