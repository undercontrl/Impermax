<?php
namespace App\Impermax\Models;
use PDO;
class Avaliacao{
    private $id_avaliacao;
    private $id_cliente;
    private $descricao_avaliacao;
    private $nota_avaliacao;
    private $status_avaliacao;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    
    // O construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
    //método de buscar todos as avaliações não excluídos
    function buscarAvaliacao(){
        $sql = 'SELECT * FROM tbl_avaliacao as av INNER JOIN tbl_usuario as usu ON av.id_cliente = usu.id_usuario WHERE av.excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos as avaliações por status
    function buscarAvalicaoPorStatus($status_avaliacao){
        $sql = 'SELECT * FROM tbl_avaliacao WHERE status_avaliacao = :status_avaliacao AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':status_avaliacao', $status_avaliacao);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os avaliação por cliente
    function buscarAvaliacaoPorCliente($id_cliente){
        $sql = 'SELECT * FROM tbl_avaliacao WHERE id_cliente = :id_cliente AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar avaliação por id
    function buscarAvaliacaoPorId($id_avaliacao){
        $sql = 'SELECT av.*, usu.nome_usuario 
                FROM tbl_avaliacao AS av
                INNER JOIN tbl_usuario AS usu ON av.id_cliente = usu.id_usuario
                WHERE av.id_avaliacao = :id AND av.excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id_avaliacao);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }    
    //método de inserir avaliação
    function inserirAvaliacao($id_cliente, $descricao_avaliacao, $nota_avaliacao, $status_avaliacao){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_avaliacao (id_cliente, descricao_avaliacao, nota_avaliacao, status_avaliacao, criado_em) 
        VALUES (:id_cliente, :descricao_avaliacao, :nota_avaliacao, :status_avaliacao, :criado)';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->bindParam(':descricao_avaliacao', $descricao_avaliacao);
        $statement->bindParam(':nota_avaliacao', $nota_avaliacao);
        $statement->bindParam(':status_avaliacao', $status_avaliacao);
        $statement->bindParam(':criado', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de atualizar a avaliação
    function atualizarAvaliacao($id_avaliacao, $id_cliente, $descricao_avaliacao, $nota_avaliacao, $status_avaliacao){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_avaliacao SET id_cliente = :id_cliente, descricao_avaliacao = :descricao_avaliacao, 
        nota_avaliacao = :nota_avaliacao, status_avaliacao = :status_avaliacao, atualizado_em = :atualizado 
        WHERE id_avaliacao = :id_avaliacao';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_avaliacao', $id_avaliacao);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->bindParam(':descricao_avaliacao', $descricao_avaliacao);
        $statement->bindParam(':nota_avaliacao', $nota_avaliacao);
        $statement->bindParam(':status_avaliacao', $status_avaliacao);
        $statement->bindParam(':atualizado', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de deletar a avaliação 
    function excluirAvaliacao($id_avaliacao){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_avaliacao SET excluido_em = :excluido WHERE id_avaliacao = :id_avaliacao';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_avaliacao', $id_avaliacao);
        $statement->bindParam(':excluido', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function buscarAvaliacoesComFiltros(array $filtros = []): array{
        $sql = "SELECT av.*, usu.nome_usuario 
                FROM tbl_avaliacao AS av
                INNER JOIN tbl_usuario AS usu ON av.id_cliente = usu.id_usuario
                WHERE av.excluido_em IS NULL";
        
        $params = [];
        
        // Filtro de busca (nome do cliente ou descrição)
        if (!empty($filtros['busca'])) {
            $sql .= " AND (usu.nome_usuario LIKE :busca OR av.descricao_avaliacao LIKE :busca)";
            $params[':busca'] = '%' . $filtros['busca'] . '%';
        }
        
        // Filtro de status
        if (!empty($filtros['status'])) {
            $sql .= " AND av.status_avaliacao = :status";
            $params[':status'] = $filtros['status'];
        }
        
        // Filtro de nota
        if (!empty($filtros['nota'])) {
            $sql .= " AND av.nota_avaliacao = :nota";
            $params[':nota'] = $filtros['nota'];
        }
        
        // Ordenação
        if (!empty($filtros['ordem_campo']) && !empty($filtros['ordem_direcao'])) {
            $camposPermitidos = ['id_avaliacao', 'nome_usuario', 'nota_avaliacao', 'status_avaliacao', 'criado_em'];
            $campo = in_array($filtros['ordem_campo'], $camposPermitidos) ? $filtros['ordem_campo'] : 'av.criado_em';
            $direcao = strtoupper($filtros['ordem_direcao']) === 'ASC' ? 'ASC' : 'DESC';
            
            // Ajusta o campo se for nome_usuario
            if ($campo === 'nome_usuario') {
                $campo = 'usu.nome_usuario';
            } elseif (strpos($campo, '.') === false) {
                $campo = 'av.' . $campo;
            }
            
            $sql .= " ORDER BY {$campo} {$direcao}";
        } else {
            $sql .= " ORDER BY av.criado_em DESC";
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function contarPorStatus(): array
    {
        $sql = "SELECT status_avaliacao, COUNT(*) as total
                FROM tbl_avaliacao
                WHERE excluido_em IS NULL
                GROUP BY status_avaliacao";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        $resultado = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[strtolower($row['status_avaliacao'])] = (int)$row['total'];
        }
        
        return $resultado;
    }
}