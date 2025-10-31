<?php
namespace App\Impermax\Models;
use PDO;

class Pagamento {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    // ==================== MÉTODOS PRINCIPAIS ====================
    
    /**
     * Listar todos os pagamentos
     */
    public function buscarPagamentos() {
        $sql = 'SELECT p.*, u.nome_usuario as cliente_nome,
                (p.dinheiro + p.credito + p.debito + p.pix) as total_pago
                FROM tbl_pagamento p 
                LEFT JOIN tbl_usuario u ON p.id_cliente = u.id_usuario 
                WHERE p.excluido_em IS NULL 
                ORDER BY p.data_pagamento DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar pagamento por ID
     */
    public function buscarPagamentoPorID(int $id) {
        $sql = 'SELECT p.*, u.nome_usuario as cliente_nome, u.email_usuario as cliente_email,
                (p.dinheiro + p.credito + p.debito + p.pix) as total_pago
                FROM tbl_pagamento p 
                LEFT JOIN tbl_usuario u ON p.id_cliente = u.id_usuario 
                WHERE p.id_pagamento = :id AND p.excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==================== MÉTODOS COM FILTROS E PAGINAÇÃO ====================
    
    /**
     * Buscar pagamentos com filtros, ordenação e paginação
     */
    public function buscarPagamentosFiltrados($busca = '', $status = '', $periodo = '', $ordemCampo = 'data_pagamento', $ordemDirecao = 'DESC', $limite = 10, $offset = 0)
    {
        $sql = 'SELECT 
                    p.id_pagamento,
                    p.id_cliente,
                    u.nome_usuario AS cliente_nome,
                    u.email_usuario AS cliente_email,
                    p.total_devedor,
                    p.dinheiro,
                    p.credito,
                    p.debito,
                    p.pix,
                    (p.dinheiro + p.credito + p.debito + p.pix) as total_pago,
                    p.status_pagamento,
                    p.data_pagamento,
                    p.criado_em
                FROM tbl_pagamento AS p
                INNER JOIN tbl_usuario AS u ON p.id_cliente = u.id_usuario
                WHERE p.excluido_em IS NULL';
        
        $params = [];
        
        // Filtro de busca
        if (!empty($busca)) {
            $sql .= ' AND (u.nome_usuario LIKE :busca OR p.id_pagamento LIKE :busca OR u.email_usuario LIKE :busca)';
            $params[':busca'] = "%$busca%";
        }
        
        // Filtro de status
        if (!empty($status)) {
            $sql .= ' AND p.status_pagamento = :status';
            $params[':status'] = $status;
        }
        
        // Filtro de período
        if (!empty($periodo)) {
            switch ($periodo) {
                case 'hoje':
                    $sql .= ' AND DATE(p.data_pagamento) = CURDATE()';
                    break;
                case 'semana':
                    $sql .= ' AND YEARWEEK(p.data_pagamento, 1) = YEARWEEK(CURDATE(), 1)';
                    break;
                case 'mes':
                    $sql .= ' AND MONTH(p.data_pagamento) = MONTH(CURDATE()) AND YEAR(p.data_pagamento) = YEAR(CURDATE())';
                    break;
            }
        }
        
        // Ordenação
        $camposValidos = ['id_pagamento', 'cliente_nome', 'data_pagamento', 'total_devedor', 'total_pago', 'status_pagamento'];
        if (!in_array($ordemCampo, $camposValidos)) {
            $ordemCampo = 'data_pagamento';
        }
        
        $ordemDirecao = strtoupper($ordemDirecao) === 'ASC' ? 'ASC' : 'DESC';
        $sql .= " ORDER BY $ordemCampo $ordemDirecao";
        
        // Paginação
        $sql .= ' LIMIT :limite OFFSET :offset';
        
        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->bindValue(':limite', $limite, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Contar total de pagamentos filtrados (para paginação)
     */
    public function contarPagamentosFiltrados($busca = '', $status = '', $periodo = '')
    {
        $sql = 'SELECT COUNT(*) as total
                FROM tbl_pagamento AS p
                INNER JOIN tbl_usuario AS u ON p.id_cliente = u.id_usuario
                WHERE p.excluido_em IS NULL';
        
        $params = [];
        
        if (!empty($busca)) {
            $sql .= ' AND (u.nome_usuario LIKE :busca OR p.id_pagamento LIKE :busca OR u.email_usuario LIKE :busca)';
            $params[':busca'] = "%$busca%";
        }
        
        if (!empty($status)) {
            $sql .= ' AND p.status_pagamento = :status';
            $params[':status'] = $status;
        }
        
        if (!empty($periodo)) {
            switch ($periodo) {
                case 'hoje':
                    $sql .= ' AND DATE(p.data_pagamento) = CURDATE()';
                    break;
                case 'semana':
                    $sql .= ' AND YEARWEEK(p.data_pagamento, 1) = YEARWEEK(CURDATE(), 1)';
                    break;
                case 'mes':
                    $sql .= ' AND MONTH(p.data_pagamento) = MONTH(CURDATE()) AND YEAR(p.data_pagamento) = YEAR(CURDATE())';
                    break;
            }
        }
        
        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    }
    
    /**
     * Buscar estatísticas dos pagamentos
     */
    public function buscarEstatisticas($busca = '', $status = '', $periodo = '')
    {
        $sql = 'SELECT 
                    COUNT(CASE WHEN p.status_pagamento = "pago" THEN 1 END) as pago,
                    COUNT(CASE WHEN p.status_pagamento = "aberto" THEN 1 END) as aberto,
                    SUM(p.total_devedor) as total_devedor,
                    SUM(p.dinheiro + p.credito + p.debito + p.pix) as total_recebido
                FROM tbl_pagamento AS p
                INNER JOIN tbl_usuario AS u ON p.id_cliente = u.id_usuario
                WHERE p.excluido_em IS NULL';
        
        $params = [];
        
        if (!empty($busca)) {
            $sql .= ' AND (u.nome_usuario LIKE :busca OR p.id_pagamento LIKE :busca OR u.email_usuario LIKE :busca)';
            $params[':busca'] = "%$busca%";
        }
        
        if (!empty($status)) {
            $sql .= ' AND p.status_pagamento = :status';
            $params[':status'] = $status;
        }
        
        if (!empty($periodo)) {
            switch ($periodo) {
                case 'hoje':
                    $sql .= ' AND DATE(p.data_pagamento) = CURDATE()';
                    break;
                case 'semana':
                    $sql .= ' AND YEARWEEK(p.data_pagamento, 1) = YEARWEEK(CURDATE(), 1)';
                    break;
                case 'mes':
                    $sql .= ' AND MONTH(p.data_pagamento) = MONTH(CURDATE()) AND YEAR(p.data_pagamento) = YEAR(CURDATE())';
                    break;
            }
        }
        
        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // ==================== CRUD BÁSICO ====================
    
    /**
     * Inserir novo pagamento
     */
    public function inserirPagamento($id_cliente, $total_devedor, $dinheiro, $credito, $debito, $pix, $status_pagamento, $data_pagamento) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_pagamento (id_cliente, total_devedor, dinheiro, credito, debito, pix, status_pagamento, data_pagamento, criado_em) 
                VALUES (:id_cliente, :total_devedor, :dinheiro, :credito, :debito, :pix, :status_pagamento, :data_pagamento, :criado)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':total_devedor', $total_devedor);
        $stmt->bindParam(':dinheiro', $dinheiro);
        $stmt->bindParam(':credito', $credito);
        $stmt->bindParam(':debito', $debito);
        $stmt->bindParam(':pix', $pix);
        $stmt->bindParam(':status_pagamento', $status_pagamento);
        $stmt->bindParam(':data_pagamento', $data_pagamento);
        $stmt->bindParam(':criado', $dataAtual);
        return $stmt->execute();
    }

    /**
     * Atualizar pagamento existente
     */
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
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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

    /**
     * Excluir pagamento (soft delete)
     */
    public function excluirPagamento(int $id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pagamento SET excluido_em = :atual WHERE id_pagamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }

    // ==================== MÉTODOS AUXILIARES ====================
    
    /**
     * Calcular status automático do pagamento
     */
    public function calcularStatus(float $total_devedor, float $total_pago) {
        return $total_pago >= $total_devedor ? 'pago' : 'aberto';
    }

    /**
     * Buscar lista de clientes
     */
    public function getClientes() {
        $sql = "SELECT id_usuario, nome_usuario, email_usuario 
                FROM tbl_usuario 
                WHERE tipo_usuario = 'cliente' AND excluido_em IS NULL 
                ORDER BY nome_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}