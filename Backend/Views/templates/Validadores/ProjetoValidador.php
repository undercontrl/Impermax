<?php
namespace App\Impermax\Validadores;

class ProjetoValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['nome_projeto']) && empty($dados['nome_projeto'])){
            $erros[] = "O campo nome é obrigatório.";
        }
        if(isset($dados['foto_antes_projeto']) && empty($dados['foto_antes_projeto'])){
            $erros[] = "O campo foto é obrigatório.";
        }
        if(isset($dados['foto_depois_projeto']) && empty($dados['foto_depois_projeto'])){
            $erros[] = "O campo foto é obrigatório.";
        }
        if(isset($dados['descricao_projeto']) && empty($dados['descricao_projeto'])){
            $erros[] = "O campo descrição é obrigatório.";
        }

        return $erros;
    }
}