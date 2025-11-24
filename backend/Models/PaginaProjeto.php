<?php
namespace App\Impermax\Models;

use PDO;

class PaginaProjeto 
{
    private $db;

    public function __construct($db) 
    {
        $this->db = $db;
    }

    /**
     * Lista todos os projetos detalhados com paginação
     */
    public function listarTodos($pagina = 1, $porPagina = 12) 
    {
        $offset = ($pagina - 1) * $porPagina;

        $sql = "SELECT 
                    id_projeto,
                    nome_projeto,
                    imagem_projeto,
                    descricao_projeto,
                    status_projeto,
                    criado_em,
                    atualizado_em
                FROM tbl_projeto
                WHERE excluido_em IS NULL
                ORDER BY criado_em DESC
                LIMIT :offset, :porPagina";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Total de registros
        $totalStmt = $this->db->query("SELECT COUNT(*) FROM tbl_projeto WHERE excluido_em IS NULL");
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

  public function listarAtivos() 
{
    $sql = "SELECT 
                id_projeto,
                nome_projeto,
                imagem_projeto,
                descricao_projeto,
                criado_em
            FROM tbl_projeto
            WHERE status_projeto = 'Ativo' 
              AND excluido_em IS NULL
              AND nome_projeto IS NOT NULL
              AND nome_projeto != ''
              AND imagem_projeto IS NOT NULL
              AND imagem_projeto != ''
            ORDER BY criado_em DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    /**
     * Busca projeto por ID
     */
    public function buscarPorId($id) 
    {
        $sql = "SELECT * FROM tbl_projeto
                WHERE id_projeto = :id 
                AND excluido_em IS NULL";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insere novo projeto detalhado
     */
   public function inserir($nome, $imagem, $descricao, $status = 'Inativo') 
{
    $sql = "INSERT INTO tbl_projeto
            (nome_projeto, imagem_projeto, descricao_projeto, status_projeto, criado_em)
            VALUES (:nome, :imagem, :descricao, :status, NOW())";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':imagem', $imagem);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':status', $status);
    
    return $stmt->execute();
}

    /**
     * Atualiza projeto existente
     */
    public function atualizar($id, $nome, $imagem, $descricao, $status) 
    {
        $sql = "UPDATE tbl_projeto
                SET nome_projeto = :nome,
                    imagem_projeto = :imagem,
                    descricao_projeto = :descricao,
                    status_projeto = :status,
                    atualizado_em = NOW()
                WHERE id_projeto = :id 
                AND excluido_em IS NULL";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);
        
        return $stmt->execute();
    }

    /**
     * Alterna status (Ativo/Inativo)
     */
    public function alternarStatus($id) 
    {
        $projeto = $this->buscarPorId($id);
        if (!$projeto) return false;

        $novoStatus = $projeto['status_projeto'] === 'Ativo' ? 'Inativo' : 'Ativo';

        $sql = "UPDATE tbl_projeto
                SET status_projeto = :status, 
                    atualizado_em = NOW()
                WHERE id_projeto = :id 
                AND excluido_em IS NULL";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $novoStatus);
        
        return $stmt->execute();
    }

    /**
     * Exclusão lógica (soft delete)
     */
    public function excluir($id) 
    {
        $sql = "UPDATE tbl_projeto
                SET excluido_em = NOW()
                WHERE id_projeto = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Busca projetos por nome
     */
    public function buscarPorNome($nome) 
    {
        $sql = "SELECT * FROM tbl_projeto
                WHERE nome_projeto LIKE :nome 
                AND excluido_em IS NULL
                ORDER BY criado_em DESC";
        
        $stmt = $this->db->prepare($sql);
        $nome = "%{$nome}%";
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Estatísticas para dashboard
     */
    public function buscarEstatisticas() 
    {
        $sql = "SELECT 
                    COUNT(*) as total_projetos,
                    SUM(CASE WHEN status_projeto = 'Ativo' THEN 1 ELSE 0 END) as projetos_ativos,
                    SUM(CASE WHEN status_projeto = 'Inativo' THEN 1 ELSE 0 END) as projetos_inativos,
                    SUM(CASE WHEN imagem_projeto IS NOT NULL THEN 1 ELSE 0 END) as com_imagem
                FROM tbl_projeto
                WHERE excluido_em IS NULL";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>