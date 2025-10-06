<?php

namespace App\Impermax\Rotas;

class Rotas
{
    public static function get()
    {
    return [
    "GET" => [
       // O caminho da url   O nome do controller que e o metodo do controller
       "/backend/usuario" => "UsuarioController@index",
       "/backend/usuario/criar" => "UsuarioController@viewCriarUsuarios",
       "/backend/usuario/listar" => "UsuarioController@viewListarUsuarios",
        "/backend/usuario/editar" => "UsuarioController@viewEditarUsuarios",
        "/backend/usuario/excluir" => "UsuarioController@viewExcluirUsuarios",

        "/backend/servico" => "ServicoController@index",
       "/backend/servico/criar" => "servicoController@viewCriarServicos",
       "/backend/servico/listar" => "servicoController@viewListarServicos",
        "/backend/servico/editar" => "servicoController@viewEditarServicos",
        "/backend/servico/excluir" => "ServicoController@viewExcluirServicos",

        "/backend/projeto" => "projetoController@index",
       "/backend/projeto/criar" => "projetoController@viewCriarProjetos",
       "/backend/projeto/listar" => "projetoController@viewListarProjetos",
        "/backend/projeto/editar" => "projetoController@viewEditarProjetos",
        "/backend/projeto/excluir" => "projetoController@viewExcluirProjetos",

        "/backend/pagamento" => "pagamentoController@index",
       "/backend/pagamento/criar" => "pagamentoController@viewCriarPagamentos",
       "/backend/pagamento/listar" => "pagamentoController@viewListarPagamentos",
        "/backend/pagamento/editar" => "pagamentoController@viewEditarPagamentos",
        "/backend/pagamento/excluir" => "pagamentoController@viewExcluirPagamentos",

        "/backend/material" => "materialController@index",
       "/backend/material/criar" => "materialController@viewCriarMateriais",
       "/backend/material/listar" => "materialController@viewListarMateriais",
        "/backend/material/editar" => "materialController@viewEditarMateriais",
        "/backend/material/excluir" => "materialController@viewExcluirMateriais",
        
    ],
    "POST" => [
        "/backend/usuario/salvar" => "UsuarioController@salvarUsuario",
        "/backend/usuario/atualizar" => "UsuarioController@atualizarUsuario",
        "/backend/usuario/deletar" => "UsuarioController@deletarUsuario",

        "/backend/servico/salvar" => "ServicoController@salvarServico",
        "/backend/servico/atualizar" => "ServicoController@atualizarServico",
        "/backend/servico/deletar" => "ServicoController@deletarServico",

        "/backend/projeto/salvar" => "projetoController@salvarProjeto",
        "/backend/projeto/atualizar" => "projetoController@atualizarProjeto",
        "/backend/projeto/deletar" => "projetoController@deletarProjeto",
        
        "/backend/pagamento/salvar" => "pagamentoController@salvarPagamento",
        "/backend/pagamento/atualizar" => "pagamentoController@atualizarPagamento",
        "/backend/pagamento/deletar" => "pagamentoController@deletarPagamento",

        "/backend/material/salvar" => "materialController@salvarMaterial",
        "/backend/material/atualizar" => "materialController@atualizarMaterial",
        "/backend/material/deletar" => "materialController@deletarMaterial",
        
    ]
        ];
    }
}
