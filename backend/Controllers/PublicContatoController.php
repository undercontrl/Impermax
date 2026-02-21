<?php
namespace App\Impermax\Controllers;
use App\Impermax\Core\Session;
use App\Impermax\Models\Contato;
use App\Impermax\Database\Database;
use App\Impermax\Core\EmailNotification;

class PublicContatoController
{
    private $model;
    private $secao;
    private EmailNotification $emailNotification;
    public function __construct()
    {
        $this->model = new Contato(Database::getInstance());
        $this->secao = new Session();
        $this->emailNotification = new EmailNotification();
    }

    public function enviar()
    {
        try {
            // === RATE LIMIT POR IP (3 ENVIO POR DIA) ===
            $ip = $this->getClientIp();
            $rateLimitFile = __DIR__ . '/storage/rate_limit.json';
            $today = date('Y-m-d');

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

            // === VERIFICAR HONEYPOT ===
            if (!empty($_POST['website'])) {
                if ($isAjax) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Spam detectado.'], JSON_UNESCAPED_UNICODE);
                    exit;
                }
                header("Location: /");
                exit;
            }

            // === VERIFICAR LIMITE ===
            $currentCount = $rateData[$ip]['count'] ?? 0;

            if ($currentCount >= 3) {
                $message = 'Limite diário excedido (3 envios). Tente novamente amanhã.';
                if ($isAjax) {
                    http_response_code(429);
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['status' => 'error', 'message' => $message], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $_SESSION['flash'] = ['type' => 'error', 'message' => $message];
                header("Location: /");
                exit;
            }

            // === CSRF ===
            $tokenFormulario = $_POST['csrf_token'] ?? '';
            $tokenSessao = $this->secao->get('csrf_token');
            if (empty($tokenFormulario) || $tokenFormulario !== $tokenSessao) {
                $message = 'Token CSRF inválido ou expirado. Recarregue a página.';
                if ($isAjax) {
                    http_response_code(400);
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['status' => 'error', 'message' => $message], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $_SESSION['flash'] = ['type' => 'error', 'message' => $message];
                header("Location: /");
                exit;
            }

            // === DADOS E VALIDAÇÃO ===
            $nome = trim($_POST['nome'] ?? '');
            $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $servico = $_POST['servico'] ?? '';

            if (empty($nome) || empty($telefone) || empty($email) || empty($servico)) {
                $message = 'Preencha todos os campos obrigatórios.';
                if ($isAjax) {
                    http_response_code(400);
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['status' => 'error', 'message' => $message], JSON_UNESCAPED_UNICODE);
                    exit;
                }
                $_SESSION['flash'] = ['type' => 'error', 'message' => $message];
                header("Location: /");
                exit;
            }

            $servicos = [
                'residencial' => 'Imp. Residencial',
                'comercial'   => 'Imp. Comercial',
                'telhado'     => 'Imp. Telhado',
                'laje'        => 'Imp. Laje'
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

                $this->saveRateLimitData($rateLimitFile, $rateData);

                // Enviar notificação por e-mail (falha aqui não deve impedir o sucesso do form)
                try {
                    $this->emailNotification->contatoRecebido($email, $nome);
                } catch (\Exception $e) {
                    error_log("Erro ao enviar e-mail de notificação: " . $e->getMessage());
                }

                if ($isAjax) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['status' => 'success', 'message' => 'Orçamento solicitado com sucesso!'], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Orçamento solicitado com sucesso!'];
            } else {
                throw new \Exception("Falha ao salvar contato no banco de dados.");
            }

            header("Location: /");
            exit;

        } catch (\Exception $e) {
            error_log("Erro no envio de contato: " . $e->getMessage());
            
            if ($isAjax) {
                http_response_code(500);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'error', 'message' => 'Ocorreu um erro interno. Tente novamente mais tarde.'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Ocorreu um erro interno.'];
            header("Location: /");
            exit;
        }
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