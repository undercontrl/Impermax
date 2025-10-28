<?php 
namespace App\Impermax\Controllers\Admin;
use App\Impermax\Core\Redirect;

abstract class FuncionarioController extends AuthenticatedController{
    public function __construct(){
        parent::__construct();
        if ($this->session->get('usuario_tipo') !== 'funcionario' && $this->session->get('usuario_tipo') !== 'admin'){
            Redirect::redirecionarComMensagem(
                'login',
                'error',
                'Você precisa estar logado para acessar esta página '
            );
        }
        
    }
}
