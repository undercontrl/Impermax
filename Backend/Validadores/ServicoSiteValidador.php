<?php
namespace App\Impermax\Validadores;

class ServicoSiteValidador
{
    /**
     * Valida os dados do formulário de serviço do site
     *
     * @param array $post Dados do formulário ($_POST)
     * @param array $files Dados do upload ($_FILES)
     * @param bool $isUpdate Se é edição (foto não obrigatória)
     * @return array Lista de erros (vazio se OK)
     */
    public static function validar(array $post, array $files = [], bool $isUpdate = false): array
    {
        $erros = [];

        // === NOME ===
        $nome = trim($post['nome_servico'] ?? '');
        if (empty($nome)) {
            $erros[] = "O nome do serviço é obrigatório.";
        } elseif (strlen($nome) < 3) {
            $erros[] = "O nome deve ter pelo menos 3 caracteres.";
        } elseif (strlen($nome) > 255) {
            $erros[] = "O nome não pode ter mais de 255 caracteres.";
        }

        // === DESCRIÇÃO ===
        $descricao = trim($post['descricao_servico'] ?? '');
        if (empty($descricao)) {
            $erros[] = "A descrição é obrigatória.";
        } elseif (strlen($descricao) < 10) {
            $erros[] = "A descrição deve ter pelo menos 10 caracteres.";
        } elseif (strlen($descricao) > 1000) {
            $erros[] = "A descrição não pode ter mais de 1000 caracteres.";
        }

        // === FOTO ===
        $fotoAtual = $post['foto_servico_atual'] ?? '';
        $temFotoNoBanco = !empty($fotoAtual);

        if (!$isUpdate && empty($files['foto_servico']['name']) && !$temFotoNoBanco) {
            $erros[] = "A foto do serviço é obrigatória ao criar.";
        }

        if (!empty($files['foto_servico']['name'])) {
            $uploadErro = self::validarUploadFoto($files['foto_servico']);
            if ($uploadErro) {
                $erros[] = $uploadErro;
            }
        }

        // === STATUS ===
        $status = $post['status_servico'] ?? '';
        if (!in_array($status, ['Ativo', 'Inativo'])) {
            $erros[] = "Status inválido.";
        }

        return $erros;
    }

    /**
     * Valida o arquivo de upload da foto
     */
    private static function validarUploadFoto(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return "Erro no upload da foto.";
        }

        $tamanhoMaximo = 5 * 1024 * 1024; // 5MB
        if ($file['size'] > $tamanhoMaximo) {
            return "A foto deve ter no máximo 5MB.";
        }

        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
        $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extensao, $extensoesPermitidas)) {
            return "Formato inválido. Use: JPG, PNG ou WEBP.";
        }

        // Verifica se é realmente uma imagem
        $tipoMime = mime_content_type($file['tmp_name']);
        if (!str_starts_with($tipoMime, 'image/')) {
            return "Arquivo não é uma imagem válida.";
        }

        return null;
    }
}