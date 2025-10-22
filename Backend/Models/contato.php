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

    function buscarContatoPorId($id){
        $sql = 'SELECT * FROM tbl_contato WHERE id_contato = :id AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
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

    function atualizarContato($id_contato, $nome_contato, $telefone_contato, $email_contato, $assunto_contato, $status_contato, $data_envio){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_contato 
                SET nome_contato = :nome_contato, 
                    telefone_contato = :telefone_contato, 
                    email_contato = :email_contato, 
                    assunto_contato = :assunto_contato, 
                    status_contato = :status_contato, 
                    data_envio = :data_envio,
                    atualizado_em = :atualizado_em 
                WHERE id_contato = :id_contato';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_contato', $id_contato);
        $statement->bindParam(':nome_contato', $nome_contato);
        $statement->bindParam(':telefone_contato', $telefone_contato);
        $statement->bindParam(':email_contato', $email_contato);
        $statement->bindParam(':assunto_contato', $assunto_contato);
        $statement->bindParam(':status_contato', $status_contato);
        $statement->bindParam(':data_envio', $data_envio);
        $statement->bindParam(':atualizado_em', $dataAtual);
        return $statement->execute();
    }

    function excluirContato($id_contato){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_contato SET excluido_em = :excluido WHERE id_contato = :id_contato';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_contato', $id_contato);
        $statement->bindParam(':excluido', $dataAtual);
        return $statement->execute();
    }
}
