<?php
namespace App\Impermax\Controllers;
use App\Impermax\Core\Session;
use App\Impermax\Models\Contato;
use App\Impermax\Database\Database;

class PublicContatoController
{
    private $model;
    private $secao;
    public function __construct()
    {
        $this->model = new Contato(Database::getInstance());
        $this->secao = new Session();
    }

   public function enviar()
{
    // === RATE LIMIT POR IP (3 ENVIO POR DIA) ===
    $ip = $this->getClientIp();
    $rateLimitFile = __DIR__ . '/storage/rate_limit.json';
    $today = date('Y-m-d'); // Dia atual em UTC

    // Garantir diretório
    $storageDir = dirname($rateLimitFile);
    if (!is_dir($storageDir)) {
        mkdir($storageDir, 0755, true);
    }

    // Carregar dados
    $rateData = $this->loadRateLimitData($rateLimitFile);

    // === LIMPEZA DE DADOS ANTIGOS ===
    foreach ($rateData as $ipKey => $entry) {
        if ($entry['date'] !== $today) {
            unset($rateData[$ipKey]);
        }
    }

    // detectar se é requisição AJAX (fetch)
    $isAjax = false;
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        $isAjax = true;
    } elseif (!empty($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
        $isAjax = true;
    }

    // === VERIFICAR LIMITE ===
    $currentCount = $rateData[$ip]['count'] ?? 0;

    if ($currentCount >= 3) {
        $payload = ['type' => 'error', 'message' => 'Limite diário excedido (3 envios). Tente novamente amanhã.'];
        if ($isAjax) {
            http_response_code(429);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'error', 'message' => $payload['message']], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $_SESSION['flash'] = $payload;
        header("Location: /");
        exit;
    }

    // === CSRF ===
    $tokenFormulario = $_POST['csrf_token'] ?? '';
    $tokenSessao = $this->secao->get('csrf_token');
    if (empty($tokenFormulario) || $tokenFormulario !== $tokenSessao) {
        $payload = ['type' => 'error', 'message' => 'Token CSRF inválido.'];
        if ($isAjax) {
            http_response_code(400);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'error', 'message' => $payload['message']], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $_SESSION['flash'] = $payload;
        header("Location: /");
        exit;
    }

    // === DADOS E VALIDAÇÃO ===
    $nome = trim($_POST['nome'] ?? '');
    $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $servico = $_POST['servico'] ?? '';

    if (empty($nome) || empty($telefone) || empty($email) || empty($servico)) {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Preencha todos os campos.'];
        header("Location: /");
        exit;
    }

    $servicos = [
        'residencial' => 'Impermeabilização Residencial',
        'comercial'   => 'Impermeabilização Comercial',
        'telhado'     => 'Impermeabilização de Telhado',
        'laje'        => 'Impermeabilização de Laje'
    ];
    $assunto = $servicos[$servico] ?? $servico;

    // === SALVAR NO BANCO ===
    $sucesso = $this->model->salvar([
        'nome' => $nome,
        'telefone' => $telefone,
        'email' => $email,
        'assunto' => $assunto,
    ]);

    // === ATUALIZAR RATE LIMIT APENAS SE SALVOU COM SUCESSO ===
    if ($sucesso) {
        $rateData[$ip] = [
            'count' => $currentCount + 1,
            'date' => $today
        ];

        // SALVAR COM BLOQUEIO E ESCRITA ATÔMICA
        $this->saveRateLimitData($rateLimitFile, $rateData);

        if ($isAjax) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'success', 'message' => 'Orçamento solicitado com sucesso!'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Orçamento solicitado com sucesso!'];
    } else {
        if ($isAjax) {
            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'error', 'message' => 'Erro ao enviar.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erro ao enviar.'];
    }

    header("Location: /");
    exit;
}

// ==================== MÉTODOS AUXILIARES CORRIGIDOS ====================

private function getClientIp()
{
    $headers = [
        'HTTP_CF_CONNECTING_IP',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($headers as $key) {
        if (isset($_SERVER[$key])) {
            $list = explode(',', $_SERVER[$key]);
            $ip = trim($list[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return $ip;
            }
        }
    }
    return $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
}

private function loadRateLimitData($file)
{
    if (!file_exists($file)) {
        return [];
    }

    $content = @file_get_contents($file);
    if ($content === false) {
        return [];
    }

    $data = json_decode($content, true);
    return is_array($data) ? $data : [];
}

private function saveRateLimitData($file, $data)
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $tempFile = $file . '.' . uniqid() . '.tmp';

    // Escrita segura com bloqueio
    $fp = fopen($tempFile, 'c');
    if ($fp === false) {
        error_log("RateLimit: Falha ao abrir arquivo temporário: $tempFile");
        return false;
    }

    if (flock($fp, LOCK_EX)) {
        ftruncate($fp, 0);
        fwrite($fp, $json);
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);

        if (rename($tempFile, $file)) {
            @chmod($file, 0644);
            return true;
        }
    } else {
        fclose($fp);
    }

    @unlink($tempFile);
    error_log("RateLimit: Falha ao salvar rate limit para arquivo: $file");
    return false;
}
}