<?php
namespace App\Impermax\Models;
use PDO;
class Orcamento{
    private $id_orcamento;
    private $id_cliente;
    private $descricao_orcamento;
    private $status_orcamento;
    private $data_orcamento;
    private $valor_orcamento;
    private $total_item_orcamento;
    private $criado_em;
    private $finalizado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e ou atributos 
    public function __construct($db){
        $this->db = $db;
      
    }
    // metodo de buscar todos os Orcamentos
    function buscarOrcamentos(){
        $sql = 'SELECT * FROM tbl_orcamento where excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //metodo de buscar todos Orcamentos por status
    function buscarOrcamentosPorStatus($status_orcamento){
        $sql = 'SELECT * FROM tbl_orcamento where status_orcamento = :status_orcamento and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status_orcamento', $status_orcamento);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarOrcamentosPorIdCliente($id_cliente){
        $sql = 'SELECT * FROM tbl_orcamento where id_cliente = :id_cliente and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de inserir pagamento
    function inserirOrcamento($id_cliente, $descricao_orcamento, $status_orcamento, $data_orcamento, $valor_orcamento, $total_item_orcamento){
        $sql = 'INSERT INTO tbl_orcamento (id_cliente, descricao_orcamento, status_orcamento, data_orcamento, valor_orcamento, total_item_orcamento)
             VALUES (:id_cliente, :descricao_orcamento, :status_orcamento, :data_orcamento, :valor_orcamento, :total_item_orcamento)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':descricao_orcamento', $descricao_orcamento);
        $stmt->bindParam(':status_orcamento', $status_orcamento);
        $stmt->bindParam(':data_orcamento', $data_orcamento);
        $stmt->bindParam(':valor_orcamento', $valor_orcamento);
        $stmt->bindParam(':total_item_orcamento', $total_item_orcamento);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o Orcamento
    function atualizarOrcamentos($id_cliente, $descricao_orcamento, $status_orcamento, $data_orcamento, $valor_orcamento, $total_item_orcamento){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_orcamento SET id_cliente = :id_cliente,
        descricao_orcamento = :descricao_orcamento,
        status_orcamento = :status_orcamento,
        data_orcamento = :data_orcamento,
        valor_orcamento = :valor_orcamento,
        total_item_orcamento = :total_item_orcamento,
        atualizado_em = :atual
        Where id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_cliente);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':descricao_orcamento', $descricao_orcamento);
        $stmt->bindParam(':status_orcamento', $status_orcamento);
        $stmt->bindParam(':data_orcamento', $data_orcamento);
        $stmt->bindParam(':valor_orcamento', $valor_orcamento);
        $stmt->bindParam(':total_item_orcamento', $total_item_orcamento);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de deletar o pagamento
    function excluirOrcamentos($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_orcamento SET 
        excluido_em = :atual
        Where id_orcamento = :id";
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