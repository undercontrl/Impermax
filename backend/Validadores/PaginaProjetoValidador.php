<?php
namespace App\Impermax\Validadores;

class PaginaProjetoValidador
{
    /**
     * Valida entradas do formulário de serviço do site
     * 
     * @param array $post Dados do POST
     * @param array $files Dados do FILES
     * @param bool $isUpdate Se é uma atualização (imagem opcional)
     * @return array Array de erros (vazio se válido)
     */
    public static function validar(array $post, array $files, bool $isUpdate = false): array
    {
        $erros = [];

        // ========== VALIDAÇÃO DO NOME ==========
        if (empty($post['nome_projeto'])) {
            $erros[] = "O nome do serviço é obrigatório.";
        } elseif (strlen($post['nome_projeto']) < 3) {
            $erros[] = "O nome deve ter no mínimo 3 caracteres.";
        } elseif (strlen($post['nome_projeto']) > 255) {
            $erros[] = "O nome deve ter no máximo 255 caracteres.";
        }

        // ========== VALIDAÇÃO DA DESCRIÇÃO ==========
        if (empty($post['descricao_projeto'])) {
            $erros[] = "A descrição do serviço é obrigatória.";
        } elseif (strlen($post['descricao_projeto']) < 10) {
            $erros[] = "A descrição deve ter no mínimo 10 caracteres.";
        } elseif (strlen($post['descricao_projeto']) > 1000) {
            $erros[] = "A descrição deve ter no máximo 1000 caracteres.";
        }

        // ========== VALIDAÇÃO DA imagem ==========
        if (!$isUpdate) {
            // Na CRIAÇÃO, a imagem é OBRIGATÓRIA
            if (empty($files['imagem_projeto']['name'])) {
                $erros[] = "A imagem do serviço é obrigatória.";
            } else {
                $errosImagem = self::validarImagem($files['imagem_projeto'], 'imagem do Serviço');
                $erros = array_merge($erros, $errosImagem);
            }
        } else {
            // Na ATUALIZAÇÃO, validar apenas se houver nova imagem
            if (!empty($files['imagem_projeto']['name'])) {
                $errosImagem = self::validarImagem($files['imagem_projeto'], 'imagem do Serviço');
                $erros = array_merge($erros, $errosImagem);
            }
        }

        // ========== VALIDAÇÃO DO STATUS (apenas na edição) ==========
        if ($isUpdate && isset($post['status_projeto'])) {
            $statusValidos = ['Ativo', 'Inativo'];
            if (!in_array($post['status_projeto'], $statusValidos)) {
                $erros[] = "Status inválido. Use: Ativo ou Inativo.";
            }
        }

        return $erros;
    }

    /**
     * Valida uma imagem individual
     * Método 100% compatível - funciona em qualquer ambiente PHP
     * 
     * @param array $file Arquivo do $_FILES
     * @param string $label Nome do campo para mensagens
     * @return array Array de erros
     */
    private static function validarImagem(array $file, string $label): array
    {
        $erros = [];

        // ========== VERIFICAR ERROS DE UPLOAD ==========
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $mensagensErro = [
                UPLOAD_ERR_INI_SIZE => "$label: O arquivo excede o tamanho máximo permitido pelo servidor.",
                UPLOAD_ERR_FORM_SIZE => "$label: O arquivo excede o tamanho máximo do formulário.",
                UPLOAD_ERR_PARTIAL => "$label: O upload foi feito parcialmente.",
                UPLOAD_ERR_NO_FILE => "$label: Nenhum arquivo foi enviado.",
                UPLOAD_ERR_NO_TMP_DIR => "$label: Pasta temporária ausente.",
                UPLOAD_ERR_CANT_WRITE => "$label: Falha ao escrever o arquivo no disco.",
                UPLOAD_ERR_EXTENSION => "$label: Upload bloqueado por extensão PHP."
            ];
            
            $erros[] = $mensagensErro[$file['error']] ?? "$label: Erro desconhecido no upload (código: {$file['error']}).";
            return $erros;
        }

        // ========== VALIDAR TAMANHO (5MB MÁXIMO) ==========
        $tamanhoMaximo = 5 * 1024 * 1024; // 5MB em bytes
        if ($file['size'] > $tamanhoMaximo) {
            $tamanhoAtualMB = round($file['size'] / 1024 / 1024, 2);
            $erros[] = "$label: O arquivo não pode exceder 5MB. Tamanho atual: {$tamanhoAtualMB}MB";
        }

        // ========== VALIDAR SE ARQUIVO TEMPORÁRIO EXISTE ==========
        if (!file_exists($file['tmp_name'])) {
            $erros[] = "$label: Arquivo temporário não encontrado.";
            return $erros;
        }

        // ========== VALIDAR EXTENSÃO DO ARQUIVO ==========
        $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($extensao, $extensoesPermitidas)) {
            $erros[] = "$label: Extensão de arquivo inválida. Use: JPG, JPEG, PNG ou WEBP.";
        }

        // ========== VALIDAR SE É REALMENTE UMA IMAGEM ==========
        $imageInfo = @getimagesize($file['tmp_name']);
        
        if ($imageInfo === false) {
            $erros[] = "$label: O arquivo enviado não é uma imagem válida.";
            return $erros;
        }

        // ========== EXTRAIR INFORMAÇÕES DA IMAGEM ==========
        [$width, $height, $type] = $imageInfo;
        $mimeType = $imageInfo['mime'];

        // ========== VALIDAR TIPO MIME ==========
        $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        
        if (!in_array($mimeType, $tiposPermitidos)) {
            $erros[] = "$label: Tipo de imagem não permitido. Tipo detectado: $mimeType";
        }

        // ========== VALIDAR TIPO DE IMAGEM PELO CÓDIGO ==========
        // IMAGETYPE_JPEG = 2, IMAGETYPE_PNG = 3, IMAGETYPE_WEBP = 18
        $tiposCodigoPermitidos = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP];
        
        if (!in_array($type, $tiposCodigoPermitidos)) {
            $erros[] = "$label: Formato de imagem não suportado.";
        }

        // ========== VALIDAR DIMENSÕES MÍNIMAS ==========
        if ($width < 300 || $height < 300) {
            $erros[] = "$label: A imagem deve ter no mínimo 300x300 pixels. Dimensões atuais: {$width}x{$height}px";
        }

        // ========== VALIDAR DIMENSÕES MÁXIMAS ==========
        // Previne ataques de memória com imagens gigantes
        if ($width > 5000 || $height > 5000) {
            $erros[] = "$label: A imagem não pode exceder 5000x5000 pixels. Dimensões atuais: {$width}x{$height}px";
        }

        // ========== VALIDAR TAMANHO DO ARQUIVO VS DIMENSÕES ==========
        // Detecta possível arquivo corrompido
        $tamanhoEsperado = ($width * $height * 3) / 1024; // Estimativa em KB
        $tamanhoReal = $file['size'] / 1024;
        
        if ($tamanhoReal > ($tamanhoEsperado * 10)) {
            $erros[] = "$label: O arquivo pode estar corrompido ou em formato inadequado.";
        }

        return $erros;
    }

    /**
     * Valida entrada simples (apenas nome e descrição)
     * Útil para validações rápidas sem imagem
     * 
     * @param array $post Dados do POST
     * @return array Array de erros
     */
    public static function validarTexto(array $post): array
    {
        $erros = [];

        // Validar nome
        if (empty($post['nome_projeto'])) {
            $erros[] = "O nome do serviço é obrigatório.";
        } elseif (strlen($post['nome_projeto']) < 3) {
            $erros[] = "O nome deve ter no mínimo 3 caracteres.";
        } elseif (strlen($post['nome_projeto']) > 255) {
            $erros[] = "O nome deve ter no máximo 255 caracteres.";
        }

        // Validar descrição
        if (empty($post['descricao_projeto'])) {
            $erros[] = "A descrição do serviço é obrigatória.";
        } elseif (strlen($post['descricao_projeto']) < 10) {
            $erros[] = "A descrição deve ter no mínimo 10 caracteres.";
        } elseif (strlen($post['descricao_projeto']) > 1000) {
            $erros[] = "A descrição deve ter no máximo 1000 caracteres.";
        }

        return $erros;
    }

    /**
     * Retorna informações sobre uma imagem de forma segura
     * 
     * @param string $caminho Caminho do arquivo
     * @return array|false Informações da imagem ou false
     */
    public static function getImagemInfo(string $caminho)
    {
        if (!file_exists($caminho)) {
            return false;
        }

        $info = @getimagesize($caminho);
        
        if ($info === false) {
            return false;
        }

        return [
            'largura' => $info[0],
            'altura' => $info[1],
            'tipo' => $info[2],
            'mime' => $info['mime'],
            'tamanho' => filesize($caminho),
            'tamanho_mb' => round(filesize($caminho) / 1024 / 1024, 2)
        ];
    }
}
?>