<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Material;
use App\Impermax\Models\Servico;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\MaterialValidador;
use App\Impermax\Controllers\Admin\AuthenticatedController;
use App\Impermax\Controllers\Admin\AdminController;

class MaterialController  extends AdminController {
    private $material;
    private $servico;
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->material = new Material($this->db);
        $this->servico = new Servico($this->db);
    }

    public function index() {
        $this->viewListarMateriais();
    }

    // ✅ SALVAR
    public function salvarMaterial() {
        $erros = MaterialValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("material/criar", "error", implode("<br>", $erros));
            return;
        }

        if ($this->material->inserirMaterial(
            $_POST["nome_material"],
            $_POST["qtd_material"],
            $_POST["descricao_material"],
            $_POST["id_servico"]
        )) {
            Redirect::redirecionarComMensagem("material/listar", "success", "Material cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("material/criar", "error", "Erro ao cadastrar material!");
        }
    }

    // ✅ ATUALIZAR
    public function atualizarMaterial(int $id) {
        $erros = MaterialValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("material/editar/{$id}", "error", implode("<br>", $erros));
            return;
        }

        if ($this->material->atualizarMaterial(
            $id,
            $_POST["nome_material"],
            $_POST["qtd_material"],
            $_POST["descricao_material"],
            $_POST["id_servico"]
        )) {
            Redirect::redirecionarComMensagem("material/listar", "success", "Material atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("material/editar/{$id}", "error", "Erro ao atualizar material!");
        }
    }

    // ✅ DELETAR
    public function deletarMaterial(int $id) {
        if ($this->material->excluirMaterial($id)) {
            Redirect::redirecionarComMensagem("material/listar", "success", "Material excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("material/listar", "error", "Erro ao excluir material!");
        }
    }

    public function viewListarMateriais() {
        $dados = $this->material->buscarMateriais();
        View::render("material/index", ["materiais" => $dados]);
    }

    public function viewCriarMateriais() {
        $servicos = $this->servico->buscarServicos();
        View::render("material/create", ["servicos" => $servicos]);
    }

    public function viewEditarMateriais(int $id) {
        $material = $this->material->buscarMaterialPorID($id);
        $servicos = $this->servico->buscarServicos();
        
        if ($material) {
            View::render("material/edit", [
                "material" => $material,
                "servicos" => $servicos
            ]);
        } else {
            Redirect::redirecionarComMensagem("material/listar", "error", "Material não encontrado!");
        }
    }

    public function viewExcluirMateriais(int $id) {
        $material = $this->material->buscarMaterialPorID($id);
        if ($material) {
            View::render("material/delete", ["material" => $material]);
        } else {
            Redirect::redirecionarComMensagem("material/listar", "error", "Material não encontrado!");
        }
    }
}