<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Orcamento;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\orcamentoValidador;
use App\Impermax\Models\usuario;

class orcamentoController{
    public $orcamento;
    public $usuario;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
       $this->orcamento = new orcamento($this->db);
        $this->usuario = new usuario($this->db);
    }
    // index
    public function index(){
        $resultado = $this->orcamento->buscarOrcamentos();
        var_dump($resultado);
    }

    public function viewListarOrcamentos(){
        $dados = $this->orcamento->buscarOrcamentos();
        View::render("orcamento/index", ["orcamentos" => $dados]);
    }

    public function viewCriarOrcamentos(){
        $cliente = $this->usuario->buscarUsuarios();
        // View::render("orcamento/create");
        View::render("orcamento/create", ["usuarios" => $cliente]);
    }
    public function viewEditarOrcamentos(){
        $id=$_GET['id'] ?? null;
        var_dump($_POST);exit;
        if(!$id){
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "ID do usuário não fornecido.");
        }
        $orcamento = $this->orcamento->buscarorcamentosPorTipo($id);
        if(!$orcamento){
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Usuário não encontrado.");
        }
        View::render("orcamento/edit", ["orcamento" => $orcamento]);
    }
    public function viewExcluirOrcamento(){
        View::render("orcamento/delete");
    }

    public function salvarOrcamento(){
        $erros = orcamentoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("orcamento/criar", "error", implode("<br>", $erros));
        }
        if($this->orcamento->inserirOrcamento($_POST["id_cliente"], $_POST["descricao_orcamento"], $_POST["status_orcamento"],$_POST["data_orcamento"], $_POST["valor_orcamento"], $_POST["total_item_orcamento"])){
            Redirect::redirecionarComMensagem("orcamento/listar", "success", "Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("orcamento/criar", "error", "Erro ao cadastrar usuário!");
        }
    }
 
    public function atualizarOrcamento(){
        echo "atualizar orcamento";
    }
    public function deletarOrcamento(){
        echo "deletar orcamento";
    }

}