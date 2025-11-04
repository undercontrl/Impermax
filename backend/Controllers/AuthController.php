<?php
namespace App\Impermax\Controllers;

use App\Impermax\Core\View;
use App\Impermax\Core\Flash;
use App\Impermax\Core\Redirect;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\Session;
use App\Impermax\Validadores\UsuarioValidador;

class AuthController {
    private Usuario $usuarioModel;
    private Session $session;

    public function __construct(){
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
        $this->session = new Session();
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
                Redirect::redirecionarPara('avaliacao.php'); //arrumar depois
            }else {
                // 🚫 bloqueia acesso de outros tipos (ex: 'usuario')
                $this->session->destroy();
                Redirect::redirecionarComMensagem('login', 'error', 'Acesso restrito. Apenas administradores e funcionários podem entrar.');
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
            Redirect::redirecionarComMensagem('login', 'success', 'Cadastro realizado! Faça o login.');
        } else {
            Redirect::redirecionarComMensagem('register', 'error', 'Erro no servidor. Tente novamente.');
        }
    }
}
