<?php
namespace App\Impermax\Models;
use PDO;
class endereco{
    private $id_endereco;
    private $id_usuario;
    private $cep_endereco;
    private $logadouro_endereco;
    private $numero_endereco;
    private $complemento_endereco;
    private $bairro_endereco;
    private $cidade_endereco;
    private $uf_endereco;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // O construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
    //método de buscar todos os enderecos não excluídos
    function buscarEnderecos(){
        $sql = 'SELECT * FROM tbl_endereco WHERE excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os enderecos por cep
    function buscarEnderecoPorCEP($cep_endereco){
        $sql = 'SELECT * FROM tbl_endereco WHERE cep_endereco = :cep_endereco AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':cep_endereco', $cep_endereco);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os enderecos por logadouro
    function buscarEnderecoPorLogadouro($logadouro_endereco){
        $sql = 'SELECT * FROM tbl_agendamento WHERE logadouro_endereco = :logadouro_endereco AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':logadouro_endereco', $logadouro_endereco);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os enderecos por bairro
    function buscarEnderecoPorBairro($bairro_endereco){
        $sql = 'SELECT * FROM tbl_agendamento WHERE bairro_endereco = :bairro_endereco AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':bairro_endereco', $bairro_endereco);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os enderecos por cidade
    function buscarEnderecoPorCidade($cidade_endereco){
        $sql = 'SELECT * FROM tbl_agendamento WHERE cidade_endereco = :cidade_endereco AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':cidade_endereco', $cidade_endereco);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os enderecos por usuário
    function buscarEnderecoPorUsuario($id_usuario){
        $sql = 'SELECT * FROM tbl_agendamento WHERE id_usuario = :id_usuario AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_usuario', $id_usuario);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar endereco por id
    function buscarEnderecoPorId($id_endereco){
        $sql = 'SELECT * FROM tbl_endereco WHERE id_endereco = :id AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id_endereco);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    //método de inserir endereco
    function inserirEndereco($id_usuario, $cep_endereco, $logadouro_endereco, $numero_endereco, $complemento_endereco, $bairro_endereco, $cidade_endereco, $uf_endereco){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_endereco (id_usuario, cep_endereco, logadouro_endereco, numero_endereco, complemento_endereco, bairro_endereco, cidade_endereco, uf_endereco, criado_em) 
                VALUES (:id_usuario, :cep_endereco, :logadouro_endereco, :numero_endereco, :complemento_endereco, :bairro_endereco, :cidade_endereco, :uf_endereco, :criado_em)';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_usuario', $id_usuario);
        $statement->bindParam(':cep_endereco', $cep_endereco);
        $statement->bindParam(':logadouro_endereco', $logadouro_endereco);
        $statement->bindParam(':numero_endereco', $numero_endereco);
        $statement->bindParam(':complemento_endereco', $complemento_endereco);
        $statement->bindParam(':bairro_endereco', $bairro_endereco);
        $statement->bindParam(':cidade_endereco', $cidade_endereco);
        $statement->bindParam(':uf_endereco', $uf_endereco);
        $statement->bindParam(':criado_em', $dataAtual);
        if($statement->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    //método de atualizar o endereco
    function atualizarEndereco($id_endereco, $cep_endereco, $logadouro_endereco, $numero_endereco, $complemento_endereco, $bairro_endereco, $cidade_endereco, $uf_endereco){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_endereco 
                SET cep_endereco = :cep_endereco, 
                    logadouro_endereco = :logadouro_endereco, 
                    numero_endereco = :numero_endereco, 
                    complemento_endereco = :complemento_endereco, 
                    bairro_endereco = :bairro_endereco, 
                    cidade_endereco = :cidade_endereco, 
                    uf_endereco = :uf_endereco, 
                    atualizado_em = :atualizado_em 
                WHERE id_endereco = :id_endereco AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_endereco', $id_endereco);
        $statement->bindParam(':cep_endereco', $cep_endereco);
        $statement->bindParam(':logadouro_endereco', $logadouro_endereco);
        $statement->bindParam(':numero_endereco', $numero_endereco);
        $statement->bindParam(':complemento_endereco', $complemento_endereco);
        $statement->bindParam(':bairro_endereco', $bairro_endereco);
        $statement->bindParam(':cidade_endereco', $cidade_endereco);
        $statement->bindParam(':uf_endereco', $uf_endereco);
        $statement->bindParam(':atualizado_em', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de deletar o endereco
    function excluirEndereco($id_endereco){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_endereco SET excluido_em = :excluido WHERE id_endereco = :id_endereco';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_endereco', $id_endereco);
        $statement->bindParam(':excluido', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
}