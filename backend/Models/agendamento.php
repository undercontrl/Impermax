<?php
namespace App\Impermax\Models;
use PDO;
class Agendamento{
    private $id_agendamento;
    private $id_cliente;
    private $data_solicitada;
    private $total_agendamento;
    private $status_agendamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    
    // O construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
    //método de buscar todos os agendamentos não excluídos
    function buscarAgendamentos(){
        $sql = 'SELECT * FROM tbl_agendamento as ag INNER JOIN tbl_usuario as usu ON ag.id_cliente = usu.id_usuario WHERE ag.excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os agendamentos por status
    function buscarAgendamentosPorStatus($status_agendamento){
        $sql = 'SELECT * FROM tbl_agendamento WHERE status_agendamento = :status_agendamento AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':status_agendamento', $status_agendamento);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os agendamentos por data
    function buscarAgendamentosPorData($data_solicitada){
        $sql = 'SELECT * FROM tbl_agendamento WHERE data_solicitada = :data_solicitada AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':data_solicitada', $data_solicitada);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os agendamentos por cliente
    function buscarAgendamentosPorCliente($id_cliente){
        $sql = 'SELECT * FROM tbl_agendamento WHERE id_cliente = :id_cliente AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Método otimizado para trazer o nome do cliente junto ao agendamento
    function buscarAgendamentosComCliente(){
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
    //método de buscar agendamento por id
    function buscarAgendamentoPorId($id_agendamento){
        $sql = 'SELECT * FROM tbl_agendamento WHERE id_agendamento = :id AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id_agendamento);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    //método de inserir agendamento
    function inserirAgendamento($id_cliente, $data_solicitada, $total_agendamento, $status_agendamento){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_agendamento (id_cliente, data_solicitada, total_agendamento, status_agendamento, criado_em) 
        VALUES (:id_cliente, :data_solicitada, :total_agendamento, :status_agendamento, :criado)';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_cliente', $id_cliente);
        $statement->bindParam(':data_solicitada', $data_solicitada);
        $statement->bindParam(':total_agendamento', $total_agendamento);
        $statement->bindParam(':status_agendamento', $status_agendamento);
        $statement->bindParam(':criado', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de atualizar o agendamento
    function atualizarAgendamento($id_agendamento, $id_cliente, $data_solicitada, $total_agendamento, $status_agendamento){
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
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de deletar o agendamento
    function excluirAgendamento($id_agendamento){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_agendamento SET excluido_em = :excluido WHERE id_agendamento = :id_agendamento';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_agendamento', $id_agendamento);
        $statement->bindParam(':excluido', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    // Buscar agendamentos atribuídos a um funcionário específico (ou todos se não houver campo)
    public function buscarAgendamentosPorResponsavel($id_responsavel)
    {
        // Primeiro, verifica se a coluna 'id_responsavel' existe no banco
        $checkColumn = $this->db->query("SHOW COLUMNS FROM tbl_agendamento LIKE 'id_responsavel'");
        $hasResponsavel = $checkColumn->fetch(PDO::FETCH_ASSOC);

        if ($hasResponsavel) {
            // Caso a coluna exista — busca filtrando por responsável
            $sql = 'SELECT ag.*, usu.nome_usuario AS nome_cliente
                    FROM tbl_agendamento AS ag
                    INNER JOIN tbl_usuario AS usu ON ag.id_cliente = usu.id_usuario
                    WHERE ag.id_responsavel = :id_responsavel
                    AND ag.excluido_em IS NULL
                    ORDER BY ag.data_solicitada ASC';

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_responsavel', $id_responsavel);
        } else {
            // Caso a coluna não exista — busca todos os agendamentos ativos
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

    // ====================== DASHBOARD MÉTRICAS ======================

    // Contar agendamentos de hoje
    public function contarAgendamentosDeHoje(): int
    {
        $hoje = date('Y-m-d');
        $sql = "SELECT COUNT(*) FROM tbl_agendamento 
                WHERE DATE(data_solicitada) = :hoje AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':hoje', $hoje);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    // Contar pendências
    public function contarPendencias(): int
    {
        $sql = "SELECT COUNT(*) FROM tbl_agendamento 
                WHERE LOWER(status_agendamento) = 'pendente' 
                AND excluido_em IS NULL";
        return (int) $this->db->query($sql)->fetchColumn();
    }

    // Contar serviços concluídos por mês
    public function contarServicosPorMes(): array
    {
        $sql = "SELECT MONTH(data_solicitada) AS mes, COUNT(*) AS total
                FROM tbl_agendamento
                WHERE LOWER(status_agendamento) IN ('finalizado', 'concluído')
                AND excluido_em IS NULL
                GROUP BY MONTH(data_solicitada)";
        $stmt = $this->db->query($sql);
        $dados = array_fill(1, 12, 0);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dados[(int)$row['mes']] = (int)$row['total'];
        }
        return array_values($dados);
    }

    // Distribuição de status (para gráfico de pizza)
    public function distribuicaoPorStatus(): array
    {
        $sql = "SELECT status_agendamento, COUNT(*) AS total
                FROM tbl_agendamento
                WHERE excluido_em IS NULL
                GROUP BY status_agendamento";
        $stmt = $this->db->query($sql);
        $resultado = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[$row['status_agendamento']] = (int)$row['total'];
        }
        return $resultado;
    }

}