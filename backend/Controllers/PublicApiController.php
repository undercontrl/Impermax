<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\ServicoSite;
use App\Impermax\Database\Database;
use App\Impermax\Models\Avaliacao;

class PublicApiController
{
    private $servicoModel;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->servicoModel = new ServicoSite($db);
    }

    public function getServicos()
    {
        $model = $this->servicoModel;
        
        // Usa o método que já filtra por 'Ativo'
        $dados = $model->listarAtivos();
        
        // CORREÇÃO: Caminho correto sem /backend/
        foreach($dados as &$s) {
            $s['caminho_imagem'] = '/upload/' . $s['foto_servico'];
        }
        unset($s);
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Retorna avaliações aprovadas em JSON para o site público
     */
    public function getAvaliacoes()
    {
        header('Content-Type: application/json; charset=utf-8');
        
        try {
            $db = Database::getInstance();
            $avaliacaoModel = new Avaliacao($db);
            
            // Buscar apenas avaliações aprovadas
            $avaliacoes = $avaliacaoModel->buscarAvaliacoesAprovadas(20);
            
            if (empty($avaliacoes)) {
                echo json_encode([
                    'status' => 'success',
                    'data' => [],
                    'message' => 'Nenhuma avaliação disponível'
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                exit;
            }
            
            echo json_encode([
                'status' => 'success',
                'data' => $avaliacoes,
                'total' => count($avaliacoes)
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao buscar avaliações'
            ], JSON_UNESCAPED_UNICODE);
        }
        
        exit;
    }
}