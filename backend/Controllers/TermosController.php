<?php
namespace App\Impermax\Controllers;

use App\Impermax\Core\View;

class TermosController
{
    public function index(): void
    {
        // Dados para a página de termos
        $dadosTermos = [
            'titulo' => 'Termos de Uso',
            'empresa' => 'Impermax',
            'dataAtualizacao' => '06 de Fevereiro de 2026',
            'email' => 'contato@impermax.com.br'
        ];

        View::render('termos/index', $dadosTermos);
    }
}
