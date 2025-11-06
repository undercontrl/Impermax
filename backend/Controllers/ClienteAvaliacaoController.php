<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Avaliacao;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Core\Session;

/**
 * Controller para clientes autenticados cadastrarem avaliações
 */
class ClienteAvaliacaoController
{
    private $avaliacao;
    private $db;
    private $session;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->avaliacao = new Avaliacao($this->db);
        $this->session = new Session();
        
        // Verificar se o usuário está logado e é do tipo "Cliente"
        $this->verificarAcessoCliente();
    }

    /**
     * Verifica se usuário está logado e é do tipo Cliente
     */
    private function verificarAcessoCliente()
    {
        if (!$this->session->get('usuario_id')) {
            Redirect::redirecionarComMensagem('login', 'error', 'Faça login para enviar sua avaliação!');
            exit;
        }
        
        $tipoUsuario = strtolower($this->session->get('usuario_tipo') ?? '');
        
        if ($tipoUsuario !== 'cliente') {
            Redirect::redirecionarComMensagem('login', 'error', 'Acesso restrito a clientes!');
            exit;
        }
    }

    /**
     * Exibe formulário de avaliação para cliente logado
     */
    public function index()
    {
        $idCliente = $this->session->get('usuario_id');
        $nomeCliente = $this->session->get('usuario_nome');
        
        // Buscar avaliações anteriores do cliente
        $avaliacoesAnteriores = $this->avaliacao->buscarAvaliacoesPorClienteAtivo($idCliente);
        
        View::render('cliente/avaliacao', [
            'nome_cliente' => $nomeCliente,
            'avaliacoes_anteriores' => $avaliacoesAnteriores
        ]);
    }

    /**
     * Salva avaliação do cliente
     */
    public function salvarAvaliacao()
    {
        $idCliente = $this->session->get('usuario_id');
        
        // Validações
        $erros = $this->validarDados($_POST);
        
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem('cliente/avaliacao', 'error', implode('<br>', $erros));
            return;
        }
        
        $nota = (int)$_POST['nota_avaliacao'];
        $descricao = trim($_POST['descricao_avaliacao']);
        
        // Inserir com status "Pendente"
        $sucesso = $this->avaliacao->inserirAvaliacao(
            $idCliente,
            $descricao,
            $nota,
            'Pendente'
        );
        
        if ($sucesso) {
            Redirect::redirecionarComMensagem(
                'cliente/avaliacao', 
                'success', 
                'Avaliação enviada com sucesso! Será analisada em breve.'
            );
        } else {
            Redirect::redirecionarComMensagem(
                'cliente/avaliacao', 
                'error', 
                'Erro ao enviar avaliação. Tente novamente!'
            );
        }
    }

    /**
     * Valida dados do formulário
     */
    private function validarDados($dados)
    {
        $erros = [];
        
        // Validar nota
        $nota = (int)($dados['nota_avaliacao'] ?? 0);
        if ($nota < 1 || $nota > 5) {
            $erros[] = 'Selecione uma nota de 1 a 5 estrelas';
        }
        
        // Validar descrição
        $descricao = trim($dados['descricao_avaliacao'] ?? '');
        if (empty($descricao)) {
            $erros[] = 'O comentário é obrigatório';
        } elseif (strlen($descricao) < 20) {
            $erros[] = 'O comentário deve ter no mínimo 20 caracteres';
        } elseif (strlen($descricao) > 500) {
            $erros[] = 'O comentário não pode ter mais de 500 caracteres';
        }
        
        return $erros;
    }
}