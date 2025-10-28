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

    // === INTERNO: todos os serviços (com valor_base_servico) ===
    public function listarInternos($pagina = 1, $porPagina = 50) {
        $offset = ($pagina - 1) * $porPagina;
        $sql = "SELECT id_servico, nome_servico, descricao_servico, valor_base_servico, status_servico
                FROM tbl_servico
                WHERE excluido_em IS NULL
                ORDER BY id_servico DESC
                LIMIT :offset, :porPagina";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = $this->db->query("SELECT COUNT(*) FROM tbl_servico WHERE excluido_em IS NULL")->fetchColumn();

        return [
            'data' => $dados,
            'total' => (int)$total,
            'por_pagina' => (int)$porPagina,
            'pagina_atual' => (int)$pagina,
            'total_paginas' => (int)ceil($total / $porPagina)
        ];
    }

    // === SITE: apenas campos do site (nome, desc, foto, status) ===
    public function listarParaSite($pagina = 1, $porPagina = 10) {
        $offset = ($pagina - 1) * $porPagina;
        $sql = "SELECT id_servico, nome_servico, descricao_servico, foto_servico, status_servico
                FROM tbl_servico
                WHERE excluido_em IS NULL
                ORDER BY id_servico DESC
                LIMIT :offset, :porPagina";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = $this->db->query("SELECT COUNT(*) FROM tbl_servico WHERE excluido_em IS NULL")->fetchColumn();

        return [
            'data' => $dados,
            'total' => (int)$total,
            'por_pagina' => (int)$porPagina,
            'pagina_atual' => (int)$pagina,
            'total_paginas' => (int)ceil($total / $porPagina)
        ];
    }

    // === API: apenas ativos para o site ===
    public function listarAtivosParaSite() {
        $sql = "SELECT id_servico, nome_servico, descricao_servico, foto_servico
                FROM tbl_servico
                WHERE status_servico = 'Ativo' AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    // Buscar todos os serviços (ativos e inativos, mas não excluídos)
    public function buscarServicos()
    {
        $sql = "SELECT * FROM tbl_servico WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar um serviço por ID
    public function buscarServicoPorID(int $id)
    {
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar por nome
    public function buscarServicosPorNome($nome)
    {
        $sql = "SELECT * FROM tbl_servico WHERE nome_servico LIKE :nome AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $nome = "%{$nome}%";
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

 

    // Inserir novo serviço
    public function inserirServico($nome, $descricao, $valor, $foto_servico, $status)
    {
        $sql = "INSERT INTO tbl_servico (nome_servico, descricao_servico, valor_base_servico, foto_servico, status_servico)
                VALUES (:nome, :descricao, :valor, :foto, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':foto', $foto_servico);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    // Atualizar serviço existente
    public function atualizaServico($id, $nome, $descricao, $valor, $foto_servico, $status)
    {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_servico 
                SET nome_servico = :nome,
                    descricao_servico = :descricao,
                    valor_base_servico = :valor,
                    foto_servico = :foto,
                    status_servico = :status,
                    atualizado_em = :atualizado
                WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':foto', $foto_servico);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atualizado', $dataAtual);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Toggle status do serviço (Ativo <-> Inativo)
    public function deletarServico($id)
    {
        $servico = $this->buscarServicoPorID($id);
        if (!$servico) {
            return false;
        }
        $novoStatus = ($servico['status_servico'] === 'Ativo') ? 'Inativo' : 'Ativo';

        $sql = "UPDATE tbl_servico SET status_servico = :status WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $novoStatus);
        return $stmt->execute();
    }
}