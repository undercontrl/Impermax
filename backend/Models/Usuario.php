<?php
namespace App\Impermax\Models;
use PDO;
class Usuario{
    private $id_usuario;
    private $nome_usuario;
    private $email_usuario;
    private $senha_usuario;
    private $tipo_usuario;
    private $status_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
   public function __construct($db) {
        $this->db = $db;
    }

    // ✅ LISTAR TODOS
    public function buscarUsuarios() {
    $sql = 'SELECT * FROM tbl_usuario WHERE excluido_em IS NULL ';
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // ✅ BUSCAR 1 POR ID (SINGULAR - CORRETO)
    public function buscarUsuarioPorID( $id) {
        $sql = 'SELECT * FROM tbl_usuario WHERE id_usuario = :id AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // ✅ fetch() - APENAS 1 registro
    }

    // ✅ BUSCAR POR EMAIL
    public function buscarUsuariosPorEmail($email) {
        $sql = 'SELECT * FROM tbl_usuario WHERE email_usuario = :email AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ BUSCAR POR TIPO
    public function buscarUsuariosPorTipo($tipo) {
        $sql = 'SELECT * FROM tbl_usuario WHERE tipo_usuario = :tipo AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ BUSCAR POR STATUS (CORRIGIDO)
    public function buscarUsuariosPorStatus($status) {
        $sql = 'SELECT * FROM tbl_usuario WHERE status_usuario = :status AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ INSERIR
    public function inserirUsuario($nome, $email, $senha, $tipo, $status) {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO tbl_usuario (nome_usuario, email_usuario, senha_usuario, tipo_usuario, status_usuario) 
                VALUES (:nome, :email, :senha, :tipo, :status)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // ✅ ATUALIZAR (CORRIGIDO)
    public function atualizarUsuario(int $id, $nome, $email, $senha, $tipo, $status) {
        $senhaHash = !empty($senha) ? password_hash($senha, PASSWORD_DEFAULT) : null;
        $dataAtual = date('Y-m-d H:i:s');
        
        $sql = "UPDATE tbl_usuario SET 
                nome_usuario = :nome,
                email_usuario = :email,
                senha_usuario = COALESCE(:senha, senha_usuario),
                tipo_usuario = :tipo,
                status_usuario = :status,
                atualizado_em = :atual 
                WHERE id_usuario = :id";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataAtual);
        
        return $stmt->execute();
    }

    // ✅ EXCLUIR (SOFT DELETE)
    public function excluirUsuario(int $id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET excluido_em = :atual WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }

    // ✅ GET CLIENTES
    public function getClientes(): array {
        $stmt = $this->db->prepare(
            "SELECT id_usuario, nome_usuario FROM tbl_usuario WHERE tipo_usuario = :tipo AND excluido_em IS NULL ORDER BY nome_usuario"
        );
        $stmt->execute([':tipo' => 'cliente']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function checarCredenciais(string $email, string $senha){
        $usuario = $this->buscarUsuariosPorEmail($email);
        if(count($usuario) !== 1) {
            return false;
        }
        $usuario = $usuario[0];
        if(password_verify($senha, $usuario['senha_usuario'])) {
            return $usuario;
        }
        return false;
    }
}