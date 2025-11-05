<?php
namespace App\Impermax\Models;
use PDO;

class Projeto
{
    private $id_projeto;
    private $foto_antes_projeto;
    private $foto_depois_projeto;
    private $descricao_projeto;
    private $status_projeto;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    // ==================== MÉTODOS PRINCIPAIS ====================
    
    // Buscar todos os projetos
    public function buscarProjetos()
    {
        $sql = 'SELECT *, status_projeto FROM tbl_projeto WHERE excluido_em IS NULL ORDER BY criado_em DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Buscar projeto por ID
    public function buscarProjetoPorID($id)
    {
        $sql = 'SELECT * FROM tbl_projeto WHERE id_projeto = :id AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Buscar projetos por descrição
    public function buscarProjetosPorDescricao($descricao)
    {
        $sql = 'SELECT * FROM tbl_projeto WHERE descricao_projeto LIKE :descricao AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $descricaoBusca = "%$descricao%";
        $stmt->bindParam(':descricao', $descricaoBusca);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // ==================== MÉTODOS COM FILTROS E PAGINAÇÃO ====================
    
    /**
     * Buscar projetos com filtros, ordenação e paginação
     */
public function buscarProjetosFiltrados($busca = '', $ordemCampo = 'criado_em', $ordemDirecao = 'DESC', $limite = 12, $offset = 0)
{
    $sql = 'SELECT 
                id_projeto,
                foto_antes_projeto,
                foto_depois_projeto,
                descricao_projeto,
                status_projeto,
                criado_em,
                atualizado_em
            FROM tbl_projeto
            WHERE excluido_em IS NULL';
    
    $params = [];
    
    // Filtro de busca
    if (!empty($busca)) {
        $sql .= ' AND (descricao_projeto LIKE :busca OR id_projeto LIKE :busca)';
        $params[':busca'] = "%$busca%";
    }
    
    // Ordenação
    $camposValidos = ['id_projeto', 'descricao_projeto', 'criado_em', 'atualizado_em'];
    if (!in_array($ordemCampo, $camposValidos)) {
        $ordemCampo = 'criado_em';
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
     * Contar total de projetos filtrados (para paginação)
     */
    public function contarProjetosFiltrados($busca = '')
    {
        $sql = 'SELECT COUNT(*) as total
                FROM tbl_projeto
                WHERE excluido_em IS NULL';
        
        $params = [];
        
        if (!empty($busca)) {
            $sql .= ' AND (descricao_projeto LIKE :busca OR id_projeto LIKE :busca)';
            $params[':busca'] = "%$busca%";
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
     * Buscar estatísticas dos projetos
     */
    public function buscarEstatisticas($busca = '')
    {
        $sql = 'SELECT 
                    COUNT(*) as total_projetos,
                    COUNT(CASE WHEN DATE(criado_em) = CURDATE() THEN 1 END) as projetos_hoje,
                    COUNT(CASE WHEN YEARWEEK(criado_em, 1) = YEARWEEK(CURDATE(), 1) THEN 1 END) as projetos_semana,
                    COUNT(CASE WHEN MONTH(criado_em) = MONTH(CURDATE()) AND YEAR(criado_em) = YEAR(CURDATE()) THEN 1 END) as projetos_mes
                FROM tbl_projeto
                WHERE excluido_em IS NULL';
        
        $params = [];
        
        if (!empty($busca)) {
            $sql .= ' AND (descricao_projeto LIKE :busca OR id_projeto LIKE :busca)';
            $params[':busca'] = "%$busca%";
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
     * Inserir novo projeto
     */
    public function inserirProjeto($foto_antes_projeto, $foto_depois_projeto, $descricao, $status_projeto = 'Inativo')
    {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_projeto (foto_antes_projeto, foto_depois_projeto, descricao_projeto, status_projeto, criado_em) 
                VALUES (:foto_antes, :foto_depois, :descricao, :status_projeto, :criado)';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':foto_antes', $foto_antes_projeto);
        $stmt->bindParam(':foto_depois', $foto_depois_projeto);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status_projeto', $status_projeto);
        $stmt->bindParam(':criado', $dataAtual);
        
        return $stmt->execute();
    }
    
    /**
     * Atualizar projeto existente
     */
    public function atualizarProjeto($id, $foto_antes, $foto_depois, $descricao, $status_projeto)
    {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_projeto 
                SET foto_antes_projeto = :foto_antes,
                    foto_depois_projeto = :foto_depois,
                    descricao_projeto = :descricao,
                    status_projeto = :status_projeto,
                    atualizado_em = :atualizado
                WHERE id_projeto = :id';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':foto_antes', $foto_antes);
        $stmt->bindParam(':foto_depois', $foto_depois);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status_projeto', $status_projeto);
        $stmt->bindParam(':atualizado', $dataAtual);
        
        return $stmt->execute();
    }
    
    /**
     * Excluir projeto (soft delete)
     */
    public function excluirProjeto($id)
    {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_projeto SET excluido_em = :excluido WHERE id_projeto = :id';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':excluido', $dataAtual);
        
        return $stmt->execute();
    }
    
    // ==================== MÉTODOS PARA DASHBOARD ====================
    
    /**
     * Buscar projetos recentes (últimos X)
     */
public function buscarRecentes($limite = 6)
{
    $sql = 'SELECT 
                id_projeto,
                foto_antes_projeto,
                foto_depois_projeto,
                descricao_projeto,
                status_projeto,
                criado_em
            FROM tbl_projeto
            WHERE excluido_em IS NULL
            ORDER BY criado_em DESC
            LIMIT :limite';
    
    $statement = $this->db->prepare($sql);
    $statement->bindValue(':limite', $limite, PDO::PARAM_INT);
    $statement->execute();
    
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

    
    /**
     * Contar total de projetos
     */
    public function contarTotal()
    {
        $sql = 'SELECT COUNT(*) as total FROM tbl_projeto WHERE excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    }
    
    /**
     * Buscar projetos por mês do ano atual
     */
    public function contarProjetosPorMes()
    {
        $anoAtual = date('Y');
        
        $sql = 'SELECT 
                    MONTH(criado_em) as mes,
                    COUNT(*) as total
                FROM tbl_projeto
                WHERE excluido_em IS NULL
                AND YEAR(criado_em) = :ano
                GROUP BY MONTH(criado_em)
                ORDER BY mes ASC';
        
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':ano', $anoAtual, PDO::PARAM_INT);
        $statement->execute();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        // Inicializa array com 12 meses zerados
        $dados = array_fill(0, 12, 0);
        
        // Preenche com os dados reais
        foreach ($resultados as $row) {
            $mesIndex = (int)$row['mes'] - 1;
            $dados[$mesIndex] = (int)$row['total'];
        }
        
        return $dados;
    }

    // ==================== STATUS DO PROJETO ====================


    public function alterarStatusProjeto($id, $status)
        {
            $sql = 'UPDATE tbl_projeto SET status_projeto = :status WHERE id_projeto = :id AND excluido_em IS NULL';

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        public function ativarProjeto($id)
        {
            return $this->alterarStatusProjeto($id, 'Ativo');
        }

        public function desativarProjeto($id)
        {
            return $this->alterarStatusProjeto($id, 'Inativo');
        }


   

public function listarAtivosAntesDepois()
{
    $sql = "SELECT foto_antes_projeto, foto_depois_projeto 
            FROM tbl_projeto 
            WHERE status_projeto = 'Ativo' 
              AND excluido_em IS NULL
              AND foto_antes_projeto IS NOT NULL 
              AND foto_antes_projeto != ''
              AND foto_depois_projeto IS NOT NULL
              AND foto_depois_projeto != ''
            ORDER BY criado_em DESC";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}