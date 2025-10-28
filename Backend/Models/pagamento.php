<?php
namespace App\Impermax\Models;
use PDO;

class Pagamento {
  private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    // ✅ LISTAR TODOS
    public function buscarPagamentos() {
        $sql = 'SELECT p.*, u.nome_usuario as cliente_nome,
                (p.dinheiro + p.credito + p.debito + p.pix) as total_pago
                FROM tbl_pagamento p 
                LEFT JOIN tbl_usuario u ON p.id_cliente = u.id_usuario 
                WHERE p.excluido_em IS NULL 
                ORDER BY p.id_pagamento DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ BUSCAR 1 POR ID
    public function buscarPagamentoPorID(int $id) {
        $sql = 'SELECT p.*, u.nome_usuario as cliente_nome,
                (p.dinheiro + p.credito + p.debito + p.pix) as total_pago
                FROM tbl_pagamento p 
                LEFT JOIN tbl_usuario u ON p.id_cliente = u.id_usuario 
                WHERE p.id_pagamento = :id AND p.excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ INSERIR - 1 ÚNICA LINHA
    public function inserirPagamento($id_cliente, $total_devedor, $dinheiro, $credito, $debito, $pix, $status_pagamento, $data_pagamento) {
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
        return $stmt->execute();
    }

    // ✅ ATUALIZAR - 1 ÚNICA LINHA
    public function atualizarPagamento(int $id, $id_cliente, $total_devedor, $dinheiro, $credito, $debito, $pix, $status_pagamento, $data_pagamento) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pagamento SET 
                id_cliente = :id_cliente,
                total_devedor = :total_devedor,
                dinheiro = :dinheiro,
                credito = :credito,
                debito = :debito,
                pix = :pix,
                status_pagamento = :status_pagamento,
                data_pagamento = :data_pagamento,
                atualizado_em = :atual 
                WHERE id_pagamento = :id";
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
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }

    // ✅ CALCULAR STATUS AUTOMÁTICO
    public function calcularStatus(float $total_devedor, float $total_pago) {
        return $total_pago >= $total_devedor ? 'pago' : 'aberto';
    }

    public function getClientes() {
        $sql = "SELECT id_usuario, nome_usuario FROM tbl_usuario WHERE tipo_usuario = 'cliente' AND excluido_em IS NULL ORDER BY nome_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirPagamento(int $id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pagamento SET excluido_em = :atual WHERE id_pagamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }

    //paginação
    public function listarInternos($pagina = 1, $porPagina = 20) {
    $offset = ($pagina - 1) * $porPagina;

    $sql = "SELECT 
                p.id_pagamento,
                p.valor_pagamento,
                p.data_pagamento,
                p.metodo_pagamento,
                c.nome_cliente
            FROM tbl_pagamento p
            LEFT JOIN tbl_cliente c ON p.id_cliente = c.id_cliente
            WHERE p.excluido_em IS NULL
            ORDER BY p.data_pagamento DESC
            LIMIT :offset, :porPagina";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total = $this->db->query("SELECT COUNT(*) FROM tbl_pagamento WHERE excluido_em IS NULL")->fetchColumn();
    $totalPaginas = ceil($total / $porPagina);

    return [
        'data' => $dados,
        'total' => (int)$total,
        'por_pagina' => (int)$porPagina,
        'pagina_atual' => (int)$pagina,
        'total_paginas' => (int)$totalPaginas
    ];
}
}