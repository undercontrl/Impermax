<?php
namespace App\Impermax\Validadores;

class ProjetoValidador
{
    /**
     * Valida entradas do formulário de projeto
     * 
     * @param array $post Dados do POST
     * @param array $files Dados do FILES
     * @param bool $isUpdate Se é uma atualização (imagens opcionais)
     * @return array Array de erros (vazio se válido)
     */
    public static function ValidarEntradas(array $post, array $files, bool $isUpdate = false): array
    {
        $erros = [];

        // Validação da descrição
        if (empty($post['descricao_projeto'])) {
            $erros[] = "A descrição do projeto é obrigatória.";
        } elseif (strlen($post['descricao_projeto']) < 10) {
            $erros[] = "A descrição deve ter no mínimo 10 caracteres.";
        } elseif (strlen($post['descricao_projeto']) > 500) {
            $erros[] = "A descrição deve ter no máximo 500 caracteres.";
        }

        // Validação das imagens (obrigatórias apenas na criação)
        if (!$isUpdate) {
            // Foto ANTES
            if (empty($files['foto_antes_projeto']['name'])) {
                $erros[] = "A foto ANTES do projeto é obrigatória.";
            } else {
                $errosImagem = self::validarImagem($files['foto_antes_projeto'], 'Foto ANTES');
                $erros = array_merge($erros, $errosImagem);
            }

            // Foto DEPOIS
            if (empty($files['foto_depois_projeto']['name'])) {
                $erros[] = "A foto DEPOIS do projeto é obrigatória.";
            } else {
                $errosImagem = self::validarImagem($files['foto_depois_projeto'], 'Foto DEPOIS');
                $erros = array_merge($erros, $errosImagem);
            }
        } else {
            // Na atualização, validar apenas se houver novas imagens
            if (!empty($files['foto_antes_projeto']['name'])) {
                $errosImagem = self::validarImagem($files['foto_antes_projeto'], 'Foto ANTES');
                $erros = array_merge($erros, $errosImagem);
            }

            if (!empty($files['foto_depois_projeto']['name'])) {
                $errosImagem = self::validarImagem($files['foto_depois_projeto'], 'Foto DEPOIS');
                $erros = array_merge($erros, $errosImagem);
            }
        }

        return $erros;
    }

    /**
     * Valida uma imagem individual
     */
    private static function validarImagem(array $file, string $label): array
    {
        $erros = [];

        // Verificar erros de upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $erros[] = "$label: Erro no upload da imagem.";
            return $erros;
        }

        // Validar tamanho (5MB máximo)
        $tamanhoMaximo = 5 * 1024 * 1024; // 5MB
        if ($file['size'] > $tamanhoMaximo) {
            $erros[] = "$label: O arquivo não pode exceder 5MB.";
        }

        // Validar tipo de arquivo
        $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $tiposPermitidos)) {
            $erros[] = "$label: Apenas imagens JPG, PNG ou WEBP são permitidas.";
        }

        // Validar dimensões da imagem (opcional, mas recomendado)
        $imageInfo = getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            $erros[] = "$label: Arquivo enviado não é uma imagem válida.";
        } else {
            // Verificar dimensões mínimas (opcional)
            [$width, $height] = $imageInfo;
            if ($width < 400 || $height < 300) {
                $erros[] = "$label: A imagem deve ter no mínimo 400x300 pixels.";
            }
        }

        return $erros;
    }
}