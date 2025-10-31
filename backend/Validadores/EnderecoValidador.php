<?php
namespace App\Impermax\Validadores;

class EnderecoValidador
{
    public static function ValidarEntradas($dados)
    {
        $erros = [];

        // ID do usuário (relacionamento)
        if (isset($dados['id_usuario']) && empty(trim($dados['id_usuario']))) {
            $erros[] = "O campo Usuário é obrigatório.";
        }

        // CEP
        if (isset($dados['cep_endereco']) && empty(trim($dados['cep_endereco']))) {
            $erros[] = "O campo CEP é obrigatório.";
        } elseif (isset($dados['cep_endereco']) && !preg_match('/^\d{5}-?\d{3}$/', $dados['cep_endereco'])) {
            $erros[] = "O campo CEP deve estar no formato 00000-000.";
        }

        // Logradouro
        if (isset($dados['logadouro_endereco']) && empty(trim($dados['logadouro_endereco']))) {
            $erros[] = "O campo Logradouro é obrigatório.";
        }

        // Número
        if (isset($dados['numero_endereco']) && empty(trim($dados['numero_endereco']))) {
            $erros[] = "O campo Número é obrigatório.";
        }

        // Bairro
        if (isset($dados['bairro_endereco']) && empty(trim($dados['bairro_endereco']))) {
            $erros[] = "O campo Bairro é obrigatório.";
        }

        // Cidade
        if (isset($dados['cidade_endereco']) && empty(trim($dados['cidade_endereco']))) {
            $erros[] = "O campo Cidade é obrigatório.";
        }

        // UF
        if (isset($dados['uf_endereco']) && empty(trim($dados['uf_endereco']))) {
            $erros[] = "O campo UF é obrigatório.";
        } elseif (isset($dados['uf_endereco']) && !preg_match('/^[A-Z]{2}$/', strtoupper($dados['uf_endereco']))) {
            $erros[] = "O campo UF deve conter exatamente duas letras (ex: SP, RJ, BA).";
        }

        return $erros;
    }
}
