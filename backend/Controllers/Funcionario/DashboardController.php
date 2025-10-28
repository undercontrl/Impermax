<?php
namespace App\Impermax\Controllers\Funcionario;

use App\Impermax\Core\View;
use App\Impermax\Controllers\Admin\AuthenticatedController;
use App\Impermax\Models\Agendamento;
use App\Impermax\Models\Orcamento;
use App\Impermax\Database\Database;

class DashboardController extends AuthenticatedController
{
    private Agendamento $agendamento;
    private Orcamento $orcamento;
    protected array $usuario;

    public function __construct()
    {
        parent::__construct(['funcionario', 'admin']);
        $this->usuario = $this->getUsuario();
        $db = Database::getInstance();
        $this->agendamento = new Agendamento($db);
        $this->orcamento = new Orcamento($db);
    }

    private function getUsuario(): array
    {
        return [
            'id' => $_SESSION['usuario_id'] ?? 1,
            'nome' => $_SESSION['usuario_nome'] ?? 'Funcionário Teste'
        ];
    }

    public function index(): void
    {
        // === Contadores principais ===
        $totalHoje = $this->agendamento->contarAgendamentosDeHoje();
        $orcamentosAndamento = $this->orcamento->contarOrcamentosEmAndamento();
        $pendencias = $this->agendamento->contarPendencias();

        // === Dados para os gráficos ===
        $graficoServicos = $this->agendamento->contarServicosPorMes();
        $graficoStatus = $this->agendamento->distribuicaoPorStatus();

        // === Próximos agendamentos ===
        $todosAgendamentos = $this->agendamento->buscarAgendamentosComCliente();
        $hoje = date('Y-m-d');
        $proximosAgendamentos = array_filter($todosAgendamentos, function($ag) use ($hoje) {
            return strtotime($ag['data_solicitada']) >= strtotime($hoje);
        });
        usort($proximosAgendamentos, fn($a, $b) => strtotime($a['data_solicitada']) <=> strtotime($b['data_solicitada']));
        $proximosAgendamentos = array_slice($proximosAgendamentos, 0, 5);

        // === Dados para a view ===
        View::render('funcionario/dashboard/index', [
            'nomeUsuario' => $this->usuario['nome'],
            'totalHoje' => $totalHoje,
            'orcamentosAndamento' => $orcamentosAndamento,
            'pendencias' => $pendencias,
            'servicosConcluidos' => array_sum($graficoServicos),
            'graficoServicos' => json_encode($graficoServicos),
            'graficoStatus' => json_encode($graficoStatus),
            'proximosAgendamentos' => $proximosAgendamentos
        ]);
    }
}
