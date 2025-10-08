<?php

namespace App\Impermax\Rotas;

class Rotas
{
    public static function get()
    {
    return [
    "GET" => [
       // O caminho da url   O nome do controller que e o metodo do controller
       //usuarios
        "usuarios" => "UsuarioController@index",
        "usuario/criar" => "UsuarioController@viewCriarUsuarios",
        "usuario/listar" => "UsuarioController@viewListarUsuarios",
        "usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
        "usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
        "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",
        //agendamentos
        "agendamentos" => "AgendamentoController@index",
        "agendamento/criar" => "AgendamentoController@viewCriarAgendamentos",
        "agendamento/listar" => "AgendamentoController@viewListarAgendamentos",
        "agendamento/editar/{id}" => "AgendamentoController@viewEditarAgendamentos",
        "agendamento/excluir/{id}" => "AgendamentoController@viewExcluirAgendamentos",
        "/agendamento/{id}/relatorio/{dataInicial}/{dataFinal}" => "AgendamentoController@relatorioAgendamento",
        //avaliações
        "avaliacoes" => "AvaliacaoController@index",
        "avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacao",
        "avaliacao/listar" => "AvaliacaoController@viewListarAvaliacao",
        "avaliacao/editar/{id}" => "AvaliacaoController@viewEditarAvaliacao",
        "avaliacao/excluir/{id}" => "AvaliacaoController@viewExcluirAvaliacao",
        "/avaliacao/{id}/relatorio/{dataInicial}/{dataFinal}" => "AvaliacaoController@relatorioAvaliacao",

        
    ],
    "POST" => [
        //usuarios
        "usuario/salvar" => "UsuarioController@salvarUsuario",
        "usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
        "usuario/deletar/{id}" => "UsuarioController@deletarUsuario",
        //agendamentos
        "agendamento/salvar" => "AgendamentoController@salvarAgendamento",
        "agendamento/atualizar/{id}" => "AgendamentoController@atualizarAgendamento",
        "agendamento/deletar/{id}" => "AgendamentoController@deletarAgendamento",
        //avaliações
        "avaliacao/salvar" => "AvaliacaoController@salvarAvaliacao",
        "avaliacao/atualizar/{id}" => "AvaliacaoController@atualizarAvaliacao",
        "avaliacao/deletar/{id}" => "AvaliacaoController@deletarAvaliacao",
    ]
        ];
    }
}
