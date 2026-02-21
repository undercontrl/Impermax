<?php
namespace App\Impermax\Models;

use PDO;

class Contato {
    private $id_contato;
    private $nome_contato;
    private $telefone_contato;
    private $email_contato;
    private $assunto_contato;
    private $status_contato;
    private $data_envio;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarContatos() {
        $sql = 'SELECT * FROM tbl_contato WHERE excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    function buscarContatosExcluidos(){
        $sql = 'SELECT * FROM tbl_contato WHERE excluido_em IS NOT NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarContatosPorEmail($email){
        $sql = 'SELECT * FROM tbl_contato WHERE email_contato = :email AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarContatosPorStatus($status_contato){
        $sql = 'SELECT * FROM tbl_contato WHERE status_contato = :status_contato AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':status_contato', $status_contato);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarContatosPorData($data_envio){
        $sql = 'SELECT * FROM tbl_contato WHERE data_envio = :data_envio AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':data_envio', $data_envio);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarContatosPorCliente($nome_contato){
        $sql = 'SELECT * FROM tbl_contato WHERE nome_contato = :nome_contato AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':nome_contato', $nome_contato);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

public function buscarContatoPorId($id)
{
    $stmt = $this->db->prepare("SELECT * FROM tbl_contato WHERE id_contato = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna array ou false
}

    function inserirContato($nome_contato, $telefone_contato, $email_contato, $assunto_contato, $status_contato, $data_envio){
        $dataAtual = date('Y-m-d H:i:s');
        if (empty($data_envio)) {
            $data_envio = $dataAtual;
        }

        $sql = 'INSERT INTO tbl_contato (nome_contato, telefone_contato, email_contato, assunto_contato, status_contato, data_envio, criado_em) 
                VALUES (:nome_contato, :telefone_contato, :email_contato, :assunto_contato, :status_contato, :data_envio, :criado_em)';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':nome_contato', $nome_contato);
        $statement->bindParam(':telefone_contato', $telefone_contato);
        $statement->bindParam(':email_contato', $email_contato);
        $statement->bindParam(':assunto_contato', $assunto_contato);
        $statement->bindParam(':status_contato', $status_contato);
        $statement->bindParam(':data_envio', $data_envio);
        $statement->bindParam(':criado_em', $dataAtual);
        return $statement->execute() ? $this->db->lastInsertId() : false;
    }

    public function criar($dados)
{
    $sql = "INSERT INTO tbl_contato 
            (nome_contato, email_contato, telefone_contato, assunto_contato, status_contato, data_envio)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        $dados['nome_contato'],
        $dados['email_contato'],
        $dados['telefone_contato'],
        $dados['assunto_contato'],
        $dados['status_contato'],
        $dados['data_envio']
    ]);
}

    public function buscarPorId($id)
{
    $sql = 'SELECT * FROM tbl_contato WHERE id_contato = :id AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function atualizar($id, $dados)
{
    $sql = "UPDATE tbl_contato SET 
            nome_contato = ?, email_contato = ?, telefone_contato = ?, 
            assunto_contato = ?, status_contato = ?
            WHERE id_contato = ?";
    
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        $dados['nome_contato'],
        $dados['email_contato'],
        $dados['telefone_contato'],
        $dados['assunto_contato'],
        $dados['status_contato'],
        $id
    ]);
}

public function excluirContato($id)
{
    $dataAtual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_contato 
            SET status_contato = 'Inativo', 
                excluido_em = :atual 
            WHERE id_contato = :id";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataAtual);
    return $stmt->execute();
}

    public function salvar($dados)
{
    $sql = "INSERT INTO tbl_contato 
            (nome_contato, telefone_contato, email_contato, assunto_contato, status_contato, data_envio, criado_em)
            VALUES (:nome, :telefone, :email, :assunto, 'Novo', NOW(), NOW())";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':nome', $dados['nome']);
    $stmt->bindParam(':telefone', $dados['telefone']);
    $stmt->bindParam(':email', $dados['email']);
    $stmt->bindParam(':assunto', $dados['assunto']);

    return $stmt->execute();
}


public function listarTodos($pagina = 1, $porPagina = 20)
{
    $offset = ($pagina - 1) * $porPagina;
    $sql = "SELECT * FROM tbl_contato WHERE excluido_em IS NULL ORDER BY data_envio DESC LIMIT :offset, :porPagina";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
    $stmt->execute();
    
    $total = $this->db->query("SELECT COUNT(*) FROM tbl_contato WHERE excluido_em IS NULL")->fetchColumn();
    
    return [
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        'total' => (int)$total,
        'total_paginas' => (int)ceil($total / $porPagina)
    ];
}
    /**
     * Contar contatos em um período específico
     */

    public function contarPorPeriodo($dataInicio, $dataFim)
    {
        // Ajuste o nome da tabela e campos conforme sua estrutura
        $sql = 'SELECT COUNT(*) as total 
                FROM tbl_contato 
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
     * Buscar contatos agrupados por mês
     */
    public function buscarPorMes($dataInicio, $dataFim)
    {
        $sql = 'SELECT 
                    DATE_FORMAT(criado_em, "%Y-%m") as mes,
                    DATE_FORMAT(criado_em, "%b/%Y") as mes_formatado,
                    COUNT(*) as total
                FROM tbl_contato
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

   public function buscarContatosFiltrados($busca, $status, $periodo, $ordemCampo, $ordemDirecao, $limit, $offset)
{
    // GARANTE QUE ORDEM SEMPRE EXISTA
    $ordemCampo = in_array($ordemCampo, ['id_contato', 'nome_contato', 'email_contato', 'assunto_contato', 'status_contato', 'data_envio'])
        ? $ordemCampo : 'data_envio';
    $ordemDirecao = strtoupper($ordemDirecao) === 'ASC' ? 'ASC' : 'DESC';

    $sql = "SELECT * FROM tbl_contato WHERE status_contato != 'inativo' AND 1=1";
    $params = [];

    if ($busca) {
        $sql .= " AND (nome_contato LIKE :busca OR email_contato LIKE :busca OR telefone_contato LIKE :busca)";
        $params[':busca'] = "%$busca%";
    }
    if ($status) {
        $sql .= " AND status_contato = :status";
        $params[':status'] = $status;
    }
    if ($periodo) {
        $hoje = date('Y-m-d');
        $inicioSemana = date('Y-m-d', strtotime('monday this week'));
        $inicioMes = date('Y-m-01');
        switch ($periodo) {
            case 'hoje':
                $sql .= " AND DATE(data_envio) = :hoje";
                $params[':hoje'] = $hoje;
                break;
            case 'semana':
                $sql .= " AND data_envio >= :inicio_semana";
                $params[':inicio_semana'] = $inicioSemana;
                break;
            case 'mes':
                $sql .= " AND data_envio >= :inicio_mes";
                $params[':inicio_mes'] = $inicioMes;
                break;
        }
    }

    // SEMPRE TEM ORDER BY
    $sql .= " ORDER BY $ordemCampo $ordemDirecao LIMIT :limit OFFSET :offset";

    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





public function contarContatosFiltrados($busca, $status, $periodo)
{
    $sql = "SELECT COUNT(*) FROM tbl_contato WHERE 1=1 AND status_contato != 'inativo'";
    $params = [];

    if ($busca) {
        $sql .= " AND (nome_contato LIKE :busca OR email_contato LIKE :busca OR telefone_contato LIKE :busca)";
        $params[':busca'] = "%$busca%";
    }
    if ($status) {
        $sql .= " AND status_contato = :status";
        $params[':status'] = $status;
    }
    if ($periodo) {
        $hoje = date('Y-m-d');
        $inicioSemana = date('Y-m-d', strtotime('monday this week'));
        $inicioMes = date('Y-m-01');
        switch ($periodo) {
            case 'hoje':
                $sql .= " AND DATE(data_envio) = :hoje";
                $params[':hoje'] = $hoje;
                break;
            case 'semana':
                $sql .= " AND data_envio >= :inicio_semana";
                $params[':inicio_semana'] = $inicioSemana;
                break;
            case 'mes':
                $sql .= " AND data_envio >= :inicio_mes";
                $params[':inicio_mes'] = $inicioMes;
                break;
        }
    }

    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    return $stmt->fetchColumn();
}



public function buscarEstatisticas($busca, $status, $periodo)
{
    $sql = "SELECT 
        SUM(CASE WHEN status_contato = 'novo' THEN 1 ELSE 0 END) as novo,
        SUM(CASE WHEN status_contato = 'respondido' THEN 1 ELSE 0 END) as respondido,
        SUM(CASE WHEN status_contato = 'pendente' THEN 1 ELSE 0 END) as pendente,
        COUNT(*) as total
        FROM tbl_contato WHERE 1=1";
    
    $params = [];

    if ($busca) {
        $sql .= " AND (nome_contato LIKE :busca OR email_contato LIKE :busca OR telefone_contato LIKE :busca)";
        $params[':busca'] = "%$busca%";
    }
    if ($status) {
        $sql .= " AND status_contato = :status";
        $params[':status'] = $status;
    }
    if ($periodo) {
        $hoje = date('Y-m-d');
        $inicioSemana = date('Y-m-d', strtotime('monday this week'));
        $inicioMes = date('Y-m-01');
        switch ($periodo) {
            case 'hoje':
                $sql .= " AND DATE(data_envio) = :hoje";
                $params[':hoje'] = $hoje;
                break;
            case 'semana':
                $sql .= " AND data_envio >= :inicio_semana";
                $params[':inicio_semana'] = $inicioSemana;
                break;
            case 'mes':
                $sql .= " AND data_envio >= :inicio_mes";
                $params[':inicio_mes'] = $inicioMes;
                break;
        }
    }

    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



public function getStats()
{
    $stats = [
        'novo' => 0,
        'respondido' => 0,
        'pendente' => 0,
        'total' => 0
    ];

    // CONTAR SÓ OS ATIVOS (status != 'inativo')
    $stmt = $this->db->query("
        SELECT 
            SUM(CASE WHEN status_contato = 'novo' AND status_contato != 'inativo' THEN 1 ELSE 0 END) as novo,
            SUM(CASE WHEN status_contato = 'respondido' AND status_contato != 'inativo' THEN 1 ELSE 0 END) as respondido,
            SUM(CASE WHEN status_contato = 'pendente' AND status_contato != 'inativo' THEN 1 ELSE 0 END) as pendente,
            COUNT(*) as total_atual
        FROM tbl_contato 
        WHERE status_contato != 'inativo'
    ");
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $stats['novo'] = (int)($row['novo'] ?? 0);
    $stats['respondido'] = (int)($row['respondido'] ?? 0);
    $stats['pendente'] = (int)($row['pendente'] ?? 0);
    $stats['total'] = (int)($row['total_atual'] ?? 0);

    return $stats;
}


}
