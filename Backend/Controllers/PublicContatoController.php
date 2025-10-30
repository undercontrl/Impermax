<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Contato;
use App\Impermax\Database\Database;

class PublicContatoController
{
    private $model;

    public function __construct()
    {
        $this->model = new Contato(Database::getInstance());
    }

    public function enviar()
    {
        // DADOS
        $nome = trim($_POST['nome'] ?? '');
        $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $servico = $_POST['servico'] ?? '';

        // VALIDAÇÃO
        if (empty($nome) || empty($telefone) || empty($email) || empty($servico)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Preencha todos os campos.'];
            return \App\Impermax\Core\Redirect::to('/');
        }

        // ASSUNTO
        $servicos = [
            'residencial' => 'Impermeabilização Residencial',
            'comercial'   => 'Impermeabilização Comercial',
            'telhado'     => 'Impermeabilização de Telhado',
            'laje'        => 'Impermeabilização de Laje'
        ];
        $assunto = $servicos[$servico] ?? $servico;

        // SALVAR
        $sucesso = $this->model->salvar([
            'nome' => $nome,
            'telefone' => $telefone,
            'email' => $email,
            'assunto' => $assunto,
        ]);

        // FLASH DIRETO NA SESSÃO
if ($sucesso) {
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Orçamento solicitado com sucesso!'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erro ao enviar.'];
}

header("Location: /");
exit;

    }
}