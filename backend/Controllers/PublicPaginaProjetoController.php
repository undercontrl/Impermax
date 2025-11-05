<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\PaginaProjeto;
use App\Impermax\Database\Database;

class PublicPaginaProjetoController
{
    private $model;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->model = new PaginaProjeto($db);
    }

    /**
     * Retorna projetos ativos para exibição no site
     */
    public function getProjetos()
    {
        $projetos = $this->model->listarAtivos();

        // Montar URLs corretas
        foreach ($projetos as &$p) {
            $p['imagem_url'] = '/upload/' . $p['imagem_projeto'];
            unset($p['imagem_projeto']); // Remove o campo original
        }
        unset($p);

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $projetos
        ], JSON_UNESCAPED_SLASHES);
        exit;
    }
}