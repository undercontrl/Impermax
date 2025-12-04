<?php
namespace App\impermax\Core;


class ValidaToken{
    private $chaveAPI;

    public function __construct() {
        $this->chaveAPI = "DDCD52416070FBE28CDB1EB00FA806F54729B060621B3CFE8A4AE8B6B283EF6A";
    }
private function buscaChaveAPI(){
        $headers = getallheaders();
        $token = explode(" ", $headers['Authorization'])[1];
        return $token === $this->chaveAPI;
    }

    public function ValidaToken(){
        if (!$this->buscaChaveAPI()) {
             http_response_code(500);
            echo json_encode([
                'staus' => 'error', 'message' => 'Chave de API inválida.'
            ]);
            exit;
        } 
    }

}