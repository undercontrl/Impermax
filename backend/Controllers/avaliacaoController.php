<?php
namespace App\Impermax\Controllers;
 
use App\Impermax\Models\avaliacao;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\AvaliacaoValidador; 

class AvaliacaoController{
    public $avaliacao;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->avaliacao = new Avaliacao($this->db);
    }
    // index
    public function index(){
        $resultado = $this->avaliacao->buscarAvaliacao();
        var_dump($resultado);
    }
    public function viewListarAvaliacao(){
        $dados = $this->avaliacao->buscarAvaliacao();
        View::render("avaliacao/index", ["avaliacao" => $dados]);
    }
    public function viewCriarAvaliacao(){
        View::render("avaliacao/create");
    }
    public function viewEditarAvaliacao(){
        View::render("avaliacao/edit");
    }
    public function viewExcluirAvaliacao(){
        View::render("avaliacao/delete");
    }
    public function salvarAvaliacao(){
        $erros = AvaliacaoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("avaliacao/criar", "error", implode("<br>", $erros));
        }
        if($this->avaliacao->inserirAvaliacao($_POST["nome_avaliacao"], $_POST["email_avaliacao"], $_POST["senha_avaliacao"], $_POST["tipo_avaliacao"], "Ativo")){
            Redirect::redirecionarComMensagem("avaliacao/listar", "success", "Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("avaliacao/criar", "error", "Erro ao cadastrar usuário!");
        }
    }
    public function atualizarAvaliacao(){
        echo "Atualizar Avaliacao";
    }
    public function deletarAvaliacao(){
        echo "Deletar Avaliacao";
    }
 
}