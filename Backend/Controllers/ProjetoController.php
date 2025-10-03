<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Projeto;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\projetoValidador;

class ProjetoController{
    public $projeto;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
       $this->projeto = new Projeto($this->db);
    }
    // index
    public function index(){
        $resultado = $this->projeto->buscarProjetos();
        var_dump($resultado);
    }

    public function viewListarProjetos(){
        $dados = $this->projeto->buscarProjetos();
        View::render("projeto/index", ["Projetos" => $dados]);
    }

    public function viewCriarProjetos(){
        View::render("projeto/create");
    }
    public function viewEditarProjetos(){
        $id=$_GET['id'] ?? null;
        var_dump($_POST);exit;
        if(!$id){
            Redirect::redirecionarComMensagem("projeto/listar", "error", "ID do projeto não fornecido.");
        }
        $projeto = $this->projeto->buscarprojetosPorTipo($id);
        if(!$projeto){
            Redirect::redirecionarComMensagem("projeto/listar", "error", "Projeto não encontrado.");
        }
        View::render("projeto/edit", ["projeto" => $projeto]);
    }
    public function viewExcluirprojetos(){
        View::render("projeto/delete");
    }

    public function salvarProjeto(){
        $erros = ProjetoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("projeto/criar", "error", implode("<br>", $erros));
        }
        if($this->projeto->inserirProjeto($_POST["nome_projeto"], $_POST["foto_antes_projeto"], $_POST["foto_depois_projeto"], $_POST["descricao_projeto"])){
            Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("projeto/criar", "error", "Erro ao cadastrar projeto!");
        }
    }
 
    public function atualizarProjeto(){
        echo "atualizar projeto";
    }
    public function deletarProjeto(){
        echo "deletar projeto";
    }

}