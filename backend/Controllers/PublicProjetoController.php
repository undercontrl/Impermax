<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Projeto;
use App\Impermax\Database\Database;

class PublicProjetoController
{
    private $projetoModel;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->projetoModel = new Projeto($db);
    }

    public function getProjetos()
    {
        // Busca apenas projetos com fotos antes/depois preenchidas
        $projetos = $this->projetoModel->listarAtivosAntesDepois();

        // Montar URLs corretas (raiz do site)
        foreach ($projetos as &$p) {
            $p['antes'] = '/upload/' . $p['foto_antes_projeto'];
            $p['depois'] = '/upload/' . $p['foto_depois_projeto'];
            unset($p['foto_antes_projeto'], $p['foto_depois_projeto']);
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
