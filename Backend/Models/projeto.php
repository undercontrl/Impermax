<?php
namespace App\Impermax\Models;
use PDO;
class Projeto{
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
    function buscarProjetosPorDescricao($descricao){
        $sql = 'SELECT * FROM tbl_projeto where descricao_projeto = :descricao_projeto and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':descricao_projeto', $descricao);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarProjetoPorId($id){
    $sql = 'SELECT * FROM tbl_projeto WHERE id_projeto = :id AND excluido_em IS NULL';
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

 

    // metodo de inserir usuario
    function inserirProjeto($foto_antes_projeto, $foto_depois_projeto, $descricao){
        $sql = 'INSERT INTO tbl_projeto (foto_antes_projeto, foto_depois_projeto,
         descricao_projeto)
             VALUES (:foto_antes, :foto_depois, :descricao_projeto)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':foto_antes', $foto_antes_projeto);
        $stmt->bindParam(':foto_depois', $foto_depois_projeto);
        $stmt->bindParam(':descricao_projeto', $descricao);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario
    function atualizarProjeto($id, $foto_antes, $foto_depois, $descricao){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_projeto SET foto_antes_projeto = :foto_antes,
        foto_depois_projeto = :foto_depois,
        descricao_projeto = :descricao_projeto,
        atualizado_em = :atual
        Where id_projeto = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':foto_antes', $foto_antes);
        $stmt->bindParam(':foto_depois', $foto_depois);
        $stmt->bindParam(':descricao_projeto', $descricao);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de deletar o usuario 
    function excluirProjeto($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_projeto SET 
        excluido_em = :atual
        Where id_projeto = :id";
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