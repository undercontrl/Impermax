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
    //construtor inicializa a classe e ou atributos 
    public function __construct($db){
        $this->db = $db;
      
    }
    // metodo de buscar todos os materiais
    function buscarMateriais(){
        $sql = 'SELECT * FROM tbl_material where excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //metodo de buscar todos materiais por nome
    function buscarMateriaisPorNome($nome_material){
        $sql = 'SELECT * FROM tbl_material where nome_material = :nome_material and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome_material', $nome_material);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarMateriaisIdServico($id_servico){
        $sql = 'SELECT * FROM tbl_material where id_servico = :id_servico and excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // metodo de inserir materiais
    function inserirMaterial($nome_material, $qtd_material, $descricao_material, $id_servico){
        $sql = 'INSERT INTO tbl_material (nome_material, qtd_material, descricao_material, id_servico)
             VALUES (:nome_material, :qtd_material, :descricao_material, :id_servico)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome_material', $nome_material);
        $stmt->bindParam(':qtd_material', $qtd_material);
        $stmt->bindParam(':descricao_material', $descricao_material);
        $stmt->bindParam(':id_servico', $id_servico);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o Material
    function atualizarMateriais($nome_material, $qtd_material, $descricao_material, $id_servico){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_material SET nome_material = :nome_material,
        qtd_material = :qtd_material,
        descricao_material = :descricao_material,
        id_servico = :id_servico,
        atualizado_em = :atual
        Where id_material = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome_material', $nome_material);
        $stmt->bindParam(':qtd_material', $qtd_material);
        $stmt->bindParam(':descricao_material', $descricao_material);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de deletar o material
    function excluirMateriais($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_material SET 
        excluido_em = :atual
        Where id_material = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}