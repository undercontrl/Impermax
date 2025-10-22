<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\UsuarioValidador;
use App\Impermax\Controllers\Admin\AuthenticatedController;
use App\Impermax\Controllers\Admin\AdminController;

class UsuarioController extends AdminController{
    private $usuario;
    private $db;
    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
       $this->usuario = new Usuario($this->db);
    }

   public function salvarUsuario() {
    $erros = UsuarioValidador::ValidarEntradas($_POST);
    if (!empty($erros)) {
        Redirect::redirecionarComMensagem("usuario/criar", "error", implode("<br>", $erros));
        return;
    }
    
    $sucesso = $this->usuario->inserirUsuario(
        $_POST["nome_usuario"], 
        $_POST["email_usuario"], 
        $_POST["senha_usuario"], 
        $_POST["tipo_usuario"], 
        "Ativo"  // ✅ SEMPRE "Ativo" com A maiúsculo
    );
    
    if ($sucesso) {
        Redirect::redirecionarComMensagem("usuario/listar", "success", "Usuário cadastrado com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("usuario/criar", "error", "Erro ao cadastrar usuário!");
    }
}
    // index
    // public function index(){
    //     $resultado = $this->usuario->buscarUsuarios();
    //     var_dump($resultado);
    // }

    public function index() {
        $this->viewListarUsuarios();
    }

    public function viewListarUsuarios() {
    $dados = $this->usuario->buscarUsuarios();
    View::render("usuario/index", ["usuarios" => $dados]);
}

    public function viewCriarUsuarios(){
        View::render("usuario/create");
    }


      public function viewEditarUsuarios($id = null){
    if(!$id){
        Redirect::redirecionarComMensagem("usuario/listar", "error", "ID do serviço não fornecido.");
    }
     $usuario = $this->usuario->buscarUsuarioPorID($id);

    if(!$usuario){
        Redirect::redirecionarComMensagem("usuario/listar", "error", "Serviço não encontrado.");
    }

    View::render("usuario/edit", ["usuario" => $usuario]);
}

    
   

    public function relatorioUsuario($id, $dataInicial, $dataFinal){
        View::render("usuario/relatorio", 
        ["id"=>$id, "dataInicial"=>$dataInicial, "dataFinal"=>$dataFinal]);
    }

    public function viewExcluirUsuarios($id) {
        $usuario = $this->usuario->buscarUsuarioPorID($id);  // ✅ RETORNA OBJETO DIRETO
        if ($usuario) {
            View::render("usuario/delete", ["usuario" => $usuario]);
        } else {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Usuário não encontrado!");
        }

    }
    // ✅ JÁ CORRIGIDO o atualizarUsuario (adicione este método completo)
    public function atualizarUsuario($id) {
        $erros = UsuarioValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("usuario/editar/{$id}", "error", implode("<br>", $erros));
            return;
        }
        
        $senha = !empty($_POST["senha_usuario"]) ? $_POST["senha_usuario"] : null;
        
        if ($this->usuario->atualizarUsuario(
            $id,
            $_POST["nome_usuario"], 
            $_POST["email_usuario"], 
            $senha, 
            $_POST["tipo_usuario"], 
            $_POST["status_usuario"]
        )) {
            Redirect::redirecionarComMensagem("usuario/listar", "success", "Usuário atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("usuario/editar/{$id}", "error", "Erro ao atualizar usuário!");
        }
    }

    // ✅ JÁ CORRIGIDO o deletarUsuario
    public function deletarUsuario($id) {
        if ($this->usuario->excluirUsuario($id)) {
            Redirect::redirecionarComMensagem("usuario/listar", "success", "Usuário excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Erro ao excluir usuário!");
        }
    }
    }