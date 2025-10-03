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
    //construtor inicializa a classe e ou atributos 
    public function __construct($db){
        $this->db = $db;
      
    }
    // metodo de buscar todos os usuarios
    function buscarUsuarios(){
        $sql = 'SELECT * FROM tbl_usuario where excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //metodo de buscar todos usuario por email
    function buscarUsuariosPorEmail($email){
        $sql = 'SELECT * FROM tbl_usuario where email_usuario = :email and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarUsuariosPorTipo($tipo){
        $sql = 'SELECT * FROM tbl_usuario where tipo_usuario = :tipo and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function buscarUsuariosPorStatus($status){
        $sql = 'SELECT * FROM tbl_usuario where status_usuarios = :status and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // metodo de inserir usuario
    function inserirUsuario($nome, $email, $senha, $tipo, $status){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO tbl_usuario (nome_usuario, email_usuario, 
        senha_usuario, tipo_usuario, status_usuario )
             VALUES (:nome, :email, :senha, :tipo, :status)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario
    function atualizarUsuario($nome, $email, $senha, $tipo, $status){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET nome_usuario = :nome,
        email_usuario = :email,
        senha_usuario = :senha,
        tipo_usuario = :tipo,
        staus_usuario = :status,
        atualizado_em = :atual
        Where id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $email);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de deletar o usuario 
    function excluirUsuario($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET 
        excluido_em = :atual 
        Where id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}