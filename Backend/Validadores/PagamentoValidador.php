<?php
namespace App\Impermax\Validadores;

class PagamentoValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['id_cliente']) && empty($dados['id_cliente'])){
            $erros[] = "O campo nome é obrigatório.";
        }
        if(isset($dados['total_devedor']) && empty($dados['total_devedor'])){
            $erros[] = "O campo descrição é obrigatório.";
        }
        if(isset($dados['dinheiro']) && empty($dados['dinheiro'])){
            $erros[] = "O campo valor é obrigatório.";
        }
         if(isset($dados['credito']) && empty($dados['credito'])){
            $erros[] = "O campo credito é obrigatório.";
        }
         if(isset($dados['debito']) && empty($dados['debito'])){
            $erros[] = "O campo debito é obrigatório.";
        }
         if(isset($dados['pix']) && empty($dados['pix'])){
            $erros[] = "O campo pix é obrigatório.";
        }
        if(isset($dados['status_pagamento']) && empty($dados['status_pagamento'])){
            $erros[] = "O campo status é obrigatório.";
        }
        if(isset($dados['data_pagamento']) && empty($dados['data_pagamento'])){
            $erros[] = "O campo data é obrigatório.";
        }
        return $erros;
    }
}