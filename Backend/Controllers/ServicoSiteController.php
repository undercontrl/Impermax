<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\ServicoSite;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ServicoSiteValidador;
use App\Impermax\Controllers\Admin\AuthenticatedController;
use App\Impermax\Controllers\Admin\AdminController;

class ServicoSiteController extends AdminController {
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new ServicoSite(Database::getInstance());
    }

    public function index() {
        $this->listar(1);
    }

    public function listar($pagina = 1) {
        $dados = $this->model->listarTodos($pagina, 10);
        View::render("servico-site/index", [
            'servicos' => $dados['data'],
            'paginacao' => $dados
        ]);
    }

    public function criar() {
        View::render("servico-site/create");
    }

    public function editar($id) {
        $servico = $this->model->buscarPorId($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "Não encontrado.");
        }
        View::render("servico-site/edit", ['servico' => $servico]);
    }

    public function alternar($id) {
        if ($this->model->alternarStatus($id)) {
            Redirect::redirecionarComMensagem("servico-site/listar", "success", "Status alterado!");
        } else {
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "Erro ao alterar.");
        }
    }

    public function salvar() {
        $erros = ServicoSiteValidador::validar($_POST, $_FILES);
        if ($erros) {
            return Redirect::redirecionarComMensagem("servico-site/criar", "error", implode("<br>", $erros));
        }

        $foto = $this->fileManager->salvarArquivo($_FILES['foto_servico'], 'servicos');

        $sucesso = $this->model->inserir(
            $_POST['nome_servico'],
            $_POST['descricao_servico'],
            $foto,
            'Inativo'
        );

        $msg = $sucesso ? "Criado com sucesso!" : "Erro ao criar.";
        Redirect::redirecionarComMensagem("servico-site/listar", $sucesso ? "success" : "error", $msg);
    }

    public function atualizar($id) {
        $erros = ServicoSiteValidador::validar($_POST, $_FILES, true);
        if ($erros) {
            return Redirect::redirecionarComMensagem("servico-site/editar/$id", "error", implode("<br>", $erros));
        }

        $foto = !empty($_FILES['foto_servico']['name'])
            ? $this->fileManager->salvarArquivo($_FILES['foto_servico'], 'servicos')
            : $_POST['foto_servico_atual'];

        $sucesso = $this->model->atualizar(
            $id,
            $_POST['nome_servico'],
            $_POST['descricao_servico'],
            $foto,
            $_POST['status_servico']
        );

        $msg = $sucesso ? "Atualizado!" : "Erro.";
        Redirect::redirecionarComMensagem("servico-site/listar", $sucesso ? "success" : "error", $msg);
    }
}
