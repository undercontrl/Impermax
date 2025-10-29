<?php
namespace App\Impermax\Validadores;

class MaterialValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['nome_material']) && empty($dados['nome_material'])){
            $erros[] = "O campo nome é obrigatório.";
        }
        if(isset($dados['qtd_material']) && empty($dados['qtd_material'])){
            $erros[] = "O campo quantidade é obrigatório.";
        }
        if(isset($dados['descricao_material']) && empty($dados['descricao_material'])){
            $erros[] = "O campo descrição é obrigatório.";
        } 
        if(isset($dados['id_servico']) && empty($dados['id_servico'])){
            $erros[] = "O campo serviço é obrigatório.";
        } 
        return $erros;
    }
}