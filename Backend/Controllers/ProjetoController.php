<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Projeto;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\projetoValidador;
use App\Impermax\Core\FileManager;

class ProjetoController{
    public $projeto;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
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
  public function viewEditarProjetos($id = null){

    if(!$id){
        Redirect::redirecionarComMensagem("projeto/listar", "error", "ID do projeto não fornecido.");
    }

    $projeto = $this->projeto->buscarProjetoPorId($id);

    if(!$projeto){
        Redirect::redirecionarComMensagem("projeto/listar", "error", "Projeto não encontrado.");
    }

    View::render("projeto/edit", ["projeto" => $projeto]);
}



public function atualizarProjeto(){
    $id = $_POST['id_projeto'] ?? null;
    $descricao = $_POST['descricao_projeto'] ?? '';

    if (!$id) {
        Redirect::redirecionarComMensagem("projeto/listar", "error", "ID do projeto não informado.");
    }

    // Gerenciar upload das imagens (mantém as antigas se não for enviado novo arquivo)
    $foto_antes = $_FILES['foto_antes_projeto']['name'] 
        ? $this->gerenciarImagem->salvarArquivo($_FILES['foto_antes_projeto'], 'projeto') 
        : $_POST['foto_antes_atual'];

    $foto_depois = $_FILES['foto_depois_projeto']['name'] 
        ? $this->gerenciarImagem->salvarArquivo($_FILES['foto_depois_projeto'], 'projeto') 
        : $_POST['foto_depois_atual'];

    if ($this->projeto->atualizarProjeto($id, $foto_antes, $foto_depois, $descricao)) {
        Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto atualizado com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("projeto/editar?id=$id", "error", "Erro ao atualizar projeto!");
    }
}


public function viewExcluirProjetos(){
    $id = $_GET['id'] ?? null;
    if (!$id) {
        Redirect::redirecionarComMensagem("projeto/listar", "error", "ID do projeto não fornecido.");
    }
    $projeto = $this->projeto->buscarProjetoPorId($id);
    if (!$projeto) {
        Redirect::redirecionarComMensagem("projeto/listar", "error", "Projeto não encontrado.");
    }
    View::render("projeto/delete", ["projeto" => $projeto]);
}


public function deletarProjeto(){
    $id = $_POST['id_projeto'] ?? null;

    if (!$id) {
        Redirect::redirecionarComMensagem("projeto/listar", "error", "ID do projeto não informado.");
    }

    if ($this->projeto->excluirProjeto($id)) {
        Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto excluído com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("projeto/listar", "error", "Erro ao excluir projeto!");
    }
}

public function salvarProjeto(){
    $descricao = $_POST['descricao_projeto'] ?? null;

    // Validação simples
    if (!$descricao || empty($_FILES['foto_antes_projeto']['name']) || empty($_FILES['foto_depois_projeto']['name'])) {
        Redirect::redirecionarComMensagem("projeto/criar", "error", "Preencha todos os campos e envie as imagens.");
    }

    // Upload das imagens
    $foto_antes_projeto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_antes_projeto'], 'projeto');
    $foto_depois_projeto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_depois_projeto'], 'projeto');

    // Inserção no banco
    if ($this->projeto->inserirProjeto($foto_antes_projeto, $foto_depois_projeto, $descricao)) {
        Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto cadastrado com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("projeto/criar", "error", "Erro ao cadastrar projeto!");
    }
}


}