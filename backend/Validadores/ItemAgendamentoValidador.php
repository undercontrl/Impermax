<?php
namespace App\Impermax\Validadores;

class ItemAgendamentoValidador
{
    public static function ValidarEntradas($dados)
    {
        $erros = [];

        if (isset($dados['id_agendamento']) && empty(trim($dados['id_agendamento']))) {
            $erros[] = "O campo Agendamento é obrigatório.";
        }

        if (isset($dados['id_servico']) && empty(trim($dados['id_servico']))) {
            $erros[] = "O campo Serviço é obrigatório.";
        }

        if (isset($dados['valor_servico']) && (empty(trim($dados['valor_servico'])) || !is_numeric($dados['valor_servico']))) {
            $erros[] = "O campo Valor do Serviço é obrigatório e deve ser numérico.";
        }

        if (isset($dados['qtde_solicitada']) && (empty(trim($dados['qtde_solicitada'])) || !is_numeric($dados['qtde_solicitada']))) {
            $erros[] = "O campo Quantidade Solicitada é obrigatório e deve ser numérico.";
        }

        if (isset($dados['total_item']) && (empty(trim($dados['total_item'])) || !is_numeric($dados['total_item']))) {
            $erros[] = "O campo Total do Item é obrigatório e deve ser numérico.";
        }

        if (isset($dados['id_responsavel']) && empty(trim($dados['id_responsavel']))) {
            $erros[] = "O campo Responsável é obrigatório.";
        }

        return $erros;
    }
}
