<?php
namespace App\Impermax\Validadores;

class orcamentoValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['id_cliente']) && empty($dados['id_cliente'])){
            $erros[] = "O campo id é obrigatório.";
        }
        if(isset($dados['descricao_orcamento']) && empty($dados['descricao_orcamento'])){
            $erros[] = "O campo descricao é obrigatório.";
        }
        if(isset($dados['status_orcamento']) && empty($dados['status_orcamento'])){
            $erros[] = "O campo descrição é obrigatório.";
        } 
        if(isset($dados['data_orcamento']) && empty($dados['data_orcamento'])){
            $erros[] = "O campo data é obrigatório.";
        } 
        if(isset($dados['valor_orcamento']) && empty($dados['data_orcamento'])){
            $erros[] = "O campo valr é obrigatório.";
        } 
        if(isset($dados['total_item_orcamento']) && empty($dados['total_item_orcamento'])){
            $erros[] = "O campo é obrigatório.";
        } 
        return $erros;
    }
}