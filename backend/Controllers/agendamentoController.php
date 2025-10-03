<?php
namespace App\Impermax\Controllers;
 
use App\Impermax\Models\agendamento;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\AgendamentoValidador; 

class AgendamentoController{
    public $agendamento;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->agendamento = new agendamento($this->db);
    }
    // index
    public function index(){
        $resultado = $this->agendamento->buscarAgendamentos();
        var_dump($resultado);
    }
    public function viewListarAgendamentos(){
        $dados = $this->agendamento->buscarAgendamentos();
        View::render("agendamento/index", ["agendamentos" => $dados]);
    }
    public function viewCriarAgendamentos(){
        View::render("agendamento/create");
    }
    public function viewEditarAgendamentos(){
        View::render("agendamento/edit");
    }
    public function viewExcluiragendamentos(){
        View::render("agendamento/delete");
    }
    public function salvarAgendamento(){
        $erros = agendamentoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("agendamento/criar", "error", implode("<br>", $erros));
        }
        if($this->agendamento->inserirAgendamento($_POST["id_agendamento"], $_POST["data_solicitada"], $_POST["total_agendamento"], $_POST["status_agendamento"])){
            Redirect::redirecionarComMensagem("agendamento/listar", "success", "Agendamento realizado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("agendamento/criar", "error", "Erro ao realizar agendamento!");
        }       
    }
    public function atualizarAgendamento(){
        echo "Atualizar agendamento";
    }
    public function deletarAgendamento(){
        echo "Deletar agendamento";
    }
 
}