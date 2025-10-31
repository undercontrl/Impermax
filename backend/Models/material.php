<?php
namespace App\Impermax\Models;
use PDO;

class Material {
    private $id_material;
    private $nome_material;
    private $qtd_material;
    private $descricao_material;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $id_servico;
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    // ✅ LISTAR TODOS COM FILTROS E PAGINAÇÃO
    public function buscarMateriais($filtros = [], $limite = 10, $offset = 0) {
        $sql = 'SELECT m.*, s.nome_servico 
                FROM tbl_material m 
                LEFT JOIN tbl_servico s ON m.id_servico = s.id_servico 
                WHERE m.excluido_em IS NULL';
        
        $params = [];
        
        // Filtro de busca
        if (!empty($filtros['busca'])) {
            $sql .= ' AND (m.nome_material LIKE :busca OR m.descricao_material LIKE :busca)';
            $params[':busca'] = '%' . $filtros['busca'] . '%';
        }
        
        // Filtro por serviço
        if (!empty($filtros['servico'])) {
            $sql .= ' AND m.id_servico = :servico';
            $params[':servico'] = $filtros['servico'];
        }
        
        // Ordenação
        $ordem_campo = $filtros['ordem_campo'] ?? 'id_material';
        $ordem_direcao = $filtros['ordem_direcao'] ?? 'DESC';
        
        // Validar campos permitidos para ordenação
        $campos_permitidos = ['id_material', 'nome_material', 'qtd_material', 'nome_servico'];
        if (!in_array($ordem_campo, $campos_permitidos)) {
            $ordem_campo = 'id_material';
        }
        
        if (!in_array(strtoupper($ordem_direcao), ['ASC', 'DESC'])) {
            $ordem_direcao = 'DESC';
        }
        
        $sql .= " ORDER BY {$ordem_campo} {$ordem_direcao}";
        
        // Paginação
        $sql .= ' LIMIT :limite OFFSET :offset';
        
        $stmt = $this->db->prepare($sql);
        
        // Bind dos parâmetros
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ CONTAR TOTAL DE MATERIAIS (PARA PAGINAÇÃO)
    public function contarMateriais($filtros = []) {
        $sql = 'SELECT COUNT(*) as total 
                FROM tbl_material m 
                LEFT JOIN tbl_servico s ON m.id_servico = s.id_servico 
                WHERE m.excluido_em IS NULL';
        
        $params = [];
        
        if (!empty($filtros['busca'])) {
            $sql .= ' AND (m.nome_material LIKE :busca OR m.descricao_material LIKE :busca)';
            $params[':busca'] = '%' . $filtros['busca'] . '%';
        }
        
        if (!empty($filtros['servico'])) {
            $sql .= ' AND m.id_servico = :servico';
            $params[':servico'] = $filtros['servico'];
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    // ✅ BUSCAR 1 POR ID
    public function buscarMaterialPorID(int $id) {
        $sql = 'SELECT m.*, s.nome_servico 
                FROM tbl_material m 
                LEFT JOIN tbl_servico s ON m.id_servico = s.id_servico 
                WHERE m.id_material = :id AND m.excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ INSERIR
    public function inserirMaterial($nome_material, $qtd_material, $descricao_material, $id_servico) {
        $sql = 'INSERT INTO tbl_material (nome_material, qtd_material, descricao_material, id_servico) 
                VALUES (:nome_material, :qtd_material, :descricao_material, :id_servico)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome_material', $nome_material);
        $stmt->bindParam(':qtd_material', $qtd_material);
        $stmt->bindParam(':descricao_material', $descricao_material);
        $stmt->bindParam(':id_servico', $id_servico);
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // ✅ ATUALIZAR
    public function atualizarMaterial(int $id, $nome_material, $qtd_material, $descricao_material, $id_servico) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_material SET 
                nome_material = :nome_material,
                qtd_material = :qtd_material,
                descricao_material = :descricao_material,
                id_servico = :id_servico,
                atualizado_em = :atual 
                WHERE id_material = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome_material', $nome_material);
        $stmt->bindParam(':qtd_material', $qtd_material);
        $stmt->bindParam(':descricao_material', $descricao_material);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }

    // ✅ EXCLUIR (SOFT DELETE)
    public function excluirMaterial(int $id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_material SET excluido_em = :atual WHERE id_material = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }

    // ✅ EXCLUIR MÚLTIPLOS
    public function excluirMultiplos(array $ids) {
        if (empty($ids)) {
            return false;
        }

        $dataAtual = date('Y-m-d H:i:s');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "UPDATE tbl_material SET excluido_em = ? WHERE id_material IN ($placeholders)";
        
        $stmt = $this->db->prepare($sql);
        $params = array_merge([$dataAtual], $ids);
        
        return $stmt->execute($params);
    }

    // ✅ OBTER ESTATÍSTICAS
    public function obterEstatisticas() {
        $sql = "SELECT 
                COUNT(*) as total_materiais,
                SUM(qtd_material) as total_estoque,
                SUM(CASE WHEN qtd_material < 10 THEN 1 ELSE 0 END) as estoque_baixo,
                COUNT(DISTINCT id_servico) as servicos_vinculados
                FROM tbl_material 
                WHERE excluido_em IS NULL";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ BUSCAR SERVIÇOS ÚNICOS DOS MATERIAIS
    public function buscarServicosUnicos() {
        $sql = "SELECT DISTINCT s.id_servico, s.nome_servico
                FROM tbl_material m
                INNER JOIN tbl_servico s ON m.id_servico = s.id_servico
                WHERE m.excluido_em IS NULL AND s.excluido_em IS NULL
                ORDER BY s.nome_servico ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}