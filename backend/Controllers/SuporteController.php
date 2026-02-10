<?php
namespace App\Impermax\Controllers;

use App\Impermax\Core\View;

class SuporteController
{
    public function index(): void
    {
        // Dados para a página de suporte
        $dadosSuporte = [
            'titulo' => 'Central de Suporte',
            'email' => 'suporte@impermax.com.br',
            'telefone' => '(11) 98765-4321',
            'horario' => 'Segunda a Sexta, 9h às 18h',
            'faqs' => [
                [
                    'pergunta' => 'Como faço para criar um novo agendamento?',
                    'resposta' => 'Para criar um novo agendamento, acesse o menu "Agendamentos" e clique no botão "Novo Agendamento". Preencha os dados do cliente e a data desejada.'
                ],
                [
                    'pergunta' => 'Como alterar minha senha?',
                    'resposta' => 'Acesse seu perfil clicando no seu nome no canto superior direito, depois clique em "Perfil" e em seguida "Alterar Senha".'
                ],
                [
                    'pergunta' => 'Como gerar relatórios?',
                    'resposta' => 'Os relatórios podem ser gerados nas páginas de listagem de cada módulo (Agendamentos, Orçamentos, etc). Utilize os filtros para selecionar o período desejado.'
                ],
                [
                    'pergunta' => 'Como adicionar um novo cliente?',
                    'resposta' => 'Acesse o menu "Usuários", clique em "Novo Usuário" e selecione o tipo "Cliente". Preencha os dados cadastrais e clique em "Salvar".'
                ],
                [
                    'pergunta' => 'O sistema funciona em dispositivos móveis?',
                    'resposta' => 'Sim! O sistema é totalmente responsivo e funciona perfeitamente em smartphones e tablets.'
                ]
            ]
        ];

        View::render('suporte/index', $dadosSuporte);
    }
}
