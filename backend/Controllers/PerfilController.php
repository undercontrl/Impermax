<?php


namespace App\Impermax\Controllers;

use App\Impermax\Core\View;
use App\Impermax\Core\Flash;
use App\Impermax\Controllers\Admin\AuthenticatedController;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;

class PerfilController extends AuthenticatedController
{
    private Usuario $usuario;
    private $db;

    public function __construct()
    {
        // Permite acesso a admin e funcionario
        parent::__construct(['admin', 'funcionario']);
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
    }

    /**
     * Exibe a página de perfil do usuário
     */
    public function index(): void
    {
        $idUsuario = $_SESSION['usuario_id'] ?? null;
        
        if (!$idUsuario) {
            Flash::set('error', 'Usuário não autenticado');
            header('Location: /backend/login');
            exit;
        }

        $dados = $this->usuario->buscarUsuarioPorID($idUsuario);
        
        if (!$dados) {
            Flash::set('error', 'Usuário não encontrado');
            header('Location: /backend/login');
            exit;
        }

        View::render('perfil/index', [
            'usuario' => $dados,
            'nomeUsuario' => $_SESSION['nome_usuario'] ?? '',
            'tipoUsuario' => $_SESSION['tipo_usuario'] ?? ''
        ]);
    }

    /**
     * Atualiza informações do perfil (nome, email)
     */
    public function atualizar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /backend/perfil');
            exit;
        }

        $idUsuario = $_SESSION['usuario_id'] ?? null;
        
        if (!$idUsuario) {
            Flash::set('error', 'Usuário não autenticado');
            header('Location: /backend/login');
            exit;
        }

        // Validações
        $nome = trim($_POST['nome_usuario'] ?? '');
        $email = trim($_POST['email_usuario'] ?? '');

        if (empty($nome) || empty($email)) {
            Flash::set('error', 'Nome e email são obrigatórios');
            header('Location: /backend/perfil');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Flash::set('error', 'Email inválido');
            header('Location: /backend/perfil');
            exit;
        }

        // Verifica se email já existe (de outro usuário)
        $sql = "SELECT id_usuario FROM tbl_usuario WHERE email_usuario = :email AND id_usuario != :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $idUsuario);
        $stmt->execute();
        
        if ($stmt->fetch()) {
            Flash::set('error', 'Este email já está em uso');
            header('Location: /backend/perfil');
            exit;
        }

        // Busca dados atuais do usuário
        $dadosAtuais = $this->usuario->buscarUsuarioPorID($idUsuario);
        
        // Atualiza (mantém senha e tipo)
        $resultado = $this->usuario->atualizarUsuario(
            $idUsuario,
            $nome,
            $email,
            '', // Senha vazia = não altera
            $dadosAtuais['tipo_usuario'],
            $dadosAtuais['status_usuario']
        );

        if ($resultado) {
            // Atualiza sessão
            $_SESSION['nome_usuario'] = $nome;
            $_SESSION['email_usuario'] = $email;
            
            Flash::set('success', 'Perfil atualizado com sucesso!');
        } else {
            Flash::set('error', 'Erro ao atualizar perfil');
        }

        header('Location: /backend/perfil');
        exit;
    }

    /**
     * Atualiza a senha do usuário
     */
    public function atualizarSenha(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /backend/perfil');
            exit;
        }

        $idUsuario = $_SESSION['usuario_id'] ?? null;
        
        if (!$idUsuario) {
            Flash::set('error', 'Usuário não autenticado');
            header('Location: /backend/login');
            exit;
        }

        $senhaAtual = $_POST['senha_atual'] ?? '';
        $senhaNova = $_POST['senha_nova'] ?? '';
        $senhaConfirma = $_POST['senha_confirma'] ?? '';

        // Validações
        if (empty($senhaAtual) || empty($senhaNova) || empty($senhaConfirma)) {
            Flash::set('error', 'Todos os campos são obrigatórios');
            header('Location: /backend/perfil');
            exit;
        }

        if ($senhaNova !== $senhaConfirma) {
            Flash::set('error', 'As senhas não coincidem');
            header('Location: /backend/perfil');
            exit;
        }

        if (strlen($senhaNova) < 6) {
            Flash::set('error', 'A senha deve ter no mínimo 6 caracteres');
            header('Location: /backend/perfil');
            exit;
        }

        // Verifica senha atual
        $dadosUsuario = $this->usuario->buscarUsuarioPorID($idUsuario);
        
        if (!password_verify($senhaAtual, $dadosUsuario['senha_usuario'])) {
            Flash::set('error', 'Senha atual incorreta');
            header('Location: /backend/perfil');
            exit;
        }

        // Atualiza senha
        $resultado = $this->usuario->atualizarUsuario(
            $idUsuario,
            $dadosUsuario['nome_usuario'],
            $dadosUsuario['email_usuario'],
            $senhaNova, // Nova senha será hasheada automaticamente
            $dadosUsuario['tipo_usuario'],
            $dadosUsuario['status_usuario']
        );

        if ($resultado) {
            Flash::set('success', 'Senha alterada com sucesso!');
        } else {
            Flash::set('error', 'Erro ao alterar senha');
        }

        header('Location: /backend/perfil');
        exit;
    }

    /**
     * Faz upload da foto de perfil
     */
    public function atualizarFoto(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /backend/perfil');
            exit;
        }

        $idUsuario = $_SESSION['usuario_id'] ?? null;
        
        if (!$idUsuario) {
            Flash::set('error', 'Usuário não autenticado');
            header('Location: /backend/login');
            exit;
        }

        // Verifica se arquivo foi enviado
        if (!isset($_FILES['foto_usuario']) || $_FILES['foto_usuario']['error'] !== UPLOAD_ERR_OK) {
            Flash::set('error', 'Nenhum arquivo foi enviado');
            header('Location: /backend/perfil');
            exit;
        }

        $arquivo = $_FILES['foto_usuario'];
        
        // Validações
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
        $tamanhoMaximo = 2 * 1024 * 1024; // 2MB
        
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        
        if (!in_array($extensao, $extensoesPermitidas)) {
            Flash::set('error', 'Formato de arquivo não permitido. Use: JPG, PNG ou WEBP');
            header('Location: /backend/perfil');
            exit;
        }

        if ($arquivo['size'] > $tamanhoMaximo) {
            Flash::set('error', 'Arquivo muito grande. Tamanho máximo: 2MB');
            header('Location: /backend/perfil');
            exit;
        }

        // Verifica se é imagem real
        $imagemInfo = getimagesize($arquivo['tmp_name']);
        if ($imagemInfo === false) {
            Flash::set('error', 'O arquivo não é uma imagem válida');
            header('Location: /backend/perfil');
            exit;
        }

        // Define caminho de upload
        $diretorio = __DIR__ . '/../../public/uploads/avatars/';
        
        // Cria diretório se não existir
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        // Remove foto antiga se existir
        $dadosUsuario = $this->usuario->buscarUsuarioPorID($idUsuario);
        if (!empty($dadosUsuario['foto_usuario'])) {
            $fotoAntiga = $diretorio . $dadosUsuario['foto_usuario'];
            if (file_exists($fotoAntiga) && $dadosUsuario['foto_usuario'] !== 'default-avatar.png') {
                @unlink($fotoAntiga);
            }
        }

        // Gera nome único para o arquivo
        $nomeArquivo = 'avatar_' . $idUsuario . '_' . time() . '.' . $extensao;
        $caminhoCompleto = $diretorio . $nomeArquivo;

        // Move arquivo
        if (move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
            // Atualiza no banco de dados
            $sql = "UPDATE tbl_usuario SET foto_usuario = :foto, atualizado_em = NOW() WHERE id_usuario = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':foto', $nomeArquivo);
            $stmt->bindParam(':id', $idUsuario);
            
            if ($stmt->execute()) {
                // Tentar comprimir a imagem
                try {
                    \App\Impermax\Core\ImageCompressor::compress($caminhoCompleto, $caminhoCompleto);
                } catch (\Exception $e) {
                    // Ignorar erro de compressão
                }

                // Atualiza sessão
                $_SESSION['foto_usuario'] = $nomeArquivo;
                Flash::set('success', 'Foto atualizada com sucesso!');
            } else {
                // Remove arquivo se falhou no banco
                @unlink($caminhoCompleto);
                Flash::set('error', 'Erro ao salvar foto no banco de dados');
            }
        } else {
            Flash::set('error', 'Erro ao fazer upload da foto');
        }

        header('Location: /backend/perfil');
        exit;
    }

    /**
     * Remove a foto de perfil
     */
    public function removerFoto(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /backend/perfil');
            exit;
        }

        $idUsuario = $_SESSION['usuario_id'] ?? null;
        
        if (!$idUsuario) {
            Flash::set('error', 'Usuário não autenticado');
            header('Location: /backend/login');
            exit;
        }

        $dadosUsuario = $this->usuario->buscarUsuarioPorID($idUsuario);
        
        // Remove arquivo físico
        if (!empty($dadosUsuario['foto_usuario'])) {
            $diretorio = __DIR__ . '/../../public/upload/avatars/';
            $foto = $diretorio . $dadosUsuario['foto_usuario'];
            
            if (file_exists($foto) && $dadosUsuario['foto_usuario'] !== 'default-avatar.png') {
                @unlink($foto);
            }
        }

        // Atualiza banco
        $sql = "UPDATE tbl_usuario SET foto_usuario = NULL, atualizado_em = NOW() WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $idUsuario);
        
        if ($stmt->execute()) {
            unset($_SESSION['foto_usuario']);
            Flash::set('success', 'Foto removida com sucesso!');
        } else {
            Flash::set('error', 'Erro ao remover foto');
        }

        header('Location: /backend/perfil');
        exit;
    }
}