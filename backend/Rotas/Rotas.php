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
        "/backend/usuarios" => "UsuarioController@index",
        "/backend/usuario/criar" => "UsuarioController@viewCriarUsuarios",
        "/backend/usuario/listar" => "UsuarioController@viewListarUsuarios",
        "/backend/usuario/editar" => "UsuarioController@viewEditarUsuarios",
        "/backend/usuario/excluir" => "UsuarioController@viewExcluirUsuarios",
        "/backend/servico/excluir" => "ServicoController@viewExcluirServicos",
        //agendamentos
        "/backend/agendamentos" => "AgendamentoController@index",
        "/backend/agendamento/criar" => "AgendamentoController@viewCriarAgendamentos",
        "/backend/agendamento/listar" => "AgendamentoController@viewListarAgendamentos",
        "/backend/agendamento/editar" => "AgendamentoController@viewEditarAgendamentos",
        "/backend/agendamento/excluir" => "AgendamentoController@viewExcluirAgendamentos",
        "/backend/servico/excluir" => "ServicoController@viewExcluirServicos",


        
    ],
    "POST" => [
        //usuarios
        "/backend/usuario/salvar" => "UsuarioController@salvarUsuario",
        "/backend/usuario/atualizar" => "UsuarioController@atualizarUsuario",
        "/backend/usuario/deletar" => "UsuarioController@deletarUsuario",
        //agendamentos
        "/backend/agendamento/salvar" => "AgendamentoController@salvarAgendamento",
        "/backend/agendamento/atualizar" => "AgendamentoController@atualizarAgendamento",
        "/backend/agendamento/deletar" => "AgendamentoController@deletarAgendamento",
    ]
        ];
    }
}
