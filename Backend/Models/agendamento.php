<?php
namespace App\Impermax\Models;
use PDO;
class agendamento{
    private $id_agendamento;
    private $id_cliente;
    private $data_solicitada;
    private $total_agendamento;
    private $status_agendamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // O construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
    //método de buscar todos os agendamentos não excluídos
    function buscarAgendamentos(){
        $sql = 'SELECT * FROM tbl_agendamento WHERE excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os agendamentos por status
    function buscarAgendamentosPorStatus($status_agendamento){
        $sql = 'SELECT * FROM tbl_agendamento WHERE status_agendamento = :status_agendamento AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':status_agendamento', $status_agendamento);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os agendamentos por data
    function buscarAgendamentosPorData($data_solicitada){
        $sql = 'SELECT * FROM tbl_agendamento WHERE data_solicitada = :data_solicitada AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':data_solicitada', $data_solicitada);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os agendamentos por cliente
    function buscarAgendamentosPorCliente($id_cliente){
        $sql = 'SELECT * FROM tbl_agendamento WHERE id_cliente = :id_cliente AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar agendamento por id
    function buscarAgendamentoPorId($id_agendamento){
        $sql = 'SELECT * FROM tbl_agendamento WHERE id_agendamento = :id AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id_agendamento);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    //método de inserir agendamento
    function inserirAgendamento($id_cliente, $data_solicitada, $total_agendamento, $status_agendamento){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_agendamento (id_cliente, data_solicitada, total_agendamento, status_agendamento, criado_em) 
        VALUES (:id_cliente, :data_solicitada, :total_agendamento, :status_agendamento, :criado)';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->bindParam(':data_solicitada', $data_solicitada);
        $statement->bindParam(':total_agendamento', $total_agendamento);
        $statement->bindParam(':status_agendamento', $status_agendamento);
        $statement->bindParam(':criado', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de atualizar o agendamento
    function atualizarAgendamento($id_cliente, $data_solicitada, $total_agendamento, $status_agendamento){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_agendamento SET id_cliente = :id_cliente, data_solicitada = :data_solicitada, 
        total_agendamento = :total_agendamento, status_agendamento = :status_agendamento, atualizado_em = :atualizado 
        WHERE id_agendamento = :id_agendamento';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->bindParam(':data_solicitada', $data_solicitada);
        $statement->bindParam(':total_agendamento', $total_agendamento);
        $statement->bindParam(':status_agendamento', $status_agendamento);
        $statement->bindParam(':atualizado', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de deletar o agendamento
    function excluirAgendamento($id_agendamento){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_agendamento SET excluido_em = :excluido WHERE id_agendamento = :id_agendamento';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_agendamento', $id_agendamento);
        $statement->bindParam(':excluido', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
}