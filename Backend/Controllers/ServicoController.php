<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Servico;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ServicoValidador;

class ServicoController{
    public $servico;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
       $this->servico = new Servico($this->db);
    }
    // index
    public function index(){
        $resultado = $this->servico->buscarServicos();
        var_dump($resultado);
    }

    public function viewListarServicos(){
        $dados = $this->servico->buscarServicos();
        View::render("servico/index", ["servicos" => $dados]);
    }

    public function viewCriarServicos(){
        View::render("servico/create");
    }
    public function viewEditarServicos(){
        $id=$_GET['id'] ?? null;
        var_dump($_POST);exit;
        if(!$id){
            Redirect::redirecionarComMensagem("servico/listar", "error", "ID do usuário não fornecido.");
        }
        $servico = $this->servico->buscarServicosPorTipo($id);
        if(!$servico){
            Redirect::redirecionarComMensagem("servico/listar", "error", "Usuário não encontrado.");
        }
        View::render("servico/edit", ["servico" => $servico]);
    }
    public function viewExcluirservicos(){
        View::render("servico/delete");
    }

    public function salvarservico(){
        $erros = ServicoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("servico/criar", "error", implode("<br>", $erros));
        }
        if($this->servico->inserirServico($_POST["nome_servico"], $_POST["descricao_servico"], $_POST["valor_base_servico"], $_POST["foto_servico"], $_POST["tipo_servico"], "ativo")){
            Redirect::redirecionarComMensagem("servico/listar", "success", "Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("servico/criar", "error", "Erro ao cadastrar usuário!");
        }
    }
 
    public function atualizarServico(){
        echo "atualizar servico";
    }
    public function deletarServico(){
        echo "deletar servico";
    }

}