<?php
namespace App\Impermax\Models;
use PDO;
class Material{
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

    // ✅ LISTAR TODOS (COM JOIN SERVIÇO)
    public function buscarMateriais() {
        $sql = 'SELECT m.*, s.nome_servico 
                FROM tbl_material m 
                LEFT JOIN tbl_servico s ON m.id_servico = s.id_servico 
                WHERE m.excluido_em IS NULL 
                ORDER BY m.id_material DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    // ✅ ATUALIZAR (ERRO NO WHERE CORRIGIDO)
    public function atualizarMaterial(int $id, $nome_material, $qtd_material, $descricao_material, $id_servico) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_material SET 
                nome_material = :nome_material,
                qtd_material = :qtd_material,
                descricao_material = :descricao_material,
                id_servico = :id_servico,
                atualizado_em = :atual 
                WHERE id_material = :id";  // ✅ WHERE CORRIGIDO
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);  // ✅ ID ADICIONADO
        $stmt->bindParam(':nome_material', $nome_material);
        $stmt->bindParam(':qtd_material', $qtd_material);
        $stmt->bindParam(':descricao_material', $descricao_material);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }

    // ✅ EXCLUIR
    public function excluirMaterial(int $id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_material SET excluido_em = :atual WHERE id_material = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }
}