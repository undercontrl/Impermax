<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Material;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\MaterialValidador;

class MaterialController{
    public $material;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
       $this->material = new Material($this->db);
    }
    // index
    public function index(){
        $resultado = $this->material->buscarMateriais();
        var_dump($resultado);
    }

    public function viewListarMateriais(){
        $dados = $this->material->buscarMateriais();
        View::render("material/index", ["materiais" => $dados]);
    }

    public function viewCriarMateriais(){
        View::render("material/create");
    }
    public function viewEditarMateriais(){
        $id=$_GET['id'] ?? null;
        var_dump($_POST);exit;
        if(!$id){
            Redirect::redirecionarComMensagem("material/listar", "error", "ID do usuário não fornecido.");
        }
        $material = $this->material->buscarmaterialsPorTipo($id);
        if(!$material){
            Redirect::redirecionarComMensagem("material/listar", "error", "Usuário não encontrado.");
        }
        View::render("material/edit", ["material" => $material]);
    }
    public function viewExcluirmateriais(){
        View::render("material/delete");
    }

    public function salvarMaterial(){
        $erros = MaterialValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("material/criar", "error", implode("<br>", $erros));
        }
        if($this->material->inserirMaterial($_POST["nome_material"], $_POST["qtd_material"], $_POST["descricao_material"], $_POST["id_servico"])){
            Redirect::redirecionarComMensagem("material/listar", "success", "Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("material/criar", "error", "Erro ao cadastrar usuário!");
        }
    }
 
    public function atualizarMaterial(){
        echo "atualizar material";
    }
    public function deletarMaterial(){
        echo "deletar material";
    }

}