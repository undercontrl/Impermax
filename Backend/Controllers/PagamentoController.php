<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Pagamento;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\PagamentoValidador;

class PagamentoController{
    public $pagamento;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
       $this->pagamento = new pagamento($this->db);
    }
    // index
    public function index(){
        $resultado = $this->pagamento->buscarPagamentos();
        var_dump($resultado);
    }

    public function viewListarPagamentos(){
        $dados = $this->pagamento->buscarPagamentos();
        View::render("pagamento/index", ["pagamentos" => $dados]);
    }

    public function viewCriarPagamentos(){
        View::render("pagamento/create");
    }
    public function viewEditarPagamentos(){
        $id=$_GET['id'] ?? null;
        var_dump($_POST);exit;
        if(!$id){
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "ID do usuário não fornecido.");
        }
        $pagamento = $this->pagamento->buscarpPagamentosPorTipo($id);
        if(!$pagamento){
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "Usuário não encontrado.");
        }
        View::render("pagamento/edit", ["pagamento" => $pagamento]);
    }
    public function viewExcluirPagamentos(){
        View::render("pagamento/delete");
    }

    public function salvarPagamento(){
        $erros = PagamentoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("pagamento/criar", "error", implode("<br>", $erros));
        }
        if($this->pagamento->inserirpagamento($_POST["id_cliente"], $_POST["total_devedor"], $_POST["dinheiro"],$_POST["credito"], $_POST["debito"],$_POST["pix"], $_POST["status_pagamento"],$_POST["data_pagamento"] )){
            Redirect::redirecionarComMensagem("pagamento/listar", "success", "Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("pagamento/criar", "error", "Erro ao cadastrar usuário!");
        }
    }
 
    public function atualizarPagamento(){
        echo "atualizar pagamento";
    }
    public function deletarPagamento(){
        echo "deletar pagamento";
    }

}