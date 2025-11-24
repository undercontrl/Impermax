<?php
namespace App\Impermax\Validadores;

class ServicoValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['nome_servico']) && empty($dados['nome_servico'])){
            $erros[] = "O campo nome é obrigatório.";
        }
        if(isset($dados['descricao_servico']) && empty($dados['descricao_servico'])){
            $erros[] = "O campo descrição é obrigatório.";
        }
        if(isset($dados['valor_base_servico']) && empty($dados['valor_base_servico'])){
            $erros[] = "O campo valor é obrigatório.";
        } 
        return $erros;
    }
}