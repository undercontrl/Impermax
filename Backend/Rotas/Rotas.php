<?php
namespace App\Impermax\Rotas;

class Rotas
{
    public static function get(): array
    {
        return [
            "GET" => [
                "/usuario"                     => "UsuarioController@index",
                "/usuario/criar"               => "UsuarioController@viewCriarUsuarios",
                "/usuario/listar"              => "UsuarioController@viewListarUsuarios",
                "/usuario/editar/{id}"         => "UsuarioController@viewEditarUsuarios",
                "/usuario/excluir/{id}"        => "UsuarioController@viewExcluirUsuarios",
                "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",

                "/servico"                     => "ServicoController@index",
                "/servico/criar"               => "ServicoController@viewCriarServicos",
                "/servico/listar"              => "ServicoController@viewListarServicos",
                "/servico/editar/{id}"         => "ServicoController@viewEditarServicos",
                "/servico/excluir/{id}"        => "ServicoController@viewExcluirServicos",

                "/projeto"                     => "ProjetoController@index",
                "/projeto/criar"               => "ProjetoController@viewCriarProjetos",
                "/projeto/listar"              => "ProjetoController@viewListarProjetos",
                "/projeto/editar/{id}"         => "ProjetoController@viewEditarProjetos",
                "/projeto/excluir/{id}"        => "ProjetoController@viewExcluirProjetos",

                "/pagamento"                   => "PagamentoController@index",
                "/pagamento/criar"             => "PagamentoController@viewCriarPagamentos",
                "/pagamento/listar"            => "PagamentoController@viewListarPagamentos",
                "/pagamento/editar/{id}"       => "PagamentoController@viewEditarPagamentos",
                "/pagamento/excluir/{id}"      => "PagamentoController@viewExcluirPagamentos",

                "/orcamento"                   => "OrcamentoController@index",
                "/orcamento/criar"             => "OrcamentoController@viewCriarOrcamentos",
                "/orcamento/listar"            => "OrcamentoController@viewListarOrcamentos",
                "/orcamento/editar/{id}"       => "OrcamentoController@viewEditarOrcamentos",
                "/orcamento/excluir/{id}"      => "OrcamentoController@viewExcluirOrcamentos",

                "/material"                    => "MaterialController@index",
                "/material/criar"              => "MaterialController@viewCriarMateriais",
                "/material/listar"             => "MaterialController@viewListarMateriais",
                "/material/editar/{id}"        => "MaterialController@viewEditarMateriais",
                "/material/excluir/{id}"       => "MaterialController@viewExcluirMateriais",
            ],
            "POST" => [
                "/usuario/salvar"              => "UsuarioController@salvarUsuario",
                "/usuario/atualizar/{id}"      => "UsuarioController@atualizarUsuario",
                "/usuario/deletar/{id}"        => "UsuarioController@deletarUsuario",

                "/servico/salvar"              => "ServicoController@salvarServico",
                "/servico/atualizar/{id}"      => "ServicoController@atualizarServico",
                "/servico/deletar/{id}"        => "ServicoController@deletarServico",

                "/projeto/salvar"              => "ProjetoController@salvarProjeto",
                "/projeto/atualizar/{id}"      => "ProjetoController@atualizarProjeto",
                "/projeto/deletar/{id}"        => "ProjetoController@deletarProjeto",

                "/pagamento/salvar"            => "PagamentoController@salvarPagamento",
                "/pagamento/atualizar/{id}"    => "PagamentoController@atualizarPagamento",
                "/pagamento/deletar/{id}"      => "PagamentoController@deletarPagamento",

                "/orcamento/salvar"            => "OrcamentoController@salvarOrcamento",
                "/orcamento/atualizar/{id}"    => "OrcamentoController@atualizarOrcamento",
                "/orcamento/deletar/{id}"      => "OrcamentoController@deletarOrcamento",

                "/material/salvar"             => "MaterialController@salvarMaterial",
                "/material/atualizar/{id}"     => "MaterialController@atualizarMaterial",
                "/material/deletar/{id}"       => "MaterialController@deletarMaterial",
            ],
        ];
    }
}
