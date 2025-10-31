<?php
namespace App\Impermax\Controllers;

use App\Impermax\Controllers\Admin\AdminController;
use App\Impermax\Models\Contato;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;

class ContatoController extends AdminController
{
    private $contato;
    private $usuario;
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->contato = new Contato($this->db);
        $this->usuario = new Usuario($this->db);
    }

    public function viewListarContatos()
    {
        $busca = $_GET['busca'] ?? '';
        $status = $_GET['status'] ?? '';
        $periodo = $_GET['periodo'] ?? '';
        $ordemCampo = $_GET['ordem_campo'] ?? 'data_envio';
        $ordemDirecao = $_GET['ordem_direcao'] ?? 'DESC';
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $itensPorPagina = 10;
        $offset = ($paginaAtual - 1) * $itensPorPagina;

        $contatos = $this->contato->buscarContatosFiltrados(
            $busca, $status, $periodo, $ordemCampo, $ordemDirecao, $itensPorPagina, $offset
        );

        $totalRegistros = $this->contato->contarContatosFiltrados($busca, $status, $periodo);
        $totalPaginas = ceil($totalRegistros / $itensPorPagina);

        $paginacao = [
            'pagina_atual' => $paginaAtual,
            'total_paginas' => $totalPaginas,
            'total' => $totalRegistros,
            'inicio' => $offset + 1,
            'fim' => min($offset + $itensPorPagina, $totalRegistros)
        ];

        $stats = $this->contato->getStats();
        View::render("contato/index", [
            "contatos" => $contatos,
            "paginacao" => $paginacao,
            "stats" => $stats  // ← IMPORTANTE
]);
    }

    public function converterEmCliente($id)
    {
        $contato = $this->contato->buscarPorId($id);
        if (!$contato) {
            Redirect::redirecionarComMensagem("contato", "error", "Contato não encontrado.");
            return;
        }

        if ($this->usuario->emailJaExiste($contato['email_contato'])) {
            Redirect::redirecionarComMensagem("contato", "warning", "Cliente já existe com este e-mail.");
            return;
        }

        $sucesso = $this->usuario->criarCliente([
            'nome' => $contato['nome_contato'],
            'email' => $contato['email_contato']
        ]);
    if ($sucesso) {
        // REDIRECIONA PARA USUÁRIOS COM MENSAGEM
        Redirect::redirecionarComMensagem("usuarios", "success", "Cliente '{$contato['nome_contato']}' criado com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("contato", "error", "Erro ao criar cliente.");
    }
}








    public function viewEditar($id)
{
    $contato = $this->contato->buscarPorId($id);
    if (!$contato) {
        $_SESSION['erro'] = "Contato não encontrado.";
        header("Location: /backend/contato");
        exit;
    }

    View::render("contato/edit", [
        "contato" => $contato
    ]);
}

public function atualizar($id)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /backend/contato");
        exit;
    }

    $dados = [
        'nome_contato' => trim($_POST['nome_contato']),
        'email_contato' => trim($_POST['email_contato']),
        'telefone_contato' => preg_replace('/\D/', '', $_POST['telefone_contato'] ?? ''),
        'assunto_contato' => trim($_POST['assunto_contato']),
        'mensagem_contato' => trim($_POST['mensagem_contato'] ?? ''),
        'status_contato' => $_POST['status_contato']
    ];

    if ($this->contato->atualizar($id, $dados)) {
        $_SESSION['sucesso'] = "Contato atualizado com sucesso!";
    } else {
        $_SESSION['erro'] = "Erro ao atualizar contato.";
    }

    header("Location: /backend/contato");
    exit;
}



    // Confirmação de exclusão

  public function viewExcluirContato($id)
{
    $contato = $this->contato->buscarContatoPorId($id);

    // VALIDAÇÃO MAIS CLARA
    if (!$contato) {
        $_SESSION['erro'] = "Contato não encontrado ou já foi excluído.";
        header("Location: /backend/contato");
        exit;
    }

    // Verifica se já está inativo (soft delete)
    if ($contato['status_contato'] === 'inativo') {
        $_SESSION['erro'] = "Este contato já foi inativado anteriormente.";
        header("Location: /backend/contato");
        exit;
    }

    View::render("contato/delete", [
        "contato" => $contato
    ]);
}

public function excluirContatoConfirmado($id)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['erro'] = "Método inválido.";
        header("Location: /backend/contato");
        exit;
    }

    if ($this->contato->excluirContato($id)) {
        $_SESSION['sucesso'] = "Contato cancelado com sucesso!";
    } else {
        $_SESSION['erro'] = "Erro ao cancelar o contato.";
    }

    header("Location: /backend/contato");
    exit;
}


    public function deletarMultiplos()
    {
        header('Content-Type: application/json');
        
        $ids = $_POST['ids'] ?? [];
        
        if (empty($ids)) {
            echo json_encode(['success' => false, 'message' => 'Nenhum agendamento selecionado']);
            exit;
        }
        
        $sucesso = 0;
        foreach ($ids as $id) {
            if ($this->contato->excluirContato($id)) {
                $sucesso++;
            }
        }
        
        if ($sucesso > 0) {
            echo json_encode([
                'success' => true, 
                'message' => "$sucesso contato(s) excluído(s) com sucesso!"
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Erro ao excluir contatos'
            ]);
        }
        exit;
    }


    public function viewCriar()
{
    View::render("contato/create");
}

public function salvar()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['erro'] = "Método inválido.";
        header("Location: /backend/contato");
        exit;
    }

    $dados = [
        'nome_contato' => trim($_POST['nome_contato'] ?? ''),
        'email_contato' => trim($_POST['email_contato'] ?? ''),
        'telefone_contato' => preg_replace('/\D/', '', $_POST['telefone_contato'] ?? ''),
        'assunto_contato' => trim($_POST['assunto_contato'] ?? ''),
        'status_contato' => 'novo',
        'data_envio' => date('Y-m-d H:i:s')
    ];

    // Validação básica
    if (empty($dados['nome_contato']) || empty($dados['email_contato']) || empty($dados['assunto_contato'])) {
        $_SESSION['erro'] = "Preencha todos os campos obrigatórios.";
        header("Location: /backend/contato/criar");
        exit;
    }

    if (!filter_var($dados['email_contato'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['erro'] = "E-mail inválido.";
        header("Location: /backend/contato/criar");
        exit;
    }

    if ($this->contato->criar($dados)) {
        $_SESSION['sucesso'] = "Contato criado com sucesso!";
        header("Location: /backend/contato");
    } else {
        $_SESSION['erro'] = "Erro ao salvar contato.";
        header("Location: /backend/contato/criar");
    }
    exit;
}
}