<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Avaliacao;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;

/**
 * Controller para avaliações públicas (site)
 * Não requer autenticação
 */
class AvaliacaoPublicaController
{
    private $avaliacao;
    private $usuario;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->avaliacao = new Avaliacao($this->db);
        $this->usuario = new Usuario($this->db);
    }

    /**
     * Exibe o formulário público de avaliação
     */
    public function viewFormularioPublico()
    {
        View::render("site/avaliacao", []);
    }

    /**
     * Processa o envio da avaliação pública
     */
    public function enviarAvaliacaoPublica()
    {
        // Captura dados do formulário
        $nome = trim($_POST['nome_cliente'] ?? '');
        $email = trim($_POST['email_cliente'] ?? '');
        $nota = (int)($_POST['nota_avaliacao'] ?? 0);
        $descricao = trim($_POST['descricao_avaliacao'] ?? '');
        $aceitaTermos = isset($_POST['aceita_termos']);

        // Validações
        $erros = $this->validarDados($nome, $email, $nota, $descricao, $aceitaTermos);

        if (!empty($erros)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => implode('<br>', $erros)
            ]);
            exit;
        }

        // Verificar se o cliente já existe pelo email
        $clienteExistente = $this->usuario->buscarUsuariosPorEmail($email);

        if (!empty($clienteExistente)) {
            // Cliente já cadastrado
            $id_cliente = $clienteExistente[0]['id_usuario'];
        } else {
            // Criar novo cliente
            $id_cliente = $this->criarNovoCliente($nome, $email);
            
            if (!$id_cliente) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao cadastrar cliente. Tente novamente!'
                ]);
                exit;
            }
        }

        // Inserir avaliação com status "Pendente"
        $sucesso = $this->avaliacao->inserirAvaliacao(
            $id_cliente,
            $descricao,
            $nota,
            'Pendente' // Status padrão para avaliações públicas
        );

        if ($sucesso) {
            // Enviar email de notificação (opcional)
            $this->enviarNotificacaoAdmin($nome, $email, $nota, $descricao);

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Avaliação enviada com sucesso! Será analisada em breve.'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao enviar avaliação. Tente novamente!'
            ]);
        }
        exit;
    }

    /**
     * Valida os dados do formulário
     */
    private function validarDados($nome, $email, $nota, $descricao, $aceitaTermos)
    {
        $erros = [];

        // Validar nome
        if (empty($nome) || strlen($nome) < 3) {
            $erros[] = 'Nome deve ter no mínimo 3 caracteres';
        }

        // Validar email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'E-mail inválido';
        }

        // Validar nota
        if ($nota < 1 || $nota > 5) {
            $erros[] = 'Nota deve estar entre 1 e 5 estrelas';
        }

        // Validar descrição
        if (empty($descricao) || strlen($descricao) < 20) {
            $erros[] = 'Comentário deve ter no mínimo 20 caracteres';
        }

        if (strlen($descricao) > 500) {
            $erros[] = 'Comentário não pode ter mais de 500 caracteres';
        }

        // Validar termos
        if (!$aceitaTermos) {
            $erros[] = 'É necessário aceitar os termos de publicação';
        }

        // Proteção contra spam (verificar tempo mínimo)
        if (!$this->verificarAntiSpam()) {
            $erros[] = 'Aguarde alguns minutos antes de enviar outra avaliação';
        }

        return $erros;
    }

    /**
     * Cria um novo cliente no sistema
     */
    private function criarNovoCliente($nome, $email)
    {
        // Gerar senha temporária aleatória
        $senhaTemporaria = bin2hex(random_bytes(8));
        $senhaHash = password_hash($senhaTemporaria, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO tbl_usuario 
                    (nome_usuario, email_usuario, senha_usuario, tipo_usuario, status_usuario, criado_em) 
                    VALUES (:nome, :email, :senha, 'Cliente', 'Ativo', NOW())";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senhaHash);
            
            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            }
            
            return false;
        } catch (\Exception $e) {
            error_log("Erro ao criar cliente: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificação anti-spam simples
     * Limita avaliações por IP/sessão
     */
    private function verificarAntiSpam()
    {
        // Iniciar sessão se ainda não foi iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $tempoAtual = time();
        $tempoMinimo = 300; // 5 minutos entre avaliações

        // Verificar última avaliação na sessão
        if (isset($_SESSION['ultima_avaliacao'])) {
            $tempoDecorrido = $tempoAtual - $_SESSION['ultima_avaliacao'];
            
            if ($tempoDecorrido < $tempoMinimo) {
                return false; // Spam detectado
            }
        }

        // Atualizar timestamp
        $_SESSION['ultima_avaliacao'] = $tempoAtual;
        return true;
    }

    /**
     * Envia notificação por email para o admin
     * (Opcional - implementar conforme necessidade)
     */
    private function enviarNotificacaoAdmin($nome, $email, $nota, $descricao)
    {
        // TODO: Implementar envio de email
        // Exemplo: usar PHPMailer ou função mail() do PHP
        
        $assunto = "Nova Avaliação Pendente - Impermax";
        $mensagem = "
            <h2>Nova Avaliação Recebida</h2>
            <p><strong>Cliente:</strong> $nome</p>
            <p><strong>E-mail:</strong> $email</p>
            <p><strong>Nota:</strong> $nota estrelas</p>
            <p><strong>Comentário:</strong></p>
            <p>$descricao</p>
            <hr>
            <p>Acesse o painel administrativo para aprovar ou recusar esta avaliação.</p>
        ";

        // Descomentar quando configurar email
        // mail('admin@impermax.com', $assunto, $mensagem, $headers);
        
        return true;
    }

    /**
     * Exibe avaliações aprovadas no site (público)
     */
    public function listarAvaliacoesPublicas()
    {
        // Buscar apenas avaliações aprovadas
        $avaliacoes = $this->avaliacao->buscarAvalicaoPorStatus('Aprovado');

        View::render("site/avaliacoes-lista", [
            "avaliacoes" => $avaliacoes
        ]);
    }
}