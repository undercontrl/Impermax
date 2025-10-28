<?php
namespace App\Impermax\Models;

use PDO;

class ServicoSite {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // === LISTAR TODOS PARA O DASHBOARD DO SITE ===
    public function listarTodos($pagina = 1, $porPagina = 10) {
        $offset = ($pagina - 1) * $porPagina;

        $sql = "SELECT 
                    id_servico,
                    nome_servico,
                    descricao_servico,
                    foto_servico,
                    status_servico
                FROM tbl_servico
                WHERE excluido_em IS NULL
                ORDER BY id_servico ASC
                LIMIT :offset, :porPagina";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = $this->db->query("SELECT COUNT(*) FROM tbl_servico WHERE excluido_em IS NULL")->fetchColumn();
        $totalPaginas = ceil($total / $porPagina);

        return [
            'data' => $dados,
            'total' => (int)$total,
            'por_pagina' => (int)$porPagina,
            'pagina_atual' => (int)$pagina,
            'total_paginas' => (int)$totalPaginas
        ];
    }

    // === LISTAR APENAS ATIVOS PARA O SITE (API) ===
    public function listarAtivos() {
        $sql = "SELECT 
                    id_servico,
                    nome_servico,
                    descricao_servico,
                    foto_servico
                FROM tbl_servico
                WHERE status_servico = 'Ativo' 
                  AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // === BUSCAR POR ID ===
    public function buscarPorId($id) {
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // === ALTERNAR STATUS ===
    public function alternarStatus($id) {
        $servico = $this->buscarPorId($id);
        if (!$servico) return false;

        $novoStatus = $servico['status_servico'] === 'Ativo' ? 'Inativo' : 'Ativo';

        $sql = "UPDATE tbl_servico 
                SET status_servico = :status, atualizado_em = NOW()
                WHERE id_servico = :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $novoStatus);
        return $stmt->execute();
    }

    public function inserir($nome, $descricao, $foto, $status = 'Inativo') {
    $sql = "INSERT INTO tbl_servico 
            (nome_servico, descricao_servico, foto_servico, status_servico)
            VALUES (:nome, :descricao, :foto, :status)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':foto', $foto);
    $stmt->bindParam(':status', $status);
    return $stmt->execute();
}

public function atualizar($id, $nome, $descricao, $foto, $status) {
    $sql = "UPDATE tbl_servico 
            SET nome_servico = :nome,
                descricao_servico = :descricao,
                foto_servico = :foto,
                status_servico = :status,
                atualizado_em = NOW()
            WHERE id_servico = :id AND excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':foto', $foto);
    $stmt->bindParam(':status', $status);
    return $stmt->execute();
}
}