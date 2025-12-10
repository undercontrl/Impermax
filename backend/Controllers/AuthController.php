<?php
namespace App\Impermax\Controllers;

use App\Impermax\Core\View;
use App\Impermax\Core\Flash;
use App\Impermax\Core\Redirect;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\Session;
use App\Impermax\Validadores\UsuarioValidador;
use App\Impermax\Core\EmailNotification;

class AuthController {
    private Usuario $usuarioModel;
    private Session $session;
    private EmailNotification $emailNotification;

    public function __construct(){
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
        $this->session = new Session();
        $this->emailNotification = new EmailNotification();
    }

    public function login(): void {
        View::render('auth/login');
    }
    
    public function register(): void {
        View::render('auth/register');
    }
    

    public function logout(): void {
        $this->session->destroy();
        Redirect::redirecionarComMensagem('login', 'success', 'Você saiu com sucesso.');
    }

    public function authenticar(): void {
        $email = $_POST['email_usuario'] ?? null;
        $senha = $_POST['senha_usuario'] ?? null;

        $usuario = $this->usuarioModel->checarCredenciais($email, $senha);

        if ($usuario) {
            session_regenerate_id(true);
            $this->session->set('usuario_id', $usuario['id_usuario']);
            $this->session->set('usuario_nome', $usuario['nome_usuario']);
            $this->session->set('usuario_tipo', $usuario['tipo_usuario']);

            // 🔐 Redireciona conforme o tipo de usuário
            $tipo = strtolower($usuario['tipo_usuario']);

            if ($tipo === 'admin') {
                Redirect::redirecionarPara('admin/dashboard');
            } elseif ($tipo === 'funcionario') {
                Redirect::redirecionarPara('funcionario/dashboard');
            } elseif ($tipo === 'cliente') {
                // ✅ CLIENTE VAI PARA A PÁGINA DE AVALIAÇÃO
                Redirect::redirecionarPara('cliente/avaliacao');
            } else {
                // 🚫 bloqueia acesso de outros tipos
                $this->session->destroy();
                Redirect::redirecionarComMensagem('login', 'error', 'Acesso não autorizado.');
            }
        } else {
            Redirect::redirecionarComMensagem('login', 'error', 'E-mail ou senha incorretos.');
        }
    }   

    public function cadastrarUsuario(): void {
        $erros = UsuarioValidador::ValidarEntradas($_POST);

        if (!empty($erros)){
            Redirect::redirecionarComMensagem('register', 'error', implode("<br>", $erros));
        }

        $nome = $_POST['nome_usuario'] ?? null;
        $email = $_POST['email_usuario'] ?? null;
        $senha = $_POST['senha_usuario'] ?? null;
        $senha_confirm = $_POST['senha_confirm'] ?? null;

        if($senha != $senha_confirm) {
            Redirect::redirecionarComMensagem('register', 'error', 'As senhas não conferem.');
        }

        if(!empty($this->usuarioModel->buscarUsuariosPorEmail($email))){    
            Redirect::redirecionarComMensagem('register', 'error', 'E-mail já cadastrado.');
        }

        $novoUsuarioId = $this->usuarioModel->inserirUsuario($nome, $email, $senha, 'cliente', 'Ativo', null);

        if ($novoUsuarioId) {
            $this->emailNotification->boasVindas($email, $nome);
            Redirect::redirecionarComMensagem('login', 'success', 'Cadastro realizado! Faça o login.');
        } else {
            Redirect::redirecionarComMensagem('register', 'error', 'Erro no servidor. Tente novamente.');
        }
    }

    public function viewEsqueciSenha(): void {
        View::render('auth/esqueci-senha');
    }

    public function viewRedefinirSenha(): void {
        View::render('auth/redefinir-senha');
    }

    public function processarEsqueciSenha(): void {
        $email = $_POST['email_usuario'] ?? null;
        $usuario = $this->usuarioModel->buscarUsuariosPorEmail($email);

        if ($usuario) {
            $token = bin2hex(random_bytes(16));
            $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $this->usuarioModel->salvarTokenRedefinicao($usuario['id_usuario'], $token, $expiracao);
            $this->emailNotification->esqueciASenha($email, $token);
        }

        Redirect::redirecionarComMensagem('esqueci-senha', 'success', 'Se o e-mail existir em nosso sistema, um link de redefinição foi enviado.');
    }

    public function processarRedefinirSenha(): void {
        $token = $_POST['token'] ?? null;
        $novaSenha = $_POST['nova_senha'] ?? null;
        $confirmarSenha = $_POST['confirmar_senha'] ?? null;

        if ($novaSenha !== $confirmarSenha) {
            Redirect::redirecionarComMensagem("redefinir-senha?token=$token", 'error', 'As senhas não conferem.');
        }

        $usuario = $this->usuarioModel->buscarUsuarioPorToken($token);

        if ($usuario && strtotime($usuario['token_expiracao']) > time()) {
            $this->usuarioModel->atualizarSenha($usuario['id_usuario'], $novaSenha);
            $this->usuarioModel->limparTokenRedefinicao($usuario['id_usuario']);
            Redirect::redirecionarComMensagem('login', 'success', 'Senha redefinida com sucesso! Faça o login.');
        } else {
            Redirect::redirecionarComMensagem('esqueci-senha', 'error', 'Token inválido ou expirado. Solicite um novo link.');
        }
    }
}
