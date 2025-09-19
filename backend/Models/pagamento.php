<?php
class Pagamento{
    private $id_pagamento;
    private $id_cliente;
    private $total_devedor;
    private $dinheiro;
    private $credito;
    private $debito;
    private $pix;
    private $status_pagamento;
    private $data_pagamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e ou atributos 
    public function __construct($db){
        $this->db = $db;
      
    }
    // metodo de buscar todos os pagamentos
    function buscarPagamentos(){
        $sql = 'SELECT * FROM tbl_pagamento where excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //metodo de buscar todos pagamentos por status
    function buscarPagamentosPorStatus($status_pagamento){
        $sql = 'SELECT * FROM tbl_pagamento where status_pagamento = :status_pagamento and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status_pagamento', $status_pagamento);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de inserir pagamento
    function inserirPagamento($id_cliente, $total_devedor, $dinheiro, $credito, $debito, $pix, $status_pagamento, $data_pagamento){
        $sql = 'INSERT INTO tbl_pagamento (id_cliente, total_devedor, dinheiro, credito, debito, pix, status_pagamento, data_pagamento)
             VALUES (:id_cliente, :total_devedor, :dinheiro, :credito, :debito, :pix, :status_pagamento, :data_pagamento)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':total_devedor', $total_devedor);
        $stmt->bindParam(':dinheiro', $dinheiro);
        $stmt->bindParam(':credito', $credito);
        $stmt->bindParam(':debito', $debito);
        $stmt->bindParam(':pix', $pix);
        $stmt->bindParam(':status_pagamento', $status_pagamento);
        $stmt->bindParam(':data_pagamento', $data_pagamento);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o pagamento
    function atualizarPagamento($id_cliente, $total_devedor, $dinheiro, $credito, $debito, $pix, $status_pagamento, $data_pagamento){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pagamento SET id_cliente = :id_cliente,
        total_devedor = :total_devedor,
        dinheiro = :dinheiro,
        credito = :credito,
        debito = :debito,
        pix = :pix,
        staus_pagamento = :status_pagamento,
        data_pagamento = :data_pagamento,
        atualizado_em = :atual
        Where id_pagamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':total_devedor', $total_devedor);
        $stmt->bindParam(':dinheiro', $dinheiro);
        $stmt->bindParam(':credito', $credito);
        $stmt->bindParam(':debito', $debito);
        $stmt->bindParam(':pix', $pix);
        $stmt->bindParam(':status_pagamento', $status_pagamento);
        $stmt->bindParam(':data_pagamento', $data_pagamento);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de deletar o pagamento
    function excluirPagamento($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pagamento SET 
        excluido_em = :atual
        Where id_pagamento = :id";
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