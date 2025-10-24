<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Projeto;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\projetoValidador;
use App\Impermax\Core\FileManager;
use App\Impermax\Controllers\Admin\AuthenticatedController;
use App\Impermax\Controllers\Admin\AdminController;

class ProjetoController extends AdminController {
    public $projeto;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
       $this->projeto = new Projeto($this->db);
       $this->gerenciarImagem = new FileManager('upload');
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
    
    public function salvarProjeto(){
        $erros = ProjetoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("projeto/criar", "error", implode("<br>", $erros));
        }
        $foto_antes_projeto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_antes_projeto'], 'projeto');
        $foto_depois_projeto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_depois_projeto'], 'projeto');
        if($this->projeto->inserirProjeto(
            $foto_antes_projeto, 
            $foto_depois_projeto, 
            $_POST["descricao_projeto"]
            )){
            Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("projeto/criar", "error", "Erro ao cadastrar projeto!");
        }
    }
 


    public function viewEditarProjetos($id = null){
        if(!$id){
        Redirect::redirecionarComMensagem("projeto/listar", "error", "ID do projeto não fornecido.");
    }
    $projeto = $this->projeto->buscarProjetoPorID($id);

    if(!$projeto){
        Redirect::redirecionarComMensagem("projeto/listar", "error", "projeto não encontrado.");
    }

    View::render("projeto/edit", ["projeto" => $projeto]);
    }

    public function atualizarProjeto($id){
       $erros = projetoValidador::ValidarEntradas($_POST);
    if (!empty($erros)) {
        Redirect::redirecionarComMensagem("projeto/editar/$id", "error", implode("<br>", $erros));
    }
    
    $foto_antes_projeto = !empty($_FILES['foto_antes_projeto']['name'])
        ? $this->gerenciarImagem->salvarArquivo($_FILES['foto_antes_projeto'], 'projeto')
        : $_POST['foto_projeto_atual'];
    $foto_depois_projeto = !empty($_FILES['foto_depois_projeto']['name'])
        ? $this->gerenciarImagem->salvarArquivo($_FILES['foto_depois_projeto'], 'projeto')
        : $_POST['foto_projeto_atual'];

    $sucesso = $this->projeto->atualizarProjeto(
        $id,                               
        $foto_antes_projeto, 
        $foto_depois_projeto, 
        $_POST["descricao_projeto"] 
    );

    if ($sucesso) {
        Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto atualizado com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("projeto/editar/$id", "error", "Erro ao atualizar o projeto!");
    }
}
    
    public function viewExcluirProjetos($id){
   {
        $projeto = $this->projeto->buscarProjetoPorID($id);
        if (!$projeto) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "projeto não encontrado.");
        }

        View::render("projeto/delete", ["projeto" => $projeto]);
    }

    }

    public function deletarProjeto($id){
    {
        $sucesso = $this->projeto->excluirProjeto($id);
        if ($sucesso) {
            Redirect::redirecionarComMensagem("projeto/listar", "success", "projeto excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "Erro ao excluir o projeto!");
        }
    }
    }

    }
