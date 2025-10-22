<?php 
namespace App\Impermax\Controllers\Admin;
use App\Impermax\Core\Redirect;

abstract class AdminController extends AuthenticatedController{
    public function __construct(){
        parent::__construct();
        if ($this->session->get('usuario_tipo') !== 'admin'){
            Redirect::redirecionarComMensagem(
                'admin/dashboard',
                'error',
                'Você precisa estar logado para acessar esta página '
            );
        }
        
    }
}
