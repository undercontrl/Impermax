<?php
class item_agendamento{
    private $id_item_agendamento;
    private $id_agendamento;
    private $id_servico;
    private $valor_servico;
    private $qtde_solicitada;
    private $total_item;
    private $id_responsavel;
    private $criado_em;
    private $atualizado_em;
    private $excluido;
    private $db;
    // O construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
    //método de buscar todos os item_agendamentos não excluídos
    function buscarItemAgendamento(){
        $sql = 'SELECT * FROM tbl_item_agendamento WHERE excluido IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os item_agendamento por agendamento
    function buscarItemAgendamentoPorAgendamento($id_agendamento){
        $sql = 'SELECT * FROM tbl_agendamento WHERE id_agendamento = :id_agendamento AND excluido IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_agendamento', $id_agendamento);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os item_agendamentos por cliente
    function buscarItemAgendamentosPorCliente($id_responsavel){
        $sql = 'SELECT * FROM tbl_agendamento WHERE id_responsavel = :id_responsavel AND excluido IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_responsavel', $id_responsavel);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar item_agendamento por id
    function buscarItemAgendamentoPorId($id_item_agendamento){
        $sql = 'SELECT * FROM tbl_agendamento WHERE id_item_agendamento = :id_item_agendamento AND excluido IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_item_agendamento', $id_item_agendamento);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    //método de inserir item_agendamento
    function inserirItemAgendamento($id_agendamento, $id_servico, $valor_servico, $qtde_solicitada, $total_item, $id_responsavel){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_item_agendamento (id_agendamento, id_servico, valor_servico, qtde_solicitada, total_item, id_responsavel, criado_em) 
                VALUES (:id_agendamento, :id_servico, :valor_servico, :qtde_solicitada, :total_item, :id_responsavel, :criado_em)';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_agendamento', $id_agendamento);
        $statement->bindParam(':id_servico', $id_servico);
        $statement->bindParam(':valor_servico', $valor_servico);
        $statement->bindParam(':qtde_solicitada', $qtde_solicitada);
        $statement->bindParam(':total_item', $total_item);
        $statement->bindParam(':id_responsavel', $id_responsavel);
        $statement->bindParam(':criado_em', $dataAtual);
        if($statement->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    //método de atualizar o item_agendamento
    function atualizarItemAgendamento($id_item_agendamento, $id_agendamento, $id_servico, $valor_servico, $qtde_solicitada, $total_item, $id_responsavel){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_item_agendamento 
                SET id_agendamento = :id_agendamento, 
                    id_servico = :id_servico, 
                    valor_servico = :valor_servico, 
                    qtde_solicitada = :qtde_solicitada, 
                    total_item = :total_item, 
                    id_responsavel = :id_responsavel, 
                    atualizado_em = :atualizado_em 
                WHERE id_item_agendamento = :id_item_agendamento AND excluido IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_item_agendamento', $id_item_agendamento);
        $statement->bindParam(':id_agendamento', $id_agendamento);
        $statement->bindParam(':id_servico', $id_servico);
        $statement->bindParam(':valor_servico', $valor_servico);
        $statement->bindParam(':qtde_solicitada', $qtde_solicitada);
        $statement->bindParam(':total_item', $total_item);
        $statement->bindParam(':id_responsavel', $id_responsavel);
        $statement->bindParam(':atualizado_em', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de deletar o item_agendamento
    function excluirAgendamento($id_item_agendamento){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_item_agendamento SET excluido = :excluido WHERE id_item_agendamento = :id_item_agendamento';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_item_agendamento', $id_item_agendamento);
        $statement->bindParam(':excluido', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
}