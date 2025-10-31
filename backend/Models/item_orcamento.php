<?php
namespace App\Impermax\Models;
use PDO;
class item_orcamento{
    private $id_item_orcamento;
    private $id_orcamento;
    private $id_servico;
    private $descricao_item_orcamento;
    private $metragem;
    private $status_item_orcamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    
    // O construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
    //método de buscar todos os item_orcamentos não excluídos
    function buscarItemOrcamento(){
        $sql = 'SELECT 
                    io.id_item_orcamento,
                    io.id_orcamento,
                    io.id_servico,
                    io.descricao_item_orcamento,
                    io.metragem,
                    io.status_item_orcamento,
                    o.id_cliente,
                    u.nome_usuario AS nome_cliente,
                    s.nome_servico
                FROM tbl_item_orcamento AS io
                LEFT JOIN tbl_orcamento AS o ON io.id_orcamento = o.id_orcamento
                LEFT JOIN tbl_usuario AS u ON o.id_cliente = u.id_usuario
                LEFT JOIN tbl_servico AS s ON io.id_servico = s.id_servico
                WHERE io.excluido_em IS NULL
                ORDER BY io.id_item_orcamento ASC';
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
    //método de buscar todos os item_orcamento por orcamento
    function buscarItemOrcamentoPorOrcamento($id_orcamento){
        $sql = 'SELECT * FROM tbl_item_orcamento WHERE id_orcamento = :id_orcamento AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_orcamento', $id_orcamento);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os item_orcamentos por servico
    function buscarItemOrcamentoPorServico($id_servico){
        $sql = 'SELECT * FROM tbl_item_orcamento WHERE id_servico = :id_servico AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_servico', $id_servico);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar item_orcamento por status
    function buscarItemOrcamentoPorStatus($status_item_orcamento){
        $sql = 'SELECT * FROM tbl_item_orcamento WHERE status_item_orcamento = :status_item_orcamento AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':status_item_orcamento', $status_item_orcamento);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar item_orcamento por id
    function buscarItemOrcamentoPorId($id_item_orcamento){
        $sql = 'SELECT * FROM tbl_item_orcamento WHERE id_item_orcamento = :id_item_orcamento AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_item_orcamento', $id_item_orcamento);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    //método de inserir item_orcamento
    function inserirItemOrcamento($id_orcamento, $id_servico, $descricao_item_orcamento, $metragem, $status_item_orcamento){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_item_orcamento (id_orcamento, id_servico, descricao_item_orcamento, metragem, status_item_orcamento, criado_em) 
                VALUES (:id_orcamento, :id_servico, :descricao_item_orcamento, :metragem, :status_item_orcamento, :criado_em)';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_orcamento', $id_orcamento);
        $statement->bindParam(':id_servico', $id_servico);
        $statement->bindParam(':descricao_item_orcamento', $descricao_item_orcamento);
        $statement->bindParam(':metragem', $metragem);
        $statement->bindParam(':status_item_orcamento', $status_item_orcamento);
        $statement->bindParam(':criado_em', $dataAtual);
        if($statement->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    //método de atualizar o item_orcamento
    function atualizarItemOrcamento($id_item_orcamento, $id_orcamento, $id_servico, $descricao_item_orcamento, $metragem, $status_item_orcamento){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_item_orcamento 
                SET id_orcamento = :id_orcamento, 
                    id_servico = :id_servico, 
                    descricao_item_orcamento = :descricao_item_orcamento, 
                    metragem = :metragem, 
                    status_item_orcamento = :status_item_orcamento, 
                    atualizado_em = :atualizado_em 
                WHERE id_item_orcamento = :id_item_orcamento AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_item_orcamento', $id_item_orcamento);
        $statement->bindParam(':id_orcamento', $id_orcamento);
        $statement->bindParam(':id_servico', $id_servico);
        $statement->bindParam(':descricao_item_orcamento', $descricao_item_orcamento);
        $statement->bindParam(':metragem', $metragem);
        $statement->bindParam(':status_item_orcamento', $status_item_orcamento);
        $statement->bindParam(':atualizado_em', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de deletar o item_orcamento
    function excluirAgendamento($id_item_orcamento){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_item_orcamento SET excluido_em = :excluido WHERE id_item_orcamento = :id_item_orcamento';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_item_orcamento', $id_item_orcamento);
        $statement->bindParam(':excluido', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
}