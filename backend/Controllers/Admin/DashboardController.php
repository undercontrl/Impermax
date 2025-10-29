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
        // ============================================
        // FILTRO DE PERÍODO
        // ============================================
        
        // Pega o período selecionado (padrão: mês)
        $periodo = $_GET['periodo'] ?? 'mes';
        
        // Calcula as datas de início e fim baseado no período
        $dataFim = date('Y-m-d 23:59:59');
        
        switch ($periodo) {
            case '3meses':
                $dataInicio = date('Y-m-d 00:00:00', strtotime('-3 months'));
                $periodoTexto = 'Últimos 3 Meses';
                break;
            case 'ano':
                $dataInicio = date('Y-m-d 00:00:00', strtotime('-1 year'));
                $periodoTexto = 'Último Ano';
                break;
            case 'mes':
            default:
                $dataInicio = date('Y-m-d 00:00:00', strtotime('-1 month'));
                $periodoTexto = 'Último Mês';
                $periodo = 'mes';
                break;
        }

        // ============================================
        // BUSCA DE DADOS (usando métodos das Models)
        // ============================================

        // Usuários (sem filtro de período)
        $usuarios = $this->usuario->buscarUsuarios() ?? [];

        // Agendamentos filtrados por período
        $totalAgendamentos = $this->agendamento->contarPorPeriodo($dataInicio, $dataFim);
        
        // Orçamentos filtrados por período
        $totalOrcamentos = $this->orcamento->contarPorPeriodo($dataInicio, $dataFim);
        
        // Contatos filtrados por período
        $totalContatos = $this->contato->contarPorPeriodo($dataInicio, $dataFim);

        // ============================================
        // ESTATÍSTICAS DE CRESCIMENTO
        // ============================================
        
        $estatisticas = $this->calcularEstatisticas($dataInicio, $dataFim, $periodo);

        // ============================================
        // GRÁFICOS (usando métodos das Models)
        // ============================================
        
        // Gráfico: Agendamentos por mês
        $graficoAgendamentos = $this->agendamento->buscarPorMes($dataInicio, $dataFim);

        // Gráfico: Distribuição de status
        $graficoStatusAdmin = $this->agendamento->buscarDistribuicaoPorStatus($dataInicio, $dataFim);

        // ============================================
        // RENDERIZA A VIEW
        // ============================================
        
        View::render('admin/dashboard/index', [
            'nomeUsuario' => $this->session->get('usuario_nome'),
            'tipo' => $this->session->get('usuario_tipo'),
            'usuarios' => $usuarios,
            'totalAgendamentos' => $totalAgendamentos,
            'totalOrcamentos' => $totalOrcamentos,
            'totalContatos' => $totalContatos,
            'periodo' => $periodo,
            'periodoTexto' => $periodoTexto,
            'dataInicio' => date('d/m/Y', strtotime($dataInicio)),
            'dataFim' => date('d/m/Y', strtotime($dataFim)),
            'estatisticas' => $estatisticas,
            'graficoAgendamentos' => json_encode(array_values($graficoAgendamentos)),
            'graficoStatusAdmin' => json_encode($graficoStatusAdmin)
        ]);
    }

    // ============================================
    // CÁLCULO DE ESTATÍSTICAS E TENDÊNCIAS
    // ============================================

    /**
     * Calcula estatísticas de crescimento comparando períodos
     */
    private function calcularEstatisticas(string $dataInicio, string $dataFim, string $periodo): array
    {
        // Calcula o período anterior para comparação
        switch ($periodo) {
            case '3meses':
                $dataInicioAnterior = date('Y-m-d 00:00:00', strtotime('-6 months'));
                $dataFimAnterior = date('Y-m-d 23:59:59', strtotime('-3 months -1 day'));
                break;
            case 'ano':
                $dataInicioAnterior = date('Y-m-d 00:00:00', strtotime('-2 years'));
                $dataFimAnterior = date('Y-m-d 23:59:59', strtotime('-1 year -1 day'));
                break;
            default: // mes
                $dataInicioAnterior = date('Y-m-d 00:00:00', strtotime('-2 months'));
                $dataFimAnterior = date('Y-m-d 23:59:59', strtotime('-1 month -1 day'));
                break;
        }

        // Busca dados do período ANTERIOR (usando Models)
        $agendamentosAnteriores = $this->agendamento->contarPorPeriodo($dataInicioAnterior, $dataFimAnterior);
        $orcamentosAnteriores = $this->orcamento->contarPorPeriodo($dataInicioAnterior, $dataFimAnterior);
        $contatosAnteriores = $this->contato->contarPorPeriodo($dataInicioAnterior, $dataFimAnterior);

        // Busca dados do período ATUAL (usando Models)
        $agendamentosAtuais = $this->agendamento->contarPorPeriodo($dataInicio, $dataFim);
        $orcamentosAtuais = $this->orcamento->contarPorPeriodo($dataInicio, $dataFim);
        $contatosAtuais = $this->contato->contarPorPeriodo($dataInicio, $dataFim);

        // Calcula variações percentuais
        return [
            'agendamentos' => $this->calcularVariacao($agendamentosAtuais, $agendamentosAnteriores),
            'orcamentos' => $this->calcularVariacao($orcamentosAtuais, $orcamentosAnteriores),
            'contatos' => $this->calcularVariacao($contatosAtuais, $contatosAnteriores)
        ];
    }

    /**
     * Calcula variação percentual entre dois valores
     */
    private function calcularVariacao(int $atual, int $anterior): array
    {
        // Se não havia dados no período anterior
        if ($anterior == 0) {
            return [
                'percentual' => $atual > 0 ? 100 : 0,
                'diferenca' => $atual,
                'tendencia' => $atual > 0 ? 'up' : 'neutral'
            ];
        }

        // Calcula diferença e percentual
        $diferenca = $atual - $anterior;
        $percentual = round(($diferenca / $anterior) * 100, 1);
        
        // Define tendência (up/down/neutral)
        if ($diferenca > 0) {
            $tendencia = 'up';
        } elseif ($diferenca < 0) {
            $tendencia = 'down';
        } else {
            $tendencia = 'neutral';
        }

        return [
            'percentual' => abs($percentual),
            'diferenca' => abs($diferenca),
            'tendencia' => $tendencia
        ];
    }
}