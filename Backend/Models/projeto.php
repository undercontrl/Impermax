<?php
class projeto{
    private $id_projeto;
    private $foto_antes_projeto;
    private $foto_depois_projeto;
    private $descricao_projeto;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e ou atributos 
    public function __construct($db){
        $this->db = $db;
      
    }
    // metodo de buscar todos os usuarios
    function buscarProjetos(){
        $sql = 'SELECT * FROM tbl_projeto where excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //metodo de buscar todos usuario por email
    function buscarUsuariosPorDescricao($descricao){
        $sql = 'SELECT * FROM tbl_projeto where descricao_projeto = :projeto and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function buscarProjetosPorData($data_solicitada){
        $sql = 'SELECT * FROM tbl_agendamento WHERE data_solicitada = :data_solicitada AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':data_solicitada', $data_solicitada);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
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
        $stmt->bindParam(':senha', $email);
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
        $stmt->bindParam(':id', $id);
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