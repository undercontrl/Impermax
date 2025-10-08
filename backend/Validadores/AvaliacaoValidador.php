<?php
namespace App\Impermax\Validadores;

class AvaliacaoValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['id_avaliacao']) && empty($dados["id_avaliacao"])){
            $erros[] = "O campo id avaliação é obrigatório.";
        }
        if(isset($dados['descricao_avaliacao']) && empty($dados["descricao_avaliacao"])){
            $erros[] = "O campo descricao é obrigatório.";
        }
        if(isset($dados['nota_avaliacao']) && empty($dados["nota_avaliacao"])){
            $erros[] = "O campo nota da avaliação é obrigatório.";
        }
        if(isset($dados['status_avaliacao']) && empty($dados["status_avaliacao"])){
            $erros[] = "O campo status da avaliação é obrigatório.";
        }
    }
}