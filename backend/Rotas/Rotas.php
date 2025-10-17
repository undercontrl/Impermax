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
        "/usuarios" => "UsuarioController@index",
        "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
        "/usuario/listar" => "UsuarioController@viewListarUsuarios",
        "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
        "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
        "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",
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
    ],
    "POST" => [
        //usuarios
        "/usuario/salvar" => "UsuarioController@salvarUsuario",
        "/usuario/atualizar/{id}" => "UsuarioController@atualizarUsuario",
        "/usuario/deletar/{id}" => "UsuarioController@deletarUsuario",
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
        "/tem_agendamento/salvar" => "ItemAgendamentoController@salvarItemAgendamento",
        "/item_agendamento/atualizar/{id}" => "ItemAgendamentoController@atualizarItemAgendamento",
        "/item_agendamento/deletar/{id}" => "ItemAgendamentoController@deletarItemAgendamento",


    ]
        ];
    }
}
