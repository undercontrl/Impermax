<?php
class Servicos{
    private $id_servico;
    private $nome_servico;
    private $descricao_servico;
    private $valor_base_servico;
    private $foto_servico;
    private $status_servico;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e ou atributos 
    public function __construct($db){
        $this->db = $db;
      
    }
    // metodo de buscar todos os usuarios
    function buscarServicos(){
        $sql = 'SELECT * FROM tbl_servico where excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //metodo de buscar todos servico por nome
    function buscarServicosPorNome($nome){
        $sql = 'SELECT * FROM tbl_servico where nome_servico = :nome and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarServicosPorStatus($status){
        $sql = 'SELECT * FROM tbl_servico where status_servico = :status and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de inserir usuario
    function inserirServico($nome, $descricao, $valor, $foto, $status){
        $sql = 'INSERT INTO tbl_servico (nome_servico, descricao_servico, 
        valor_base_servico, foto_servico , status_servico )
             VALUES (:nome, :descricao, :valor, :foto, :status)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':status', $status);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario
    function atualizaServico($nome, $descricao, $valor, $foto, $status){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_servico SET nome_servico = :nome,
        descricao_servico = :descricao,
        valor_base_servico = :valor,
        foto_servico = :foto,
        staus_servico = :status,
        atualizado_em = :atual
        Where id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de deletar o usuario 
    function excluirServico($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_servico SET 
        excluido_em = :atual
        Where id_servico = :id";
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