<?php
namespace App\Impermax\Models;
use PDO;
class Usuario{
    private $id_usuario;
    private $nome_usuario;
    private $email_usuario;
    private $senha_usuario;
    private $tipo_usuario;
    private $status_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
   public function __construct($db) {
        $this->db = $db;
    }

    // ✅ LISTAR TODOS
    public function buscarUsuarios() {
    $sql = 'SELECT * FROM tbl_usuario WHERE excluido_em IS NULL ';
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // ✅ BUSCAR 1 POR ID (SINGULAR - CORRETO)
    public function buscarUsuarioPorID( $id) {
        $sql = 'SELECT * FROM tbl_usuario WHERE id_usuario = :id AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // ✅ fetch() - APENAS 1 registro
    }

    // ✅ BUSCAR POR EMAIL
    public function buscarUsuariosPorEmail($email) {
        $sql = 'SELECT * FROM tbl_usuario WHERE email_usuario = :email AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ BUSCAR POR TIPO
    public function buscarUsuariosPorTipo($tipo) {
        $sql = 'SELECT * FROM tbl_usuario WHERE tipo_usuario = :tipo AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ BUSCAR POR STATUS (CORRIGIDO)
    public function buscarUsuariosPorStatus($status) {
        $sql = 'SELECT * FROM tbl_usuario WHERE status_usuario = :status AND excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ INSERIR
    public function inserirUsuario($nome, $email, $senha, $tipo, $status) {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO tbl_usuario (nome_usuario, email_usuario, senha_usuario, tipo_usuario, status_usuario) 
                VALUES (:nome, :email, :senha, :tipo, :status)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // ✅ ATUALIZAR (CORRIGIDO)
    public function atualizarUsuario(int $id, $nome, $email, $senha, $tipo, $status) {
        $senhaHash = !empty($senha) ? password_hash($senha, PASSWORD_DEFAULT) : null;
        $dataAtual = date('Y-m-d H:i:s');
        
        $sql = "UPDATE tbl_usuario SET 
                nome_usuario = :nome,
                email_usuario = :email,
                senha_usuario = COALESCE(:senha, senha_usuario),
                tipo_usuario = :tipo,
                status_usuario = :status,
                atualizado_em = :atual 
                WHERE id_usuario = :id";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataAtual);
        
        return $stmt->execute();
    }

    // ✅ EXCLUIR (SOFT DELETE)
    public function excluirUsuario(int $id) {
        $dataAtual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET status_usuario = 'Inativo', excluido_em = :atual WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataAtual);
        return $stmt->execute();
    }

    // ✅ GET CLIENTES
    public function getClientes(): array {
        $stmt = $this->db->prepare(
            "SELECT id_usuario, nome_usuario FROM tbl_usuario WHERE tipo_usuario = :tipo AND excluido_em IS NULL ORDER BY nome_usuario"
        );
        $stmt->execute([':tipo' => 'cliente']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function checarCredenciais(string $email, string $senha){
        $usuario = $this->buscarUsuariosPorEmail($email);
        if(count($usuario) !== 1) {
            return false;
        }
        $usuario = $usuario[0];
        if(password_verify($senha, $usuario['senha_usuario'])) {
            return $usuario;
        }
        return false;
    }

    public function buscarUsuariosComFiltros($busca = '', $tipo = '', $status = '', $pagina = 1, $itensPorPagina = 10, $ordenarPor = 'id_usuario', $direcao = 'DESC')
    {
        $offset = ($pagina - 1) * $itensPorPagina;
        
        $sql = 'SELECT 
                    id_usuario,
                    nome_usuario,
                    email_usuario,
                    tipo_usuario,
                    status_usuario,
                    criado_em,
                    atualizado_em
                FROM tbl_usuario
                WHERE excluido_em IS NULL';
        
        $params = [];

        // Filtro de busca
        if (!empty($busca)) {
            $sql .= ' AND (
                nome_usuario LIKE :busca 
                OR email_usuario LIKE :busca
                OR id_usuario LIKE :busca
            )';
            $params[':busca'] = '%' . $busca . '%';
        }

        // Filtro de tipo
        if (!empty($tipo)) {
            $sql .= ' AND tipo_usuario = :tipo';
            $params[':tipo'] = $tipo;
        }

        // Filtro de status
        if (!empty($status)) {
            $sql .= ' AND status_usuario = :status';
            $params[':status'] = $status;
        }

        // Ordenação
        $camposPermitidos = ['id_usuario', 'nome_usuario', 'email_usuario', 'tipo_usuario', 'status_usuario', 'criado_em'];
        $campo = in_array($ordenarPor, $camposPermitidos) ? $ordenarPor : 'id_usuario';
        $dir = strtoupper($direcao) === 'ASC' ? 'ASC' : 'DESC';
        
        $sql .= " ORDER BY $campo $dir";
        if ($campo !== 'id_usuario') {
            $sql .= ', id_usuario DESC';
        }

        $sql .= ' LIMIT :limit OFFSET :offset';

        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->bindValue(':limit', (int)$itensPorPagina, PDO::PARAM_INT);
        $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criarCliente($dados)
    {
        $sql = "INSERT INTO tbl_usuario
                (nome_usuario, email_usuario, tipo_usuario, status_usuario)
                VALUES (:nome, :email, 'cliente', 'Ativo')";
 
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':email', $dados['email']);
 
        return $stmt->execute();
    }
 
    public function emailJaExiste($email)
    {
        $sql = "SELECT id_usuario FROM tbl_usuario WHERE email_usuario = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Conta total com filtros (para paginação)
     */
    public function contarUsuariosComFiltros($busca = '', $tipo = '', $status = '')
    {
        $sql = 'SELECT COUNT(*) as total
                FROM tbl_usuario
                WHERE excluido_em IS NULL';
        
        $params = [];

        if (!empty($busca)) {
            $sql .= ' AND (
                nome_usuario LIKE :busca 
                OR email_usuario LIKE :busca
                OR id_usuario LIKE :busca
            )';
            $params[':busca'] = '%' . $busca . '%';
        }

        if (!empty($tipo)) {
            $sql .= ' AND tipo_usuario = :tipo';
            $params[':tipo'] = $tipo;
        }

        if (!empty($status)) {
            $sql .= ' AND status_usuario = :status';
            $params[':status'] = $status;
        }

        $statement = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        
        return (int)$resultado['total'];
    }

    public function alterarStatusUsuario(int $id, string $novoStatus): bool
    {
        $sql = "UPDATE tbl_usuario 
                SET status_usuario = :status, 
                    atualizado_em = NOW() 
                WHERE id_usuario = :id 
                AND excluido_em IS NULL";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $novoStatus);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Calcula estatísticas (cards no topo)
     */
    public function calcularEstatisticas($busca = '', $tipo = '', $status = '')
    {
        // Conta por tipo
        $sqlTipo = 'SELECT tipo_usuario, COUNT(*) as quantidade
                    FROM tbl_usuario
                    WHERE excluido_em IS NULL';
        
        $params = [];

        if (!empty($busca)) {
            $sqlTipo .= ' AND (
                nome_usuario LIKE :busca 
                OR email_usuario LIKE :busca
                OR id_usuario LIKE :busca
            )';
            $params[':busca'] = '%' . $busca . '%';
        }

        if (!empty($tipo)) {
            $sqlTipo .= ' AND tipo_usuario = :tipo';
            $params[':tipo'] = $tipo;
        }

        if (!empty($status)) {
            $sqlTipo .= ' AND status_usuario = :status';
            $params[':status'] = $status;
        }

        $sqlTipo .= ' GROUP BY tipo_usuario';

        $statement = $this->db->prepare($sqlTipo);
        
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        
        $statement->execute();
        $resultadosTipo = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Conta por status
        $sqlStatus = 'SELECT status_usuario, COUNT(*) as quantidade
                    FROM tbl_usuario
                    WHERE excluido_em IS NULL';
        
        $paramsStatus = [];

        if (!empty($busca)) {
            $sqlStatus .= ' AND (
                nome_usuario LIKE :busca 
                OR email_usuario LIKE :busca
                OR id_usuario LIKE :busca
            )';
            $paramsStatus[':busca'] = '%' . $busca . '%';
        }

        if (!empty($tipo)) {
            $sqlStatus .= ' AND tipo_usuario = :tipo';
            $paramsStatus[':tipo'] = $tipo;
        }

        if (!empty($status)) {
            $sqlStatus .= ' AND status_usuario = :status';
            $paramsStatus[':status'] = $status;
        }

        $sqlStatus .= ' GROUP BY status_usuario';

        $statementStatus = $this->db->prepare($sqlStatus);
        
        foreach ($paramsStatus as $key => $value) {
            $statementStatus->bindValue($key, $value);
        }
        
        $statementStatus->execute();
        $resultadosStatus = $statementStatus->fetchAll(PDO::FETCH_ASSOC);

        $stats = [
            'admin' => 0,
            'cliente' => 0,
            'funcionario' => 0,
            'ativo' => 0,
            'inativo' => 0,
            'pendente' => 0,
            'total' => 0
        ];

        foreach ($resultadosTipo as $row) {
            $tipoNormalizado = strtolower($row['tipo_usuario']);
            if (isset($stats[$tipoNormalizado])) {
                $stats[$tipoNormalizado] = (int)$row['quantidade'];
            }
            $stats['total'] += (int)$row['quantidade'];
        }

        foreach ($resultadosStatus as $row) {
            $statusNormalizado = strtolower($row['status_usuario']);
            if (isset($stats[$statusNormalizado])) {
                $stats[$statusNormalizado] = (int)$row['quantidade'];
            }
        }

        return $stats;
    }

    /**
     * Altera status de múltiplos usuários
     */
    public function alterarStatusEmMassa($ids, $novoStatus)
    {
        if (empty($ids) || !is_array($ids)) {
            return false;
        }

        $dataAtual = date('Y-m-d H:i:s');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        $sql = "UPDATE tbl_usuario 
                SET status_usuario = ?, 
                    atualizado_em = ? 
                WHERE id_usuario IN ($placeholders) 
                AND excluido_em IS NULL";
        
        $statement = $this->db->prepare($sql);
        
        $params = [$novoStatus, $dataAtual];
        $params = array_merge($params, $ids);
        
        return $statement->execute($params);
    }

    /**
     * Exclui múltiplos usuários (soft delete)
     */
    public function excluirEmMassa($ids)
    {
        if (empty($ids) || !is_array($ids)) {
            return false;
        }

        $dataAtual = date('Y-m-d H:i:s');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        $sql = "UPDATE tbl_usuario 
                SET status_usuario = 'Inativo',
                    excluido_em = ? 
                WHERE id_usuario IN ($placeholders) 
                AND excluido_em IS NULL";
        
        $statement = $this->db->prepare($sql);
        
        $params = [$dataAtual];
        $params = array_merge($params, $ids);
        
        return $statement->execute($params);
    }

    public function paginacaoAPI(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_usuario`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_usuario` LIMIT :limit OFFSET :offset";
        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
        $lastPage = ceil($total_de_registros / $por_pagina);

        return [
            'data' => $dados
        ];
    }

}