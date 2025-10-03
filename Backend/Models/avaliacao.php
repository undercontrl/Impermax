<?php
namespace App\Impermax\Models;
use PDO;
class avaliacao{
    private $id_avaliacao;
    private $id_cliente;
    private $descricao_avaliacao;
    private $nota_avaliacao;
    private $status_avaliacao;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // O construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
    //método de buscar todos as avaliações não excluídos
    function buscarAvaliacao(){
        $sql = 'SELECT * FROM tbl_avaliacao WHERE excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos as avaliações por status
    function buscarAvalicaoPorStatus($status_avaliacao){
        $sql = 'SELECT * FROM tbl_avaliacao WHERE status_avaliacao = :status_avaliacao AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':status_avaliacao', $status_avaliacao);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os avaliação por cliente
    function buscarAvaliacaoPorCliente($id_cliente){
        $sql = 'SELECT * FROM tbl_avaliacao WHERE id_cliente = :id_cliente AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar avaliação por id
    function buscarAvaliacaoPorId($id_cliente){
        $sql = 'SELECT * FROM tbl_avaliacao WHERE id_avaliacao = :id AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id_cliente);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    //método de inserir avaliação
    function inserirAvaliacao($id_cliente, $descricao_avaliacao, $nota_avaliacao, $status_avaliacao){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_avaliacao (id_cliente, descricao_avaliacao, nota_avaliacao, status_avaliacao, criado_em) 
        VALUES (:id_cliente, :descricao_avaliacao, :nota_avaliacao, :status_avaliacao, :criado)';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->bindParam(':descricao_avaliacao', $descricao_avaliacao);
        $statement->bindParam(':nota_avaliacao', $nota_avaliacao);
        $statement->bindParam(':status_avaliacao', $status_avaliacao);
        $statement->bindParam(':criado', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de atualizar a avaliação
    function atualizarAvaliacao($id_cliente, $descricao_avaliacao, $nota_avaliacao, $status_avaliacao){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_avaliacao SET id_cliente = :id_cliente, descricao_avaliacao = :descricao_avaliacao, 
        nota_avaliacao = :nota_avaliacao, status_avaliacao = :status_avaliacao, atualizado_em = :atualizado 
        WHERE id_avaliacao = :id_avaliacao';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->bindParam(':descricao_avaliacao', $descricao_avaliacao);
        $statement->bindParam(':nota_avaliacao', $nota_avaliacao);
        $statement->bindParam(':status_avaliacao', $status_avaliacao);
        $statement->bindParam(':atualizado', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de deletar a avaliação 
    function excluirAvaliacao($id_avaliacao
    ){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_avaliacao SET excluido_em = :excluido WHERE id_avaliacao = :id_avaliacao';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_avaliacao', $id_avaliacao);
        $statement->bindParam(':excluido', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
}