<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\UsuarioValidador;

class UsuarioController{
    public $usuario;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
       $this->usuario = new Usuario($this->db);
    }
    // index
    public function index(){
        $resultado = $this->usuario->buscarUsuarios();
        var_dump($resultado);
    }

    public function viewListarUsuarios(){
        $dados = $this->usuario->buscarUsuarios();
        View::render("usuario/index", ["usuarios" => $dados]);
    }

    public function viewCriarUsuarios(){
        View::render("usuario/create");
    }
    public function viewEditarUsuarios(){
        View::render("usuario/edit");
    }
    public function viewExcluirUsuarios(){
        View::render("usuario/delete");
    }

    public function salvarUsuario(){
        $erros = UsuarioValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/criar", "error", implode("<br>", $erros));
        }
        if($this->usuario->inserirUsuario($_POST["nome_usuario"], $_POST["email_usuario"], $_POST["senha_usuario"], $_POST["tipo_usuario"], "Ativo")){
            Redirect::redirecionarComMensagem("usuario/listar", "success", "Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("usuario/criar", "error", "Erro ao cadastrar usuário!");
        }
    }
 
    public function atualizarUsuario(){
        echo "atualizar Usuario";
    }
    public function deletarUsuario(){
        echo "deletar Usuario";
    }

}