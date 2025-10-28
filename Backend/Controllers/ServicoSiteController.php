<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Servico;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Core\FileManager;
use App\Impermax\Controllers\Admin\AuthenticatedController;

class ServicoSiteController extends AuthenticatedController {
    private $model;
    private $fileManager;

    public function __construct() {
        parent::__construct();
        $db = Database::getInstance();
        $this->model = new Servico($db);
        $this->fileManager = new FileManager('upload');
    }

    public function index() {
        $this->listar(1);
    }

    public function listar($pagina = 1) {
        $dados = $this->model->listarParaSite($pagina, 10);
        View::render("servico-site/index", [
            'servicos' => $dados['data'],
            'paginacao' => $dados
        ]);
    }

    public function editar($id) {
        $servico = $this->model->buscarServicoPorID($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "Serviço não encontrado.");
        }
        View::render("servico-site/edit", ['servico' => $servico]);
    }

    public function atualizar($id) {
        $erros = \App\Impermax\Validadores\ServicoValidador::ValidarEntradas($_POST);
        if ($erros) {
            Redirect::redirecionarComMensagem("servico-site/editar/$id", "error", implode("<br>", $erros));
        }

        $foto = !empty($_FILES['foto_servico']['name'])
            ? $this->fileManager->salvarArquivo($_FILES['foto_servico'], 'servicos')
            : $_POST['foto_servico_atual'];

        $sucesso = $this->model->atualizaServico(
            $id,
            $_POST['nome_servico'],
            $_POST['descricao_servico'],
            $_POST['valor_base_servico'] ?? 0,
            $foto,
            $_POST['status_servico']
        );

        $msg = $sucesso ? "Atualizado com sucesso!" : "Erro ao atualizar.";
        $tipo = $sucesso ? "success" : "error";
        Redirect::redirecionarComMensagem("servico-site/listar", $tipo, $msg);
    }

    public function alternarStatus($id) {
        $servico = $this->model->buscarServicoPorID($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "Não encontrado.");
        }

        $novoStatus = $servico['status_servico'] === 'Ativo' ? 'Inativo' : 'Ativo';
        $sucesso = $this->model->atualizaServico(
            $id,
            $servico['nome_servico'],
            $servico['descricao_servico'],
            $servico['valor_base_servico'],
            $servico['foto_servico'],
            $novoStatus
        );

        $msg = $sucesso ? "Status alterado!" : "Erro.";
        $tipo = $sucesso ? "success" : "error";
        Redirect::redirecionarComMensagem("servico-site/listar", $tipo, $msg);
    }
}