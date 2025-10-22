<?php
class contato{
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
    // O construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
    //método de buscar todos os contatos não excluídos
    function buscarContatos(){
        $sql = 'SELECT * FROM tbl_contato WHERE excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os contatos excluídos
    function buscarContatosExcluidos(){
        $sql = 'SELECT * FROM tbl_contato WHERE excluido_em = NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os contatos por email
    function buscarContatosPorEmail($email){
        $sql = 'SELECT * FROM tbl_contato where email_contato = :email AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os contatos por status
    function buscarContatosPorStatus($status_contato){
        $sql = 'SELECT * FROM tbl_contato WHERE status_contato = :status_contato AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':status_contato', $status_contato);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os contatos por data de envio de mensagem
    function buscarContatosPorData($data_envio){
        $sql = 'SELECT * FROM tbl_contato WHERE data_envio = :data_envio AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':data_envio', $data_envio);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os contatos por nome
    function buscarContatosPorCliente($nome_contato){
        $sql = 'SELECT * FROM tbl_agendamento WHERE nome_contato = :nome_contato AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':nome_contato', $nome_contato);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar contato por id
    function buscarContatoPorId($id){
        $sql = 'SELECT * FROM tbl_contato WHERE id_contato = :id AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    //método de inserir um novo contato
    function inserirContato($nome_contato, $telefone_contato, $email_contato, $assunto_contato, $status_contato, $data_envio){
        $dataAtual = date('Y-m-d H:i:s');
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
        if($statement->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    //método de atualizar o contato
    function atualizarContato($nome_contato, $telefone_contato, $email_contato, $assunto_contato, $status_contato, $data_envio){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_contato SET nome_contato = :nome_contato, telefone_contato = :telefone_contato, 
        email_contato = :email_contato, assunto_contato = :assunto_contato, status_contato = :status_contato, atualizado_em = :atualizado_em 
        WHERE id_contato = :id_contato';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':nome_contato', $nome_contato);
        $statement->bindParam(':telefone_contato', $telefone_contato);
        $statement->bindParam(':email_contato', $email_contato);
        $statement->bindParam(':assunto_contato', $assunto_contato);
        $statement->bindParam(':status_contato', $status_contato);
        $statement->bindParam(':atualizado_em', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de excluir contato
    function excluirContato($id_contato){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_contato SET excluido_em = :excluido WHERE id_contato = :id_contato';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_contato', $id_contato);
        $statement->bindParam(':excluido', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
}