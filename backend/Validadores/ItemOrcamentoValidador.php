<?php
namespace App\Impermax\Validadores;

class ItemOrcamentoValidador {
    public static function ValidarEntradas($dados) {
        $erros = [];

        if (empty($dados["id_orcamento"])) $erros[] = "Selecione um orçamento.";
        if (empty($dados["id_servico"])) $erros[] = "Selecione um serviço.";
        if (empty($dados["descricao_item_orcamento"])) $erros[] = "Informe uma descrição para o item.";
        if (empty($dados["metragem"]) || $dados["metragem"] <= 0) $erros[] = "Informe uma metragem válida.";
        if (empty($dados["status_item_orcamento"])) $erros[] = "Selecione o status do item.";

        return $erros;
    }
}
