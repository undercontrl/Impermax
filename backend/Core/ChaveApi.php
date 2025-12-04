<?php
namespace App\Impermax\Core;

class ChaveApi{
    private string $chaveAPI;
    public function __construct(){
        $this->chaveAPI = "E9768D4706F9FF10385A01F911CBA67EDA01ED1FEDE37DDF46B40FC39A9F789B";
    }

    private function buscaChaveAPI(){
        $headers = getallheaders();
        if(!isset($headers["Authorization"])){
            return false;
        }
        $token = explode(' ', $headers['Authorization'] ?? '')[1] ?? null;
        return $token === $this->chaveAPI;
    }

    public function validarChave(){
        if(!$this->buscaChaveAPI()){
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Acesso não autorizado. Chave API inválida.'
            ]);
            exit;
        }
    }
}