<?php
namespace App\Impermax\Models;
use PDO;

class item_agendamento {
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

    public function __construct($db){
        $this->db = $db;
    }

    // Buscar todos os itens não excluídos
    function buscarItemAgendamentos(){
        $sql = 'SELECT * FROM tbl_item_agendamento WHERE excluido IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar itens por agendamento
    function buscarItemAgendamentoPorAgendamento($id_agendamento){
        $sql = 'SELECT * FROM tbl_item_agendamento WHERE id_agendamento = :id_agendamento AND excluido IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_agendamento', $id_agendamento);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar itens por responsável
    function buscarItemAgendamentosPorResponsavel($id_responsavel){
        $sql = 'SELECT * FROM tbl_item_agendamento WHERE id_responsavel = :id_responsavel AND excluido IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_responsavel', $id_responsavel);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar item por ID
    function buscarItemAgendamentoPorId($id_item_agendamento){
        $sql = 'SELECT * FROM tbl_item_agendamento WHERE id_item_agendamento = :id_item_agendamento AND excluido IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_item_agendamento', $id_item_agendamento);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // Inserir item de agendamento
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
        return $statement->execute() ? $this->db->lastInsertId() : false;
    }

    // Atualizar item de agendamento
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
        return $statement->execute();
    }

    // Exclusão lógica
    function excluirItemAgendamento($id_item_agendamento){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_item_agendamento SET excluido = :excluido WHERE id_item_agendamento = :id_item_agendamento';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_item_agendamento', $id_item_agendamento);
        $statement->bindParam(':excluido', $dataAtual);
        return $statement->execute();
    }
}
