<?php
namespace App\Impermax\Validadores;

class AgendamentoValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['id_agendamento']) && empty($dados["id_agendamento"])){
            $erros[] = "O campo id agendamento é obrigatório.";
        }
        if(isset($dados['data_solicitada']) && empty($dados["data_solicitada"])){
            $erros[] = "O campo data é obrigatório.";
        }
        if(isset($dados['total_agendamento']) && empty($dados["total_agendamento"])){
            $erros[] = "O campo total do agendamento é obrigatório.";
        }
        if(isset($dados['status_agendamento']) && empty($dados["status_agendamento"])){
            $erros[] = "O campo status do agendamento é obrigatório.";
        }
    }
}