<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Servico;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ServicoValidador;
use App\Impermax\Core\FileManager;

class ServicoController{
    public $servico;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
       $this->servico = new Servico($this->db);
       $this->gerenciarImagem = new FileManager('upload');
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
public function viewEditarServicos($id = null){
    if(!$id){
        Redirect::redirecionarComMensagem("servico/listar", "error", "ID do serviço não fornecido.");
    }

    $stmt = $this->db->prepare("SELECT * FROM tbl_servico WHERE id_servico = :id AND excluido_em IS NULL");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $servico = $stmt->fetch(\PDO::FETCH_ASSOC);

    if(!$servico){
        Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
    }

    View::render("servico/edit", ["servico" => $servico]);
}

public function atualizarServico($id){
    $erros = ServicoValidador::ValidarEntradas($_POST);
    if(!empty($erros)){
        Redirect::redirecionarComMensagem("servico/editar/$id", "error", implode("<br>", $erros));
    }

    // caso o usuário não troque a foto
    $foto_servico = $_FILES['foto_servico']['name'] 
        ? $this->gerenciarImagem->salvarArquivo($_FILES['foto_servico'], 'servicos') 
        : $_POST['foto_servico_atual'];

    $sucesso = $this->servico->atualizaServico(
        $id,
        $_POST["nome_servico"], 
        $_POST["descricao_servico"], 
        $_POST["valor_base_servico"], 
        $foto_servico,
        $_POST["status_servico"]
    );

    if($sucesso){
        Redirect::redirecionarComMensagem("servico/listar", "success", "Serviço atualizado com sucesso!");
    }else{
        Redirect::redirecionarComMensagem("servico/editar/$id", "error", "Erro ao atualizar o serviço!");
    }
}


   public function viewExcluirServicos($id){
    $stmt = $this->db->prepare("SELECT * FROM tbl_servico WHERE id_servico = :id AND excluido_em IS NULL");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $servico = $stmt->fetch(\PDO::FETCH_ASSOC);

    if(!$servico){
        Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
    }

    View::render("servico/delete", ["servico" => $servico]);
}

public function deletarServico($id){
    $sucesso = $this->servico->excluirServico($id);

    if($sucesso){
        Redirect::redirecionarComMensagem("servico/listar", "success", "Serviço excluído com sucesso!");
    }else{
        Redirect::redirecionarComMensagem("servico/listar", "error", "Erro ao excluir o serviço!");
    }
}
}