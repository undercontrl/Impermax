<?php
namespace App\Impermax\Controllers\Admin;

use App\Impermax\Core\View;
use App\Impermax\Database\Database;
use App\Impermax\Models\Usuario;
use App\Impermax\Models\Agendamento;
use App\Impermax\Models\Orcamento;
use App\Impermax\Models\Contato;

class DashboardController extends AuthenticatedController {
    private $db;
    private $usuario;
    private $agendamento;
    private $orcamento;
    private $contato;

    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->agendamento = new Agendamento($this->db);
        $this->orcamento = new Orcamento($this->db);
        $this->contato = new Contato($this->db);
    }

    public function index(): void {
        $usuarios = $this->usuario->buscarUsuarios() ?? [];
        $totalAgendamentos = count($this->agendamento->buscarAgendamentos() ?? []);
        $totalOrcamentos = method_exists($this->orcamento, 'buscarOrcamentos') ? count($this->orcamento->buscarOrcamentos()) : 0;
        $totalContatos = count($this->contato->buscarContatos() ?? []);

        View::render('admin/dashboard/index', [
            'nomeUsuario' => $this->session->get('usuario_nome'),
            'tipo' => $this->session->get('usuario_tipo'),
            'usuarios' => $usuarios,
            'totalAgendamentos' => $totalAgendamentos,
            'totalOrcamentos' => $totalOrcamentos,
            'totalContatos' => $totalContatos
        ]);
    }
}
