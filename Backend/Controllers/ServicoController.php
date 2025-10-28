<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Servico;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ServicoValidador;
use App\Impermax\Core\FileManager;
use App\Impermax\Controllers\Admin\AuthenticatedController;
use App\Impermax\Controllers\Admin\AdminController;

class ServicoController extends AdminController{
    private $servico;
    private $gerenciarImagem;

    public function __construct() {
        parent::__construct();
        $db = Database::getInstance();
        $this->servico = new Servico($db);
        $this->gerenciarImagem = new FileManager('upload');
    }

        public function index() {
        $this->viewListarServicos();
    }

    // Listar serviços
    public function viewListarServicos($pagina = 1) {
        if (empty($pagina) || $pagina <= 0) $pagina = 1;
        
        $dados = $this->servico->paginacao($pagina, 50);
        
        View::render("servico/index", [
            "servicos" => $dados['data'],
            'paginacao' => $dados
        ]);
    }

    // Exibir formulário de criação
    public function viewCriarServicos()
    {
        View::render("servico/create");
    }

    // Salvar novo serviço
    public function salvarServico()
    {
        $erros = ServicoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("servico/criar", "error", implode("<br>", $erros));
        }

        $foto_servico = $this->gerenciarImagem->salvarArquivo($_FILES['foto_servico'], 'servicos');

        $sucesso = $this->servico->inserirServico(
            $_POST["nome_servico"],
            $_POST["descricao_servico"],
            $_POST["valor_base_servico"],
            $foto_servico,
            "Ativo"
        );

        if ($sucesso) {
            Redirect::redirecionarComMensagem("servico/listar", "success", "Serviço cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("servico/criar", "error", "Erro ao cadastrar serviço!");
        }
    }

    // Exibir formulário de edição
    public function viewEditarServicos($id = null)
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "ID do serviço não fornecido.");
        }

        $servico = $this->servico->buscarServicoPorID($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
        }

        View::render("servico/edit", ["servico" => $servico]);
    }

    // Atualizar serviço
    public function atualizarServico($id)
    {
        $erros = ServicoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("servico/editar/$id", "error", implode("<br>", $erros));
        }

        $foto_servico = !empty($_FILES['foto_servico']['name'])
            ? $this->gerenciarImagem->salvarArquivo($_FILES['foto_servico'], 'servicos')
            : $_POST['foto_servico_atual'];

        $sucesso = $this->servico->atualizaServico(
            $id,
            $_POST["nome_servico"],
            $_POST["descricao_servico"],
            $_POST["valor_base_servico"],
            $foto_servico,
            $_POST["status_servico"]
        );

        if ($sucesso) {
            Redirect::redirecionarComMensagem("servico/listar", "success", "Serviço atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("servico/editar/$id", "error", "Erro ao atualizar o serviço!");
        }
    }

    // Exibir confirmação de exclusão
    public function viewExcluirServicos($id)
    {
        $servico = $this->servico->buscarServicoPorID($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
        }

        View::render("servico/delete", ["servico" => $servico]);
    }

    // Executar exclusão
public function deletarServico($id)
{
    $id = (int) ($id ?: $_POST['id_servico'] ?? 0); // Usa URL ou POST para flexibilidade
    if ($id <= 0) {
        Redirect::redirecionarComMensagem("servico/listar", "error", "ID inválido.");
    }

    $servico = $this->servico->buscarServicoPorID($id);
    if (!$servico) {
        Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
    }

    $acao = ($servico['status_servico'] === 'Ativo') ? 'inativado' : 'ativado';
    if ($this->servico->deletarServico($id)) {
        Redirect::redirecionarComMensagem("servico/listar", "success", "Serviço $acao com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("servico/listar", "error", "Erro ao alterar status do serviço.");
    }
}
}
