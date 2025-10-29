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
        $sql = 'SELECT o.*, u.nome_usuario as cliente_nome 
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

}