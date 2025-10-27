<?php
namespace App\Impermax\Models;
use PDO;
class Servico{
    private $id_servico;
    private $nome_servico;
    private $descricao_servico;
    private $valor_base_servico;
    private $foto_servico;
    private $status_servico;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    //construtor inicializa a classe e ou atributos 
     public function __construct($db)
    {
        $this->db = $db;
    }

    // Buscar todos os serviços ativos
    public function buscarServicos()
    {
        $sql = "SELECT * FROM tbl_servico WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar um serviço por ID
    public function buscarServicoPorID(int $id)
    {
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar por nome
    public function buscarServicosPorNome($nome)
    {
        $sql = "SELECT * FROM tbl_servico WHERE nome_servico LIKE :nome AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $nome = "%{$nome}%";
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //buscar servicos ativos para API pública

     public function buscarServicosAtivos(){
        $sql = "SELECT nome_servico, descricao_servico, foto_servico 
                FROM tbl_servico 
                WHERE status_servico = 'ativo' 
                ORDER BY criado_em DESC LIMIT 4";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserir novo serviço
    public function inserirServico($nome, $descricao, $valor, $foto_servico, $status)
    {
        $sql = "INSERT INTO tbl_servico (nome_servico, descricao_servico, valor_base_servico, foto_servico, status_servico)
                VALUES (:nome, :descricao, :valor, :foto, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':foto', $foto_servico);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    // Atualizar serviço existente
    public function atualizaServico($id, $nome, $descricao, $valor, $foto_servico, $status)
    {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_servico 
                SET nome_servico = :nome,
                    descricao_servico = :descricao,
                    valor_base_servico = :valor,
                    foto_servico = :foto,
                    status_servico = :status,
                    atualizado_em = :atualizado
                WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':foto', $foto_servico);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atualizado', $dataAtual);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Marcar serviço como excluído
    public function deletarServico($id)
    {
        $status = $this->buscarServicoPorID($id);
        $status = $status['status_servico'] == 'ativo' ? 'Inativo' : 'ativo';

        $sql = "UPDATE tbl_servico SET status_servico = :status WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }
}