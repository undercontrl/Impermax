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
        // Dados para o dashboard
        $periodo = $_GET['periodo'] ?? 'mes';
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
            default:
                $dataInicio = date('Y-m-d 00:00:00', strtotime('-1 month'));
                $periodoTexto = 'Último Mês';
                $periodo = 'mes';
                break;
        }

        // Buscar dados
        $usuarios = $this->usuario->buscarUsuarios() ?? [];
        $totalAgendamentos = $this->agendamento->contarPorPeriodo($dataInicio, $dataFim);
        $totalOrcamentos = $this->orcamento->contarPorPeriodo($dataInicio, $dataFim);
        $totalContatos = $this->contato->contarPorPeriodo($dataInicio, $dataFim);

        // Estatísticas
        $estatisticas = $this->calcularEstatisticas($dataInicio, $dataFim, $periodo);
        
        // Adicionar receita às estatísticas
        $estatisticas['receita'] = $this->calcularReceitaMensal();

        // Gráficos
        $graficoTendencia = $this->prepararGraficoTendencia();
        $graficoStatusAdmin = $this->agendamento->buscarDistribuicaoPorStatus($dataInicio, $dataFim);

        // Atividades
        $atividadesRecentes = $this->buscarAtividadesRecentes();
        
        // NOVOS: Calendário e Agenda
        $calendarioSemanal = $this->obterCalendarioSemanal();
        $agendamentosHoje = $this->obterAgendamentosHoje();

        // Renderizar
        View::render('admin/dashboard/index', [
                'nomeUsuario' => $this->session->get('usuario_nome') ?? 'Admin',
                'tipo' => $this->session->get('usuario_tipo') ?? 'admin',
                'usuarios' => $usuarios,
                'totalUsuarios' => count($usuarios),
                'totalAgendamentos' => $totalAgendamentos,
                'totalOrcamentos' => $totalOrcamentos,
                'totalContatos' => $totalContatos,
                'periodo' => $periodo,
                'periodoTexto' => $periodoTexto,
                'dataInicio' => date('d/m/Y', strtotime($dataInicio)),
                'dataFim' => date('d/m/Y', strtotime($dataFim)),
                'estatisticas' => $estatisticas,
                'graficoTendencia' => json_encode($graficoTendencia),
                'graficoStatusAdmin' => json_encode($graficoStatusAdmin),
                'atividadesRecentes' => $atividadesRecentes,
                'calendarioSemanal' => $calendarioSemanal,
                'agendamentosHoje' => $agendamentosHoje
            ]);
        }

    // Exemplo de função para calcular estatísticas
    private function calcularEstatisticas($dataInicio, $dataFim, $periodo) {
        // Você deve definir como obter $atual e $anterior
        $atual = $this->agendamento->contarPorPeriodo($dataInicio, $dataFim);
        // Exemplo: calcula $anterior com base no período
        switch ($periodo) {
            case '3meses':
                $dataInicioAnterior = date('Y-m-d 00:00:00', strtotime('-6 months'));
                $dataFimAnterior = date('Y-m-d 23:59:59', strtotime('-3 months'));
                break;
            case 'ano':
                $dataInicioAnterior = date('Y-m-d 00:00:00', strtotime('-2 year'));
                $dataFimAnterior = date('Y-m-d 23:59:59', strtotime('-1 year'));
                break;
            default:
                $dataInicioAnterior = date('Y-m-d 00:00:00', strtotime('-2 month'));
                $dataFimAnterior = date('Y-m-d 23:59:59', strtotime('-1 month'));
                break;
        }
        $anterior = $this->agendamento->contarPorPeriodo($dataInicioAnterior, $dataFimAnterior);

        // Calcula diferença e percentual
        $diferenca = $atual - $anterior;
        $percentual = $anterior != 0 ? round(($diferenca / $anterior) * 100, 1) : 0;
        
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

    // Adiciona o método prepararGraficoTendencia
    private function prepararGraficoTendencia(): array
    {
        $dados = [];
        
        // Últimos 6 meses
        for ($i = 5; $i >= 0; $i--) {
            $dataFim = date('Y-m-d 23:59:59', strtotime("-{$i} months"));
            $dataInicio = date('Y-m-01 00:00:00', strtotime("-{$i} months"));
            
            // Formatar mês em português
            $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
            $mesNum = (int)date('n', strtotime($dataInicio)) - 1;
            $mes = $meses[$mesNum];

            $dados[] = [
                'mes' => $mes,
                'agendamentos' => (int)$this->agendamento->contarPorPeriodo($dataInicio, $dataFim),
                'orcamentos' => (int)$this->orcamento->contarPorPeriodo($dataInicio, $dataFim),
                'contatos' => (int)$this->contato->contarPorPeriodo($dataInicio, $dataFim)
            ];
        }

        return $dados;
    }

    // Implementa o método buscarAtividadesRecentes
    private function buscarAtividadesRecentes() {
        // Exemplo: busca os últimos 10 agendamentos
        $atividades = $this->agendamento->buscarRecentes(10);
        // Se necessário, pode adicionar outros tipos de atividades
        return $atividades;
    }
    
    // Obter calendário semanal (7 dias a partir de hoje)
    private function obterCalendarioSemanal(): array
    {
        $calendario = [];
        $hoje = date('Y-m-d');
        
        // Gerar 7 dias a partir de hoje
        for ($i = 0; $i < 7; $i++) {
            $data = date('Y-m-d', strtotime("+{$i} days"));
            $diaSemana = $this->obterDiaSemanaAbreviado($data);
            $dia = date('d', strtotime($data));
            
            // Buscar agendamentos para este dia
            $agendamentos = $this->agendamento->buscarAgendamentosPorData($data);
            
            $calendario[$data] = [
                'diaSemana' => $diaSemana,
                'dia' => $dia,
                'agendamentos' => $agendamentos ?? []
            ];
        }
        
        return $calendario;
    }
    
    // Obter agendamentos de hoje
    private function obterAgendamentosHoje(): array
    {
        $agendamentos = $this->agendamento->buscarAgendamentosHoje();
        return array_slice($agendamentos ?? [], 0, 10); // Limitar a 10 itens
    }
    
    // Calcular receita mensal
    private function calcularReceitaMensal(): array
    {
        // Mês atual
        $mesAtual = date('Y-m-01 00:00:00');
        $mesFim = date('Y-m-t 23:59:59');
        $receitaAtual = $this->orcamento->calcularReceitaPorPeriodo($mesAtual, $mesFim);
        
        // Mês anterior
        $mesAnteriorInicio = date('Y-m-01 00:00:00', strtotime('-1 month'));
        $mesAnteriorFim = date('Y-m-t 23:59:59', strtotime('-1 month'));
        $receitaAnterior = $this->orcamento->calcularReceitaPorPeriodo($mesAnteriorInicio, $mesAnteriorFim);
        
        // Calcular diferença e percentual
        $diferenca = $receitaAtual - $receitaAnterior;
        $percentual = $receitaAnterior != 0 ? round(($diferenca / $receitaAnterior) * 100, 1) : 0;
        
        // Determinar tendência
        if ($diferenca > 0) {
            $tendencia = 'up';
        } elseif ($diferenca < 0) {
            $tendencia = 'down';
        } else {
            $tendencia = 'neutral';
        }
        
        return [
            'total' => $receitaAtual,
            'percentual' => abs($percentual),
            'tendencia' => $tendencia
        ];
    }
    
    // Helper para obter dia da semana abreviado em português
    private function obterDiaSemanaAbreviado(string $data): string
    {
        $diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
        $diaSemanaNum = date('w', strtotime($data));
        return $diasSemana[$diaSemanaNum];
    }
}