<?php
namespace App\Impermax\Controllers;

class TesteController
{
    public function salvar()
    {
        // TENTA INSERIR DIRETO NO BANCO
        $db = \App\Impermax\Database\Database::getInstance();
        $sql = "INSERT INTO tbl_contato 
                (nome_contato, telefone_contato, email_contato, assunto_contato, status_contato)
                VALUES ('Teste', '11999999999', 'teste@email.com', 'Teste automático', 'Novo')";
        
        $stmt = $db->prepare($sql);
        $resultado = $stmt->execute();

        echo $resultado ? "SALVOU! ID: " . $db->lastInsertId() : "FALHOU!";
        exit;
    }
}