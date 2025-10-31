<?php
namespace App\Impermax\Validadores;

class AvaliacaoValidador
{
    /**
     * Valida entradas do formulário de avaliação
     */
    public static function validarEntradas(array $post, bool $isUpdate = false): array
    {
        $erros = [];
        
        // Validar Cliente
        if (empty($post['id_cliente'])) {
            $erros[] = "O cliente é obrigatório.";
        }
        
        // Validar Nota
        if (empty($post['nota_avaliacao'])) {
            $erros[] = "A nota é obrigatória.";
        } elseif (!in_array($post['nota_avaliacao'], ['1', '2', '3', '4', '5'])) {
            $erros[] = "Nota inválida. Selecione entre 1 e 5 estrelas.";
        }
        
        // Validar Status
        if (empty($post['status_avaliacao'])) {
            $erros[] = "O status é obrigatório.";
        } elseif (!in_array($post['status_avaliacao'], ['publicada', 'pendente', 'oculta'])) {
            $erros[] = "Status inválido.";
        }
        
        // Validar Descrição
        if (empty($post['descricao_avaliacao'])) {
            $erros[] = "A avaliação é obrigatória.";
        } elseif (strlen($post['descricao_avaliacao']) < 10) {
            $erros[] = "A avaliação deve ter no mínimo 10 caracteres.";
        } elseif (strlen($post['descricao_avaliacao']) > 1000) {
            $erros[] = "A avaliação deve ter no máximo 1000 caracteres.";
        }
        
        return $erros;
    }
}