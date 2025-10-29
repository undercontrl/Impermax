<?php
namespace App\Impermax\Models;
use PDO;

class Agendamento
{
    private $id_agendamento;
    private $id_cliente;
    private $data_solicitada;
    private $total_agendamento;
    private $status_agendamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    // Método otimizado para buscar agendamentos com filtros, ordenação e paginação
    function buscarAgendamentosFiltrados($busca = '', $status = '', $periodo = '', $ordemCampo = 'data_solicitada', $ordemDirecao = 'DESC', $limite = 10, $offset = 0)
    {
        $sql = 'SELECT 
                    ag.id_agendamento,
                    ag.id_cliente,
                    usu.nome_usuario AS nome_cliente,
                    usu.email_usuario AS email_cliente,
                    ag.data_solicitada,
                    ag.total_agendamento,
                    ag.status_agendamento,
                    ag.criado_em
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL';
        
        $params = [];
        
        // Filtro de busca
        if (!empty($busca)) {
            $sql .= ' AND (usu.nome_usuario LIKE :busca OR ag.id_agendamento LIKE :busca OR usu.email_usuario LIKE :busca)';
            $params[':busca'] = "%$busca%";
        }
        
        // Filtro de status
        if (!empty($status)) {
            $sql .= ' AND ag.status_agendamento = :status';
            $params[':status'] = $status;
        }
        
        // Filtro de período
        if (!empty($periodo)) {
            switch ($periodo) {
                case 'hoje':
                    $sql .= ' AND DATE(ag.data_solicitada) = CURDATE()';
                    break;
                case 'semana':
                    $sql .= ' AND YEARWEEK(ag.data_solicitada, 1) = YEARWEEK(CURDATE(), 1)';
                    break;
                case 'mes':
                    $sql .= ' AND MONTH(ag.data_solicitada) = MONTH(CURDATE()) AND YEAR(ag.data_solicitada) = YEAR(CURDATE())';
                    break;
            }
        }
        
        // Ordenação
        $camposValidos = ['id_agendamento', 'nome_cliente', 'data_solicitada', 'total_agendamento', 'status_agendamento'];
        if (!in_array($ordemCampo, $camposValidos)) {
            $ordemCampo = 'data_solicitada';
        }
        
        $ordemDirecao = strtoupper($ordemDirecao) === 'ASC' ? 'ASC' : 'DESC';
        $sql .= " ORDER BY $ordemCampo $ordemDirecao";
        
        // Paginação
        $sql .= ' LIMIT :limite OFFSET :offset';
        
        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->bindValue(':limite', $limite, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Contar total de agendamentos filtrados (para paginação)
    function contarAgendamentosFiltrados($busca = '', $status = '', $periodo = '')
    {
        $sql = 'SELECT COUNT(*) as total
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL';
        
        $params = [];
        
        if (!empty($busca)) {
            $sql .= ' AND (usu.nome_usuario LIKE :busca OR ag.id_agendamento LIKE :busca OR usu.email_usuario LIKE :busca)';
            $params[':busca'] = "%$busca%";
        }
        
        if (!empty($status)) {
            $sql .= ' AND ag.status_agendamento = :status';
            $params[':status'] = $status;
        }
        
        if (!empty($periodo)) {
            switch ($periodo) {
                case 'hoje':
                    $sql .= ' AND DATE(ag.data_solicitada) = CURDATE()';
                    break;
                case 'semana':
                    $sql .= ' AND YEARWEEK(ag.data_solicitada, 1) = YEARWEEK(CURDATE(), 1)';
                    break;
                case 'mes':
                    $sql .= ' AND MONTH(ag.data_solicitada) = MONTH(CURDATE()) AND YEAR(ag.data_solicitada) = YEAR(CURDATE())';
                    break;
            }
        }
        
        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    }
    
    // Buscar estatísticas dos agendamentos
    function buscarEstatisticas($busca = '', $status = '', $periodo = '')
    {
        $sql = 'SELECT 
                    COUNT(CASE WHEN ag.status_agendamento = "pendente" THEN 1 END) as pendente,
                    COUNT(CASE WHEN ag.status_agendamento = "agendada" THEN 1 END) as agendada,
                    COUNT(CASE WHEN ag.status_agendamento = "realizada" THEN 1 END) as realizada,
                    COUNT(CASE WHEN ag.status_agendamento = "cancelada" THEN 1 END) as cancelada,
                    SUM(CASE WHEN ag.status_agendamento = "realizada" THEN ag.total_agendamento ELSE 0 END) as receita_total
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL';
        
        $params = [];
        
        if (!empty($busca)) {
            $sql .= ' AND (usu.nome_usuario LIKE :busca OR ag.id_agendamento LIKE :busca OR usu.email_usuario LIKE :busca)';
            $params[':busca'] = "%$busca%";
        }
        
        if (!empty($status)) {
            $sql .= ' AND ag.status_agendamento = :status';
            $params[':status'] = $status;
        }
        
        if (!empty($periodo)) {
            switch ($periodo) {
                case 'hoje':
                    $sql .= ' AND DATE(ag.data_solicitada) = CURDATE()';
                    break;
                case 'semana':
                    $sql .= ' AND YEARWEEK(ag.data_solicitada, 1) = YEARWEEK(CURDATE(), 1)';
                    break;
                case 'mes':
                    $sql .= ' AND MONTH(ag.data_solicitada) = MONTH(CURDATE()) AND YEAR(ag.data_solicitada) = YEAR(CURDATE())';
                    break;
            }
        }
        
        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    // Métodos originais mantidos
    function buscarAgendamentos()
    {
        $sql = 'SELECT * FROM tbl_agendamento as ag INNER JOIN tbl_usuario as usu ON ag.id_cliente = usu.id_usuario WHERE ag.excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function buscarAgendamentosPorStatus($status_agendamento)
    {
        $sql = 'SELECT * FROM tbl_agendamento WHERE status_agendamento = :status_agendamento AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':status_agendamento', $status_agendamento);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function buscarAgendamentosPorData($data_solicitada)
    {
        $sql = 'SELECT * FROM tbl_agendamento WHERE data_solicitada = :data_solicitada AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':data_solicitada', $data_solicitada);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function buscarAgendamentosPorCliente($id_cliente)
    {
        $sql = 'SELECT * FROM tbl_agendamento WHERE id_cliente = :id_cliente AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function buscarAgendamentosComCliente()
    {
        $sql = 'SELECT 
                    ag.id_agendamento,
                    ag.id_cliente,
                    usu.nome_usuario AS nome_cliente,
                    ag.data_solicitada,
                    ag.total_agendamento,
                    ag.status_agendamento
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function buscarAgendamentoPorId($id_agendamento)
    {
        $sql = 'SELECT * FROM tbl_agendamento WHERE id_agendamento = :id AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id_agendamento);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    function inserirAgendamento($id_cliente, $data_solicitada, $total_agendamento, $status_agendamento)
    {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_agendamento (id_cliente, data_solicitada, total_agendamento, status_agendamento, criado_em) 
        VALUES (:id_cliente, :data_solicitada, :total_agendamento, :status_agendamento, :criado)';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->bindParam(':data_solicitada', $data_solicitada);
        $statement->bindParam(':total_agendamento', $total_agendamento);
        $statement->bindParam(':status_agendamento', $status_agendamento);
        $statement->bindParam(':criado', $dataAtual);
        return $statement->execute();
    }
    
    function atualizarAgendamento($id_agendamento, $id_cliente, $data_solicitada, $total_agendamento, $status_agendamento)
    {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_agendamento SET id_cliente = :id_cliente, data_solicitada = :data_solicitada, 
        total_agendamento = :total_agendamento, status_agendamento = :status_agendamento, atualizado_em = :atualizado 
        WHERE id_agendamento = :id_agendamento';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_agendamento', $id_agendamento);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->bindParam(':data_solicitada', $data_solicitada);
        $statement->bindParam(':total_agendamento', $total_agendamento);
        $statement->bindParam(':status_agendamento', $status_agendamento);
        $statement->bindParam(':atualizado', $dataAtual);
        return $statement->execute();
    }
    
    function excluirAgendamento($id_agendamento)
    {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_agendamento SET excluido_em = :excluido WHERE id_agendamento = :id_agendamento';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_agendamento', $id_agendamento);
        $statement->bindParam(':excluido', $dataAtual);
        return $statement->execute();
    }
    
    public function buscarAgendamentosPorResponsavel($id_responsavel)
    {
        $checkColumn = $this->db->query("SHOW COLUMNS FROM tbl_agendamento LIKE 'id_responsavel'");
        $hasResponsavel = $checkColumn->fetch(PDO::FETCH_ASSOC);

        if ($hasResponsavel) {
            $sql = 'SELECT ag.*, usu.nome_usuario AS nome_cliente
                    FROM tbl_agendamento AS ag
                    INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                    WHERE ag.id_responsavel = :id_responsavel
                    AND ag.excluido_em IS NULL
                    ORDER BY ag.data_solicitada ASC';

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_responsavel', $id_responsavel);
        } else {
            $sql = 'SELECT ag.*, usu.nome_usuario AS nome_cliente
                    FROM tbl_agendamento AS ag
                    INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                    WHERE ag.excluido_em IS NULL
                    ORDER BY ag.data_solicitada ASC';

            $stmt = $this->db->prepare($sql);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // ==================== MÉTODOS PARA DASHBOARD ====================
    
    // Contar agendamentos por período com datas específicas
    public function contarPorPeriodo($dataInicio, $dataFim)
    {
        $sql = 'SELECT COUNT(*) as total 
                FROM tbl_agendamento 
                WHERE excluido_em IS NULL
                AND data_solicitada BETWEEN :dataInicio AND :dataFim';
        
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':dataInicio', $dataInicio);
        $statement->bindParam(':dataFim', $dataFim);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    }
    
    // Buscar agendamentos agrupados por mês
    public function buscarPorMes($dataInicio, $dataFim)
    {
        $sql = 'SELECT 
                    DATE_FORMAT(data_solicitada, "%Y-%m") as mes,
                    DATE_FORMAT(data_solicitada, "%b/%Y") as mes_formatado,
                    COUNT(*) as total
                FROM tbl_agendamento
                WHERE excluido_em IS NULL
                AND data_solicitada BETWEEN :dataInicio AND :dataFim
                GROUP BY DATE_FORMAT(data_solicitada, "%Y-%m")
                ORDER BY mes ASC';
        
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':dataInicio', $dataInicio);
        $statement->bindParam(':dataFim', $dataFim);
        $statement->execute();
        
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        // Formatar para o gráfico
        $dados = [];
        foreach ($resultados as $row) {
            $dados[] = [
                'mes' => $row['mes_formatado'],
                'total' => (int)$row['total']
            ];
        }
        
        return $dados;
    }
    
    // Buscar distribuição de status por período
    public function buscarDistribuicaoPorStatus($dataInicio, $dataFim)
    {
        $sql = 'SELECT 
                    status_agendamento,
                    COUNT(*) as total
                FROM tbl_agendamento
                WHERE excluido_em IS NULL
                AND data_solicitada BETWEEN :dataInicio AND :dataFim
                GROUP BY status_agendamento
                ORDER BY total DESC';
        
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':dataInicio', $dataInicio);
        $statement->bindParam(':dataFim', $dataFim);
        $statement->execute();
        
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        // Formatar para o gráfico
        $dados = [];
        foreach ($resultados as $row) {
            $dados[] = [
                'status' => ucfirst($row['status_agendamento']),
                'total' => (int)$row['total']
            ];
        }
        
        return $dados;
    }
    
    // Contar total de agendamentos (geral)
    public function contarTotal()
    {
        $sql = 'SELECT COUNT(*) as total FROM tbl_agendamento WHERE excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    }
    
    // Calcular receita total por período
    public function calcularReceitaPorPeriodo($periodo = 'mes')
    {
        $sql = 'SELECT SUM(total_agendamento) as receita 
                FROM tbl_agendamento 
                WHERE excluido_em IS NULL 
                AND status_agendamento = "realizada"';
        
        switch ($periodo) {
            case 'hoje':
                $sql .= ' AND DATE(data_solicitada) = CURDATE()';
                break;
            case 'semana':
                $sql .= ' AND YEARWEEK(data_solicitada, 1) = YEARWEEK(CURDATE(), 1)';
                break;
            case 'mes':
                $sql .= ' AND MONTH(data_solicitada) = MONTH(CURDATE()) AND YEAR(data_solicitada) = YEAR(CURDATE())';
                break;
            case 'ano':
                $sql .= ' AND YEAR(data_solicitada) = YEAR(CURDATE())';
                break;
        }
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $result['receita'] ?? 0;
    }
    
    // Calcular receita total (geral)
    public function calcularReceitaTotal()
    {
        $sql = 'SELECT SUM(total_agendamento) as receita 
                FROM tbl_agendamento 
                WHERE excluido_em IS NULL 
                AND status_agendamento = "realizada"';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $result['receita'] ?? 0;
    }
    
    // Buscar agendamentos recentes (últimos X)
    public function buscarRecentes($limite = 5)
    {
        $sql = 'SELECT 
                    ag.id_agendamento,
                    ag.id_cliente,
                    usu.nome_usuario AS nome_cliente,
                    ag.data_solicitada,
                    ag.total_agendamento,
                    ag.status_agendamento,
                    ag.criado_em
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL
                ORDER BY ag.criado_em DESC
                LIMIT :limite';
        
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':limite', $limite, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Buscar próximos agendamentos (agendados para o futuro)
    public function buscarProximos($limite = 5)
    {
        $sql = 'SELECT 
                    ag.id_agendamento,
                    ag.id_cliente,
                    usu.nome_usuario AS nome_cliente,
                    ag.data_solicitada,
                    ag.total_agendamento,
                    ag.status_agendamento
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL
                AND ag.status_agendamento IN ("pendente", "agendada")
                AND ag.data_solicitada >= CURDATE()
                ORDER BY ag.data_solicitada ASC
                LIMIT :limite';
        
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':limite', $limite, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Buscar dados para gráfico por mês
    public function buscarDadosGraficoMensal($ano = null)
    {
        if ($ano === null) {
            $ano = date('Y');
        }
        
        $sql = 'SELECT 
                    MONTH(data_solicitada) as mes,
                    COUNT(*) as total,
                    SUM(CASE WHEN status_agendamento = "realizada" THEN total_agendamento ELSE 0 END) as receita
                FROM tbl_agendamento
                WHERE excluido_em IS NULL
                AND YEAR(data_solicitada) = :ano
                GROUP BY MONTH(data_solicitada)
                ORDER BY mes ASC';
        
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':ano', $ano, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Buscar estatísticas completas para dashboard
    public function buscarEstatisticasDashboard()
    {
        $sql = 'SELECT 
                    COUNT(*) as total_geral,
                    COUNT(CASE WHEN status_agendamento = "pendente" THEN 1 END) as total_pendente,
                    COUNT(CASE WHEN status_agendamento = "agendada" THEN 1 END) as total_agendada,
                    COUNT(CASE WHEN status_agendamento = "realizada" THEN 1 END) as total_realizada,
                    COUNT(CASE WHEN status_agendamento = "cancelada" THEN 1 END) as total_cancelada,
                    SUM(CASE WHEN status_agendamento = "realizada" THEN total_agendamento ELSE 0 END) as receita_total,
                    COUNT(CASE WHEN DATE(data_solicitada) = CURDATE() THEN 1 END) as total_hoje,
                    COUNT(CASE WHEN YEARWEEK(data_solicitada, 1) = YEARWEEK(CURDATE(), 1) THEN 1 END) as total_semana,
                    COUNT(CASE WHEN MONTH(data_solicitada) = MONTH(CURDATE()) AND YEAR(data_solicitada) = YEAR(CURDATE()) THEN 1 END) as total_mes
                FROM tbl_agendamento
                WHERE excluido_em IS NULL';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    // Buscar agendamentos do dia
    public function buscarAgendamentosHoje()
    {
        $sql = 'SELECT 
                    ag.id_agendamento,
                    ag.id_cliente,
                    usu.nome_usuario AS nome_cliente,
                    ag.data_solicitada,
                    ag.total_agendamento,
                    ag.status_agendamento
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL
                AND DATE(ag.data_solicitada) = CURDATE()
                ORDER BY ag.data_solicitada ASC';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarAgendamentoComClienteCompleto($id)
    {
        $sql = "SELECT 
                    ag.*, 
                    usu.*
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu 
                    ON ag.id_cliente = usu.id_usuario
                WHERE ag.id_agendamento = :id
                AND ag.excluido_em IS NULL";

        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Conta agendamentos de hoje
     */
    public function contarAgendamentosDeHoje(): int
    {
        $sql = 'SELECT COUNT(*) as total 
                FROM tbl_agendamento 
                WHERE excluido_em IS NULL
                AND DATE(data_solicitada) = CURDATE()';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return (int)($result['total'] ?? 0);
    }

    /**
     * Conta agendamentos dos próximos 3 dias
     */
    public function contarProximos3Dias(): int
    {
        $sql = 'SELECT COUNT(*) as total 
                FROM tbl_agendamento 
                WHERE excluido_em IS NULL
                AND DATE(data_solicitada) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)
                AND status_agendamento IN ("pendente", "agendada")';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return (int)($result['total'] ?? 0);
    }

    /**
     * Conta pendências (status pendente)
     */
    public function contarPendencias(): int
    {
        $sql = 'SELECT COUNT(*) as total 
                FROM tbl_agendamento 
                WHERE excluido_em IS NULL
                AND status_agendamento = "pendente"';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return (int)($result['total'] ?? 0);
    }

    /**
     * Conta serviços da semana atual
     */
    public function contarServicosDaSemana(): int
    {
        $sql = 'SELECT COUNT(*) as total 
                FROM tbl_agendamento 
                WHERE excluido_em IS NULL
                AND YEARWEEK(data_solicitada, 1) = YEARWEEK(CURDATE(), 1)';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return (int)($result['total'] ?? 0);
    }

    /**
     * Conta serviços concluídos (realizados)
     */
    public function contarServicosConcluidos(): int
    {
        $sql = 'SELECT COUNT(*) as total 
                FROM tbl_agendamento 
                WHERE excluido_em IS NULL
                AND status_agendamento = "realizada"';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return (int)($result['total'] ?? 0);
    }

    /**
     * Busca serviços concluídos por mês do ano atual
     * Retorna array com 12 posições (Jan a Dez)
     */
    public function contarServicosPorMes(): array
    {
        $anoAtual = date('Y');
        
        $sql = 'SELECT 
                    MONTH(data_solicitada) as mes,
                    COUNT(*) as total
                FROM tbl_agendamento
                WHERE excluido_em IS NULL
                AND status_agendamento = "realizada"
                AND YEAR(data_solicitada) = :ano
                GROUP BY MONTH(data_solicitada)
                ORDER BY mes ASC';
        
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':ano', $anoAtual, PDO::PARAM_INT);
        $statement->execute();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        // Inicializa array com 12 meses zerados
        $dados = array_fill(0, 12, 0);
        
        // Preenche com os dados reais
        foreach ($resultados as $row) {
            $mesIndex = (int)$row['mes'] - 1; // Janeiro = 0
            $dados[$mesIndex] = (int)$row['total'];
        }
        
        return $dados;
    }

    /**
     * Busca distribuição de status (todos os agendamentos)
     * Retorna objeto para o gráfico de pizza
     */
    public function distribuicaoPorStatus(): array
    {
        $sql = 'SELECT 
                    status_agendamento,
                    COUNT(*) as total
                FROM tbl_agendamento
                WHERE excluido_em IS NULL
                GROUP BY status_agendamento
                ORDER BY total DESC';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        // Formata para objeto {status: total}
        $dados = [];
        foreach ($resultados as $row) {
            $status = ucfirst($row['status_agendamento']);
            $dados[$status] = (int)$row['total'];
        }
        
        return $dados;
    }

    /**
     * Busca agendamentos de hoje com detalhes
     */
    public function buscarAgendamentosDeHojeDetalhado(): array
    {
        $sql = 'SELECT 
                    ag.id_agendamento,
                    ag.id_cliente,
                    ag.data_solicitada,
                    ag.total_agendamento,
                    ag.status_agendamento,
                    usu.nome_usuario AS nome_cliente,
                    usu.email_usuario AS email_cliente
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL
                AND DATE(ag.data_solicitada) = CURDATE()
                ORDER BY ag.data_solicitada ASC';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca próximos agendamentos (próximos 7 dias)
     */
    public function buscarProximosAgendamentos(int $limite = 10): array
    {
        $sql = 'SELECT 
                    ag.id_agendamento,
                    ag.id_cliente,
                    ag.data_solicitada,
                    ag.total_agendamento,
                    ag.status_agendamento,
                    usu.nome_usuario AS nome_cliente,
                    usu.email_usuario AS email_cliente
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL
                AND ag.data_solicitada BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                AND ag.status_agendamento IN ("pendente", "agendada")
                ORDER BY ag.data_solicitada ASC
                LIMIT :limite';
        
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':limite', $limite, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca agendamentos da semana atual
     */
    public function buscarAgendamentosDaSemana(): array
    {
        $sql = 'SELECT 
                    ag.id_agendamento,
                    ag.id_cliente,
                    ag.data_solicitada,
                    ag.total_agendamento,
                    ag.status_agendamento,
                    usu.nome_usuario AS nome_cliente
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL
                AND YEARWEEK(ag.data_solicitada, 1) = YEARWEEK(CURDATE(), 1)
                ORDER BY ag.data_solicitada ASC';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca estatísticas resumidas para o funcionário
     */
    public function buscarEstatisticasFuncionario(): array
    {
        $sql = 'SELECT 
                    COUNT(*) as total_geral,
                    COUNT(CASE WHEN DATE(data_solicitada) = CURDATE() THEN 1 END) as hoje,
                    COUNT(CASE WHEN YEARWEEK(data_solicitada, 1) = YEARWEEK(CURDATE(), 1) THEN 1 END) as semana,
                    COUNT(CASE WHEN status_agendamento = "pendente" THEN 1 END) as pendentes,
                    COUNT(CASE WHEN status_agendamento = "realizada" THEN 1 END) as concluidos,
                    COUNT(CASE WHEN DATE(data_solicitada) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 DAY) 
                        AND status_agendamento IN ("pendente", "agendada") THEN 1 END) as proximos_3_dias
                FROM tbl_agendamento
                WHERE excluido_em IS NULL';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Busca desempenho semanal (últimas 4 semanas)
     */
    public function buscarDesempenhoSemanal(): array
    {
        $sql = 'SELECT 
                    CONCAT("Semana ", WEEK(data_solicitada)) as semana,
                    COUNT(*) as total
                FROM tbl_agendamento
                WHERE excluido_em IS NULL
                AND status_agendamento = "realizada"
                AND data_solicitada >= DATE_SUB(CURDATE(), INTERVAL 4 WEEK)
                GROUP BY WEEK(data_solicitada)
                ORDER BY WEEK(data_solicitada) ASC';
        
        $statement = $this->db->prepare($sql);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca últimos agendamentos atualizados
     */
    public function buscarUltimosAtualizados(int $limite = 5): array
    {
        $sql = 'SELECT 
                    ag.id_agendamento,
                    ag.id_cliente,
                    ag.data_solicitada,
                    ag.status_agendamento,
                    ag.atualizado_em,
                    usu.nome_usuario AS nome_cliente
                FROM tbl_agendamento AS ag
                INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                WHERE ag.excluido_em IS NULL
                AND ag.atualizado_em IS NOT NULL
                ORDER BY ag.atualizado_em DESC
                LIMIT :limite';
        
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':limite', $limite, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


}