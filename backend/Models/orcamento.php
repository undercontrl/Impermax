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
    
    public function __construct($db) {
        $this->db = $db;
    }

    // ✅ LISTAR TODOS (COM JOIN CLIENTE)
    public function buscarOrcamentos() {
        $sql = 'SELECT o.*, u.nome_usuario as cliente_nome 
                FROM tbl_orcamento o 
                LEFT JOIN tbl_usuario u ON o.id_cliente = u.id_usuario 
                WHERE o.excluido_em IS NULL 
                ORDER BY o.id_orcamento DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ BUSCAR 1 POR ID
    public function buscarOrcamentoPorID(int $id) {
        $sql = 'SELECT o.*, u.nome_usuario as cliente_nome, u.email_usuario 
                FROM tbl_orcamento o 
                LEFT JOIN tbl_usuario u ON o.id_cliente = u.id_usuario 
                WHERE o.id_orcamento = :id AND o.excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ INSERIR
    public function inserirOrcamento($id_cliente, $descricao_orcamento, $status_orcamento, $data_orcamento, $valor_orcamento, $total_item_orcamento) {
        $sql = 'INSERT INTO tbl_orcamento (id_cliente, descricao_orcamento, status_orcamento, data_orcamento, valor_orcamento, total_item_orcamento) 
                VALUES (:id_cliente, :descricao_orcamento, :status_orcamento, :data_orcamento, :valor_orcamento, :total_item_orcamento)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':descricao_orcamento', $descricao_orcamento);
        $stmt->bindParam(':status_orcamento', $status_orcamento);
        $stmt->bindParam(':data_orcamento', $data_orcamento);
        $stmt->bindParam(':valor_orcamento', $valor_orcamento);
        $stmt->bindParam(':total_item_orcamento', $total_item_orcamento);
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // ✅ ATUALIZAR (ERROS CORRIGIDOS)
    public function atualizarOrcamento(int $id, $id_cliente, $descricao_orcamento, $status_orcamento, $data_orcamento, $valor_orcamento, $total_item_orcamento) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_orcamento SET 
                id_cliente = :id_cliente,
                descricao_orcamento = :descricao_orcamento,
                status_orcamento = :status_orcamento,
                data_orcamento = :data_orcamento,
                valor_orcamento = :valor_orcamento,
                total_item_orcamento = :total_item_orcamento,
                atualizado_em = :atual 
                WHERE id_orcamento = :id";  // ✅ WHERE CORRIGIDO
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);  // ✅ ID CORRETO
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':descricao_orcamento', $descricao_orcamento);
        $stmt->bindParam(':status_orcamento', $status_orcamento);
        $stmt->bindParam(':data_orcamento', $data_orcamento);
        $stmt->bindParam(':valor_orcamento', $valor_orcamento);
        $stmt->bindParam(':total_item_orcamento', $total_item_orcamento);
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }

    // ✅ EXCLUIR
    public function excluirOrcamento(int $id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_orcamento SET excluido_em = :atual WHERE id_orcamento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }

    // ✅ GET CLIENTES
    public function getClientes() {
        $sql = "SELECT id_usuario, nome_usuario FROM tbl_usuario WHERE tipo_usuario = 'cliente' AND excluido_em IS NULL ORDER BY nome_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Contar orçamentos em andamento
    public function contarOrcamentosEmAndamento(): int
    {
        $sql = "SELECT COUNT(*) FROM tbl_orcamento 
                WHERE LOWER(status_orcamento) = 'em andamento'
                AND excluido_em IS NULL";
        return (int) $this->db->query($sql)->fetchColumn();
    }

    public function buscarOrcamentosComCliente(){
        $sql = 'SELECT o.*, u.nome_usuario as cliente_nome 
            FROM tbl_orcamento o 
            INNER JOIN tbl_usuario u ON o.id_cliente = u.id_usuario 
            WHERE o.excluido_em IS NULL 
            ORDER BY o.id_orcamento DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarPorPeriodo($dataInicio, $dataFim)
    {
        // Ajuste o nome da tabela e campos conforme sua estrutura
        $sql = 'SELECT COUNT(*) as total 
                FROM tbl_orcamento 
                WHERE excluido_em IS NULL
                AND criado_em BETWEEN :dataInicio AND :dataFim';
        
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':dataInicio', $dataInicio);
        $statement->bindParam(':dataFim', $dataFim);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    }

    /**
     * Buscar orçamentos agrupados por mês
     */
    public function buscarPorMes($dataInicio, $dataFim)
    {
        $sql = 'SELECT 
                    DATE_FORMAT(criado_em, "%Y-%m") as mes,
                    DATE_FORMAT(criado_em, "%b/%Y") as mes_formatado,
                    COUNT(*) as total
                FROM tbl_orcamento
                WHERE excluido_em IS NULL
                AND criado_em BETWEEN :dataInicio AND :dataFim
                GROUP BY DATE_FORMAT(criado_em, "%Y-%m")
                ORDER BY mes ASC';
        
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':dataInicio', $dataInicio);
        $statement->bindParam(':dataFim', $dataFim);
        $statement->execute();
        
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $dados = [];
        foreach ($resultados as $row) {
            $dados[] = [
                'mes' => $row['mes_formatado'],
                'total' => (int)$row['total']
            ];
        }
        
        return $dados;
    }

    /**
     * Busca orçamentos com filtros + ordenação + paginação
     */
    public function buscarOrcamentosComFiltros($busca = '', $status = '', $periodo = '', $pagina = 1, $itensPorPagina = 10, $ordenarPor = 'id_orcamento', $direcao = 'DESC')
    {
        $offset = ($pagina - 1) * $itensPorPagina;
        
        $sql = 'SELECT 
                    o.id_orcamento,
                    o.id_cliente,
                    u.nome_usuario AS cliente_nome,
                    u.email_usuario AS cliente_email,
                    o.descricao_orcamento,
                    o.status_orcamento,
                    o.data_orcamento,
                    o.valor_orcamento,
                    o.total_item_orcamento
                FROM tbl_orcamento o
                LEFT JOIN tbl_usuario u ON o.id_cliente = u.id_usuario
                WHERE o.excluido_em IS NULL';
        
        $params = [];

        // Filtro de busca
        if (!empty($busca)) {
            $sql .= ' AND (
                u.nome_usuario LIKE :busca 
                OR o.id_orcamento LIKE :busca
                OR o.descricao_orcamento LIKE :busca
            )';
            $params[':busca'] = '%' . $busca . '%';
        }

        // Filtro de status
        if (!empty($status)) {
            $sql .= ' AND o.status_orcamento = :status';
            $params[':status'] = $status;
        }

        // Filtro de período
        if (!empty($periodo)) {
            switch ($periodo) {
                case 'hoje':
                    $sql .= ' AND DATE(o.data_orcamento) = CURDATE()';
                    break;
                case 'semana':
                    $sql .= ' AND YEARWEEK(o.data_orcamento, 1) = YEARWEEK(CURDATE(), 1)';
                    break;
                case 'mes':
                    $sql .= ' AND MONTH(o.data_orcamento) = MONTH(CURDATE()) 
                            AND YEAR(o.data_orcamento) = YEAR(CURDATE())';
                    break;
            }
        }

        // Ordenação
        $camposPermitidos = ['id_orcamento', 'cliente_nome', 'data_orcamento', 'valor_orcamento', 'status_orcamento'];
        $campo = in_array($ordenarPor, $camposPermitidos) ? $ordenarPor : 'id_orcamento';
        $dir = strtoupper($direcao) === 'ASC' ? 'ASC' : 'DESC';
        
        if ($campo === 'cliente_nome') {
            $sql .= " ORDER BY u.nome_usuario $dir, o.id_orcamento DESC";
        } else {
            $sql .= " ORDER BY o.$campo $dir";
            if ($campo !== 'id_orcamento') {
                $sql .= ', o.id_orcamento DESC';
            }
        }

        $sql .= ' LIMIT :limit OFFSET :offset';

        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->bindValue(':limit', (int)$itensPorPagina, PDO::PARAM_INT);
        $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Conta total com filtros (para paginação)
     */
    public function contarOrcamentosComFiltros($busca = '', $status = '', $periodo = '')
    {
        $sql = 'SELECT COUNT(*) as total
                FROM tbl_orcamento o
                LEFT JOIN tbl_usuario u ON o.id_cliente = u.id_usuario
                WHERE o.excluido_em IS NULL';
        
        $params = [];

        if (!empty($busca)) {
            $sql .= ' AND (
                u.nome_usuario LIKE :busca 
                OR o.id_orcamento LIKE :busca
                OR o.descricao_orcamento LIKE :busca
            )';
            $params[':busca'] = '%' . $busca . '%';
        }

        if (!empty($status)) {
            $sql .= ' AND o.status_orcamento = :status';
            $params[':status'] = $status;
        }

        if (!empty($periodo)) {
            switch ($periodo) {
                case 'hoje':
                    $sql .= ' AND DATE(o.data_orcamento) = CURDATE()';
                    break;
                case 'semana':
                    $sql .= ' AND YEARWEEK(o.data_orcamento, 1) = YEARWEEK(CURDATE(), 1)';
                    break;
                case 'mes':
                    $sql .= ' AND MONTH(o.data_orcamento) = MONTH(CURDATE()) 
                            AND YEAR(o.data_orcamento) = YEAR(CURDATE())';
                    break;
            }
        }

        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        
        return (int)$resultado['total'];
    }

    /**
     * Calcula estatísticas (cards no topo)
     */
    public function calcularEstatisticas($busca = '', $status = '', $periodo = '')
    {
        $sql = 'SELECT 
                    o.status_orcamento as status,
                    COUNT(*) as quantidade,
                    SUM(o.valor_orcamento) as valor_total
                FROM tbl_orcamento o
                LEFT JOIN tbl_usuario u ON o.id_cliente = u.id_usuario
                WHERE o.excluido_em IS NULL';
        
        $params = [];

        if (!empty($busca)) {
            $sql .= ' AND (
                u.nome_usuario LIKE :busca 
                OR o.id_orcamento LIKE :busca
                OR o.descricao_orcamento LIKE :busca
            )';
            $params[':busca'] = '%' . $busca . '%';
        }

        if (!empty($status)) {
            $sql .= ' AND o.status_orcamento = :status';
            $params[':status'] = $status;
        }

        if (!empty($periodo)) {
            switch ($periodo) {
                case 'hoje':
                    $sql .= ' AND DATE(o.data_orcamento) = CURDATE()';
                    break;
                case 'semana':
                    $sql .= ' AND YEARWEEK(o.data_orcamento, 1) = YEARWEEK(CURDATE(), 1)';
                    break;
                case 'mes':
                    $sql .= ' AND MONTH(o.data_orcamento) = MONTH(CURDATE()) 
                            AND YEAR(o.data_orcamento) = YEAR(CURDATE())';
                    break;
            }
        }

        $sql .= ' GROUP BY o.status_orcamento';

        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->execute();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

        $stats = [
            'aprovado' => 0,
            'aguardando' => 0,
            'recusado' => 0,
            'em_analise' => 0,
            'valor_total' => 0
        ];

        foreach ($resultados as $row) {
            $statusNormalizado = $row['status'];
            
            if (isset($stats[$statusNormalizado])) {
                $stats[$statusNormalizado] = (int)$row['quantidade'];
            }
            
            // Soma total de valores
            $stats['valor_total'] += (float)$row['valor_total'];
        }

        return $stats;
    }

    /**
     * Altera status de múltiplos orçamentos
     */
    public function alterarStatusEmMassa($ids, $novoStatus)
    {
        if (empty($ids) || !is_array($ids)) {
            return false;
        }

        $dataAtual = date('Y-m-d H:i:s');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        $sql = "UPDATE tbl_orcamento 
                SET status_orcamento = ?, 
                    atualizado_em = ? 
                WHERE id_orcamento IN ($placeholders) 
                AND excluido_em IS NULL";
        
        $statement = $this->db->prepare($sql);
        
        $params = [$novoStatus, $dataAtual];
        $params = array_merge($params, $ids);
        
        return $statement->execute($params);
    }

    /**
     * Exclui múltiplos orçamentos (soft delete)
     */
    public function excluirEmMassa($ids)
    {
        if (empty($ids) || !is_array($ids)) {
            return false;
        }

        $dataAtual = date('Y-m-d H:i:s');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        $sql = "UPDATE tbl_orcamento 
                SET excluido_em = ? 
                WHERE id_orcamento IN ($placeholders) 
                AND excluido_em IS NULL";
        
        $statement = $this->db->prepare($sql);
        
        $params = [$dataAtual];
        $params = array_merge($params, $ids);
        
        return $statement->execute($params);
    }

    /**
     * Calcula receita total por período
     * Soma os valores de orçamentos aprovados no período especificado
     */
    public function calcularReceitaPorPeriodo($dataInicio, $dataFim)
    {
        $sql = 'SELECT SUM(valor_orcamento) as receita_total
                FROM tbl_orcamento
                WHERE excluido_em IS NULL
                AND status_orcamento = "aprovado"
                AND data_orcamento BETWEEN :dataInicio AND :dataFim';
        
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':dataInicio', $dataInicio);
        $statement->bindParam(':dataFim', $dataFim);
        $statement->execute();
        
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        
        return (float)($resultado['receita_total'] ?? 0);
    }

    // API paa proteção 

    public function paginacaoAPI(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_orcamento`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_orcamento` LIMIT :limit OFFSET :offset";
        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
        $lastPage = ceil($total_de_registros / $por_pagina);
 
        return [
            'data' => $dados
        ];
    }
}