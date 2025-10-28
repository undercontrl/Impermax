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
        parent::__construct(['admin']); // garante acesso só ao admin
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->agendamento = new Agendamento($this->db);
        $this->orcamento = new Orcamento($this->db);
        $this->contato = new Contato($this->db);
    }

    public function index(): void {
        // === Contadores ===
        $usuarios = $this->usuario->buscarUsuarios() ?? [];
        $totalAgendamentos = count($this->agendamento->buscarAgendamentos() ?? []);
        $totalOrcamentos = count($this->orcamento->buscarOrcamentos() ?? []);
        $totalContatos = count($this->contato->buscarContatos() ?? []);

        // === Gráfico: Agendamentos por mês ===
        $sqlAgMes = "
            SELECT MONTH(data_solicitada) AS mes, COUNT(*) AS total
            FROM tbl_agendamento
            WHERE excluido_em IS NULL
            GROUP BY MONTH(data_solicitada)
        ";
        $stmtAgMes = $this->db->query($sqlAgMes);
        $graficoAgendamentos = array_fill(1, 12, 0);
        while ($row = $stmtAgMes->fetch(\PDO::FETCH_ASSOC)) {
            $graficoAgendamentos[(int)$row['mes']] = (int)$row['total'];
        }

        // === Gráfico: Distribuição de status ===
        $sqlStatus = "
            SELECT status_agendamento, COUNT(*) AS total
            FROM tbl_agendamento
            WHERE excluido_em IS NULL
            GROUP BY status_agendamento
        ";
        $stmtStatus = $this->db->query($sqlStatus);
        $graficoStatusAdmin = [];
        while ($row = $stmtStatus->fetch(\PDO::FETCH_ASSOC)) {
            $graficoStatusAdmin[$row['status_agendamento']] = (int)$row['total'];
        }

        // === Renderiza a View ===
        View::render('admin/dashboard/index', [
            'nomeUsuario' => $this->session->get('usuario_nome'),
            'tipo' => $this->session->get('usuario_tipo'),
            'usuarios' => $usuarios,
            'totalAgendamentos' => $totalAgendamentos,
            'totalOrcamentos' => $totalOrcamentos,
            'totalContatos' => $totalContatos,
            'graficoAgendamentos' => json_encode(array_values($graficoAgendamentos)),
            'graficoStatusAdmin' => json_encode($graficoStatusAdmin)
        ]);
    }
}
