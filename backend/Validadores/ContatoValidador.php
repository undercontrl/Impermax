<?php
namespace App\Impermax\Validadores;

class ContatoValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['id_contato']) && empty($dados["id_contato"])){
            $erros[] = "O campo id contato é obrigatório.";
        }
        if(isset($dados['nome_contato']) && empty($dados["nome_contato"])){
            $erros[] = "O campo nome é obrigatório.";
        }
        if(isset($dados['telefone_contato']) && empty($dados["telefone_contato"])){
            $erros[] = "O campo telefone do contato é obrigatório.";
        }
        if(isset($dados['email_contato']) && empty($dados['email_contato'])){
            $erros[] = "O campo email é obrigatório.";
        } elseif(!filter_var($dados['email_contato'], FILTER_VALIDATE_EMAIL)){
            $erros[] = "O campo email deve conter um endereço de email válido.";
        }
        if(isset($dados['status_contato']) && empty($dados["status_contato"])){
            $erros[] = "O campo status do contato é obrigatório.";
        }
        return $erros;
    }
}