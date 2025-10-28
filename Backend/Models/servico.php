<?php
namespace App\Impermax\Models;
use PDO;
class Servico{
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
     public function __construct($db)
    {
        $this->db = $db;
    }

    // Lista serviços para uso interno (sem foto, foco em valor)
public function listarInternos($pagina = 1, $porPagina = 20) {
    $offset = ($pagina - 1) * $porPagina;

    // REMOVA qualquer filtro de status_servico aqui!
    $sql = "SELECT id_servico, nome_servico, descricao_servico, valor_base_servico
            FROM tbl_servico 
            WHERE excluido_em IS NULL
            ORDER BY id_servico ASC
            LIMIT :offset, :porPagina";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalStmt = $this->db->query("SELECT COUNT(*) FROM tbl_servico WHERE excluido_em IS NULL");
    $total = $totalStmt->fetchColumn();
    $totalPaginas = ceil($total / $porPagina);

    return [
        'data' => $dados,
        'total' => (int)$total,
        'por_pagina' => (int)$porPagina,
        'pagina_atual' => (int)$pagina,
        'total_paginas' => (int)$totalPaginas
    ];
}

// Exclusão interna (soft delete)
public function deletarServicoInterno($id) {
    $dataExclusao = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_servico 
            SET excluido_em = :excluido_em, status_servico = 'Inativo'
            WHERE id_servico = :id AND excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':excluido_em', $dataExclusao);
    return $stmt->execute();
}

// Busca por nome (para interno)
public function buscarServicosPorNome($nome) {
    $sql = "SELECT id_servico, nome_servico, descricao_servico, valor_base_servico
            FROM tbl_servico 
            WHERE nome_servico LIKE :nome AND excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $nome = "%{$nome}%";
    $stmt->bindParam(':nome', $nome);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// === CRUD (mantém os existentes, mas ajusta inserção) ===
public function inserirServico($nome, $descricao, $valor) {
        $sql = "INSERT INTO tbl_servico 
                (nome_servico, descricao_servico, valor_base_servico, status_servico)
                VALUES (:nome, :descricao, :valor, 'Inativo')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        return $stmt->execute();
    }

public function atualizarServico($id, $nome, $descricao, $valor) {
        $sql = "UPDATE tbl_servico 
                SET nome_servico = :nome,
                    descricao_servico = :descricao,
                    valor_base_servico = :valor,
                    atualizado_em = NOW()
                WHERE id_servico = :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        return $stmt->execute();
    }


// Buscar um serviço (mantém)
public function buscarServicoPorID(int $id) {
    $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id AND excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}