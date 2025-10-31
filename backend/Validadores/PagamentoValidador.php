<?php
namespace App\Impermax\Validadores;

class PagamentoValidador
{
    /**
     * Valida entradas do formulário de pagamento
     * 
     * @param array $post Dados do POST
     * @return array Array de erros (vazio se válido)
     */
    public static function ValidarEntradas(array $post): array
    {
        $erros = [];

        // Validação do cliente
        if (empty($post['id_cliente'])) {
            $erros[] = "Selecione um cliente.";
        } elseif (!is_numeric($post['id_cliente']) || $post['id_cliente'] <= 0) {
            $erros[] = "Cliente inválido.";
        }

        // Validação do total devedor
        if (empty($post['total_devedor'])) {
            $erros[] = "O total devedor é obrigatório.";
        } elseif (!is_numeric($post['total_devedor']) || $post['total_devedor'] <= 0) {
            $erros[] = "O total devedor deve ser um valor positivo.";
        }

        // Validação dos valores de pagamento
        $dinheiro = floatval($post['dinheiro'] ?? 0);
        $credito = floatval($post['credito'] ?? 0);
        $debito = floatval($post['debito'] ?? 0);
        $pix = floatval($post['pix'] ?? 0);

        if ($dinheiro < 0 || $credito < 0 || $debito < 0 || $pix < 0) {
            $erros[] = "Os valores de pagamento não podem ser negativos.";
        }

        $totalPago = $dinheiro + $credito + $debito + $pix;
        
        if ($totalPago <= 0) {
            $erros[] = "É necessário informar pelo menos um valor de pagamento.";
        }

        // Validação da data do pagamento
        if (empty($post['data_pagamento'])) {
            $erros[] = "A data do pagamento é obrigatória.";
        } else {
            // Verifica se a data está no formato correto
            $data = \DateTime::createFromFormat('Y-m-d', $post['data_pagamento']);
            if (!$data || $data->format('Y-m-d') !== $post['data_pagamento']) {
                $erros[] = "Data do pagamento inválida.";
            }
        }

        return $erros;
    }

    /**
     * Valida valores monetários
     */
    private static function validarValorMonetario($valor, string $nomeCampo): ?string
    {
        if (!is_numeric($valor)) {
            return "O campo {$nomeCampo} deve ser um valor numérico.";
        }

        if ($valor < 0) {
            return "O campo {$nomeCampo} não pode ser negativo.";
        }

        return null;
    }
}