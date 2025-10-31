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
    private $db;
    protected array $usuario;

    public function __construct()
    {
        parent::__construct(['funcionario', 'admin']);
        $this->usuario = $this->getUsuario();
        $this->db = Database::getInstance();
        $this->agendamento = new Agendamento($this->db);
        $this->orcamento = new Orcamento($this->db);
    }

    private function getUsuario(): array
    {
        return [
            'id' => $_SESSION['usuario_id'] ?? 1,
            'nome' => $_SESSION['usuario_nome'] ?? 'Funcionário',
            'email' => $_SESSION['usuario_email'] ?? '',
            'tipo' => $_SESSION['usuario_tipo'] ?? 'funcionario'
        ];
    }

    public function index(): void
    {
        // ============================================
        // MÉTRICAS PRINCIPAIS
        // ============================================
        
        $totalHoje = $this->agendamento->contarAgendamentosDeHoje();
        $proximos3Dias = $this->agendamento->contarProximos3Dias();
        $pendencias = $this->agendamento->contarPendencias();
        $servicosSemana = $this->agendamento->contarServicosDaSemana();
        $orcamentosAndamento = $this->orcamento->contarOrcamentosEmAndamento();
        
        // ============================================
        // AGENDA DO DIA
        // ============================================
        
        $agendaHoje = $this->agendamento->buscarAgendamentosDeHojeDetalhado();
        
        // ============================================
        // PRÓXIMOS AGENDAMENTOS (7 dias)
        // ============================================
        
        $proximosAgendamentos = $this->agendamento->buscarProximosAgendamentos(8);
        
        // ============================================
        // AGENDAMENTOS DA SEMANA (para calendário)
        // ============================================
        
        $agendamentosSemana = $this->agendamento->buscarAgendamentosDaSemana();
        $calendarioSemanal = $this->prepararCalendarioSemanal($agendamentosSemana);
        
        // ============================================
        // ÚLTIMOS ORÇAMENTOS
        // ============================================
        
        $ultimosOrcamentos = $this->buscarUltimosOrcamentos(5);
        
        // ============================================
        // GRÁFICOS
        // ============================================
        
        // Gráfico 1: Serviços por mês (12 meses)
        $graficoServicos = $this->agendamento->contarServicosPorMes();
        
        // Gráfico 2: Distribuição por status
        $graficoStatus = $this->agendamento->distribuicaoPorStatus();
        
        // Gráfico 3: Desempenho semanal (últimas 4 semanas)
        $desempenhoSemanal = $this->agendamento->buscarDesempenhoSemanal();
        
        // ============================================
        // ESTATÍSTICAS RESUMIDAS
        // ============================================
        
        $estatisticas = $this->agendamento->buscarEstatisticasFuncionario();
        
        // ============================================
        // ATIVIDADES RECENTES
        // ============================================
        
        $atividadesRecentes = $this->buscarAtividadesRecentes();
        
        // ============================================
        // RENDERIZA A VIEW
        // ============================================
        
        View::render('funcionario/dashboard/index', [
            // Usuário
            'nomeUsuario' => $this->usuario['nome'],
            'emailUsuario' => $this->usuario['email'],
            'tipoUsuario' => $this->usuario['tipo'],
            
            // Métricas principais
            'totalHoje' => $totalHoje,
            'proximos3Dias' => $proximos3Dias,
            'pendencias' => $pendencias,
            'servicosSemana' => $servicosSemana,
            'orcamentosAndamento' => $orcamentosAndamento,
            'servicosConcluidos' => $this->agendamento->contarServicosConcluidos(),
            
            // Agenda e próximos
            'agendaHoje' => $agendaHoje,
            'proximosAgendamentos' => $proximosAgendamentos,
            'calendarioSemanal' => $calendarioSemanal,
            
            // Orçamentos
            'ultimosOrcamentos' => $ultimosOrcamentos,
            
            // Gráficos (JSON para JavaScript)
            'graficoServicos' => json_encode($graficoServicos),
            'graficoStatus' => json_encode($graficoStatus),
            'desempenhoSemanal' => json_encode($desempenhoSemanal),
            
            // Estatísticas
            'estatisticas' => $estatisticas,
            
            // Atividades
            'atividadesRecentes' => $atividadesRecentes,
            
            // Data/Hora
            'dataAtual' => date('d/m/Y'),
            'horaAtual' => date('H:i'),
            'diaSemana' => $this->getDiaSemanaPortugues(),
            'saudacao' => $this->getSaudacao()
        ]);
    }

    // ============================================
    // MÉTODOS AUXILIARES
    // ============================================

    /**
     * Prepara calendário semanal (Segunda a Domingo)
     */
    private function prepararCalendarioSemanal(array $agendamentos): array
    {
        // Inicializa array com dias da semana
        $calendario = [];
        
        // Pega o início da semana (segunda-feira)
        $inicioSemana = date('Y-m-d', strtotime('monday this week'));
        
        // Cria 7 dias (Segunda a Domingo)
        for ($i = 0; $i < 7; $i++) {
            $data = date('Y-m-d', strtotime("$inicioSemana +$i days"));
            $diaSemana = $this->getDiaSemanaAbreviado($data);
            
            $calendario[$data] = [
                'dia' => date('d', strtotime($data)),
                'diaSemana' => $diaSemana,
                'agendamentos' => []
            ];
        }
        
        // Distribui agendamentos pelos dias
        foreach ($agendamentos as $ag) {
            $dataAg = date('Y-m-d', strtotime($ag['data_solicitada']));
            if (isset($calendario[$dataAg])) {
                $calendario[$dataAg]['agendamentos'][] = $ag;
            }
        }
        
        return $calendario;
    }

    /**
     * Busca últimos orçamentos
     */
    private function buscarUltimosOrcamentos(int $limite): array
    {
        $todosOrcamentos = $this->orcamento->buscarOrcamentosComCliente();
        
        // Ordena por data de criação (mais recentes primeiro)
        usort($todosOrcamentos, function($a, $b) {
            return strtotime($b['criado_em'] ?? '0') - strtotime($a['criado_em'] ?? '0');
        });
        
        return array_slice($todosOrcamentos, 0, $limite);
    }

    /**
     * Busca atividades recentes do sistema
     */
    private function buscarAtividadesRecentes(): array
    {
        $atividades = [];
        
        // Busca últimos agendamentos atualizados
        $ultimosAtualizados = $this->agendamento->buscarUltimosAtualizados(3);
        
        foreach ($ultimosAtualizados as $ag) {
            $atividades[] = [
                'tipo' => 'agendamento',
                'icone' => 'calendar-check',
                'cor' => 'success',
                'titulo' => 'Agendamento atualizado',
                'descricao' => "Cliente: {$ag['nome_cliente']}",
                'tempo' => $this->tempoDecorrido($ag['atualizado_em'])
            ];
        }
        
        // Busca últimos orçamentos
        $ultimosOrc = $this->buscarUltimosOrcamentos(2);
        
        foreach ($ultimosOrc as $orc) {
            $atividades[] = [
                'tipo' => 'orcamento',
                'icone' => 'file-earmark-text',
                'cor' => 'info',
                'titulo' => 'Novo orçamento',
                'descricao' => "Cliente: {$orc['cliente_nome']}",
                'tempo' => $this->tempoDecorrido($orc['criado_em'] ?? date('Y-m-d H:i:s'))
            ];
        }
        
        // Ordena por tempo (mais recentes primeiro)
        usort($atividades, function($a, $b) {
            return strcmp($a['tempo'], $b['tempo']);
        });
        
        return array_slice($atividades, 0, 5);
    }

    /**
     * Retorna tempo decorrido em texto
     */
    private function tempoDecorrido(?string $dataHora): string
    {
        if (!$dataHora) return 'há alguns instantes';
        
        $agora = time();
        $tempo = strtotime($dataHora);
        $diferenca = $agora - $tempo;
        
        if ($diferenca < 60) {
            return 'há alguns instantes';
        } elseif ($diferenca < 3600) {
            $minutos = floor($diferenca / 60);
            return "há {$minutos} " . ($minutos == 1 ? 'minuto' : 'minutos');
        } elseif ($diferenca < 86400) {
            $horas = floor($diferenca / 3600);
            return "há {$horas} " . ($horas == 1 ? 'hora' : 'horas');
        } else {
            $dias = floor($diferenca / 86400);
            return "há {$dias} " . ($dias == 1 ? 'dia' : 'dias');
        }
    }

    /**
     * Retorna dia da semana em português
     */
    private function getDiaSemanaPortugues(): string
    {
        $dias = [
            'Sunday' => 'Domingo',
            'Monday' => 'Segunda-feira',
            'Tuesday' => 'Terça-feira',
            'Wednesday' => 'Quarta-feira',
            'Thursday' => 'Quinta-feira',
            'Friday' => 'Sexta-feira',
            'Saturday' => 'Sábado'
        ];
        
        $diaIngles = date('l');
        return $dias[$diaIngles] ?? $diaIngles;
    }

    /**
     * Retorna dia da semana abreviado
     */
    private function getDiaSemanaAbreviado(string $data): string
    {
        $dias = [
            'Sunday' => 'Dom',
            'Monday' => 'Seg',
            'Tuesday' => 'Ter',
            'Wednesday' => 'Qua',
            'Thursday' => 'Qui',
            'Friday' => 'Sex',
            'Saturday' => 'Sáb'
        ];
        
        $diaIngles = date('l', strtotime($data));
        return $dias[$diaIngles] ?? $diaIngles;
    }

    /**
     * Retorna saudação baseada na hora
     */
    private function getSaudacao(): string
    {
        $hora = (int)date('H');
        
        if ($hora >= 6 && $hora < 12) {
            return 'Bom dia';
        } elseif ($hora >= 12 && $hora < 18) {
            return 'Boa tarde';
        } else {
            return 'Boa noite';
        }
    }
}