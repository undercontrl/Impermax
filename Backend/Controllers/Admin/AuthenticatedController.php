<?php
namespace App\Impermax\Controllers\Admin;

use App\Impermax\Core\Session;
use App\Impermax\Core\Redirect;

abstract class AuthenticatedController{
    protected Session $session;
    public function __construct() {
            $this->session = new Session();
            if (!$this->session->has('usuario_id')){
                Redirect::redirecionarComMensagem(
                    'login',
                    'error',
                    'Você precisa estar logado para acessar esta página.'
                );
            }
        
    }
}