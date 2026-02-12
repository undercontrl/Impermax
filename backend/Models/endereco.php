<?php
namespace App\Impermax\Models;
use PDO;
class Endereco{
    private $id_endereco;
    private $id_usuario;
    private $cep_endereco;
    private $logadouro_endereco;
    private $numero_endereco;
    private $complemento_endereco;
    private $bairro_endereco;
    private $cidade_endereco;
    private $uf_endereco;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // O construtor inicializa a classe e/ou atributos
    public function __construct($db){
        $this->db = $db;
    }
    //método de buscar todos os enderecos não excluídos
    function buscarEnderecos(){
        $sql = 'SELECT * FROM tbl_endereco WHERE excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os enderecos por cep
    function buscarEnderecoPorCEP($cep_endereco){
        $sql = 'SELECT * FROM tbl_endereco WHERE cep_endereco = :cep_endereco AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':cep_endereco', $cep_endereco);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os enderecos por logadouro
    function buscarEnderecoPorLogadouro($logadouro_endereco){
        $sql = 'SELECT * FROM tbl_endereco WHERE logadouro_endereco = :logadouro_endereco AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':logadouro_endereco', $logadouro_endereco);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os enderecos por bairro
    function buscarEnderecoPorBairro($bairro_endereco){
        $sql = 'SELECT * FROM tbl_endereco WHERE bairro_endereco = :bairro_endereco AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':bairro_endereco', $bairro_endereco);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os enderecos por cidade
    function buscarEnderecoPorCidade($cidade_endereco){
        $sql = 'SELECT * FROM tbl_endereco WHERE cidade_endereco = :cidade_endereco AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':cidade_endereco', $cidade_endereco);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar todos os enderecos por usuário
    function buscarEnderecoPorUsuario($id_usuario){
        $sql = 'SELECT * FROM tbl_endereco WHERE id_usuario = :id_usuario AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_usuario', $id_usuario);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    //método de buscar endereco por id
    function buscarEnderecoPorId($id_endereco){
        $sql = 'SELECT * FROM tbl_endereco WHERE id_endereco = :id AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id_endereco);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    //método de inserir endereco
    function inserirEndereco($id_usuario, $cep_endereco, $logadouro_endereco, $numero_endereco, $complemento_endereco, $bairro_endereco, $cidade_endereco, $uf_endereco){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO tbl_endereco (id_usuario, cep_endereco, logadouro_endereco, numero_endereco, complemento_endereco, bairro_endereco, cidade_endereco, uf_endereco, criado_em) 
                VALUES (:id_usuario, :cep_endereco, :logadouro_endereco, :numero_endereco, :complemento_endereco, :bairro_endereco, :cidade_endereco, :uf_endereco, :criado_em)';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_usuario', $id_usuario);
        $statement->bindParam(':cep_endereco', $cep_endereco);
        $statement->bindParam(':logadouro_endereco', $logadouro_endereco);
        $statement->bindParam(':numero_endereco', $numero_endereco);
        $statement->bindParam(':complemento_endereco', $complemento_endereco);
        $statement->bindParam(':bairro_endereco', $bairro_endereco);
        $statement->bindParam(':cidade_endereco', $cidade_endereco);
        $statement->bindParam(':uf_endereco', $uf_endereco);
        $statement->bindParam(':criado_em', $dataAtual);
        if($statement->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    //método de atualizar o endereco
    function atualizarEndereco($id_endereco, $cep_endereco, $logadouro_endereco, $numero_endereco, $complemento_endereco, $bairro_endereco, $cidade_endereco, $uf_endereco){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_endereco 
                SET cep_endereco = :cep_endereco, 
                    logadouro_endereco = :logadouro_endereco, 
                    numero_endereco = :numero_endereco, 
                    complemento_endereco = :complemento_endereco, 
                    bairro_endereco = :bairro_endereco, 
                    cidade_endereco = :cidade_endereco, 
                    uf_endereco = :uf_endereco, 
                    atualizado_em = :atualizado_em 
                WHERE id_endereco = :id_endereco AND excluido_em IS NULL';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_endereco', $id_endereco);
        $statement->bindParam(':cep_endereco', $cep_endereco);
        $statement->bindParam(':logadouro_endereco', $logadouro_endereco);
        $statement->bindParam(':numero_endereco', $numero_endereco);
        $statement->bindParam(':complemento_endereco', $complemento_endereco);
        $statement->bindParam(':bairro_endereco', $bairro_endereco);
        $statement->bindParam(':cidade_endereco', $cidade_endereco);
        $statement->bindParam(':uf_endereco', $uf_endereco);
        $statement->bindParam(':atualizado_em', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    //método de deletar o endereco
    function excluirEndereco($id_endereco){
        $dataAtual = date('Y-m-d H:i:s');
        $sql = 'UPDATE tbl_endereco SET excluido_em = :excluido WHERE id_endereco = :id_endereco';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id_endereco', $id_endereco);
        $statement->bindParam(':excluido', $dataAtual);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
        public function buscarEnderecosComFiltros(
        string $busca = '',
        string $uf = '',
        string $cidade = '',
        string $ordemCampo = 'id_endereco',
        string $ordemDirecao = 'DESC',
        int $limite = 10,
        int $offset = 0
    ): array {
        // Campos permitidos para ordenação (segurança)
        $camposPermitidos = ['id_endereco', 'cep_endereco', 'cidade_endereco', 'uf_endereco', 'criado_em'];
        if (!in_array($ordemCampo, $camposPermitidos)) {
            $ordemCampo = 'id_endereco';
        }
        
        $ordemDirecao = strtoupper($ordemDirecao) === 'ASC' ? 'ASC' : 'DESC';
        
        $sql = "SELECT e.*, 
                    u.nome_usuario,
                    u.email_usuario
                FROM tbl_endereco e
                LEFT JOIN tbl_usuario u ON e.id_usuario = u.id_usuario
                WHERE e.excluido_em IS NULL";
        
        $params = [];
        
        // Filtro de busca (CEP, logradouro, bairro, número)
        if (!empty($busca)) {
            $sql .= " AND (
                e.cep_endereco LIKE :busca 
                OR e.logadouro_endereco LIKE :busca 
                OR e.bairro_endereco LIKE :busca
                OR e.numero_endereco LIKE :busca
                OR u.nome_usuario LIKE :busca
            )";
            $params[':busca'] = "%{$busca}%";
        }
        
        // Filtro de UF
        if (!empty($uf)) {
            $sql .= " AND e.uf_endereco = :uf";
            $params[':uf'] = $uf;
        }
        
        // Filtro de Cidade
        if (!empty($cidade)) {
            $sql .= " AND e.cidade_endereco = :cidade";
            $params[':cidade'] = $cidade;
        }
        
        $sql .= " ORDER BY e.{$ordemCampo} {$ordemDirecao}";
        $sql .= " LIMIT :limite OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Conta total de endereços com filtros aplicados
     */
    public function contarEnderecosComFiltros(
        string $busca = '',
        string $uf = '',
        string $cidade = ''
    ): int {
        $sql = "SELECT COUNT(*) as total
                FROM tbl_endereco e
                LEFT JOIN tbl_usuario u ON e.id_usuario = u.id_usuario
                WHERE e.excluido_em IS NULL";
        
        $params = [];
        
        if (!empty($busca)) {
            $sql .= " AND (
                e.cep_endereco LIKE :busca 
                OR e.logadouro_endereco LIKE :busca 
                OR e.bairro_endereco LIKE :busca
                OR e.numero_endereco LIKE :busca
                OR u.nome_usuario LIKE :busca
            )";
            $params[':busca'] = "%{$busca}%";
        }
        
        if (!empty($uf)) {
            $sql .= " AND e.uf_endereco = :uf";
            $params[':uf'] = $uf;
        }
        
        if (!empty($cidade)) {
            $sql .= " AND e.cidade_endereco = :cidade";
            $params[':cidade'] = $cidade;
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    /**
     * Calcula estatísticas de endereços
     */
    public function calcularEstatisticas(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(DISTINCT uf_endereco) as total_ufs,
                    COUNT(DISTINCT cidade_endereco) as total_cidades,
                    COUNT(DISTINCT id_usuario) as total_usuarios_com_endereco
                FROM tbl_endereco
                WHERE excluido_em IS NULL";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Busca endereço por ID com dados do usuário
     */
    public function buscarEnderecoPorIdComUsuario(int $id): ?array
    {
        $sql = "SELECT e.*, 
                    u.nome_usuario,
                    u.email_usuario,
                    u.tipo_usuario
                FROM tbl_endereco e
                LEFT JOIN tbl_usuario u ON e.id_usuario = u.id_usuario
                WHERE e.id_endereco = :id 
                AND e.excluido_em IS NULL";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Exclui múltiplos endereços (soft delete)
     */
    public function excluirEmMassa(array $ids): bool
    {
        if (empty($ids)) {
            return false;
        }
        
        $dataAtual = date('Y-m-d H:i:s');
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        
        $sql = "UPDATE tbl_endereco 
                SET excluido_em = ? 
                WHERE id_endereco IN ($placeholders)
                AND excluido_em IS NULL";
        
        $stmt = $this->db->prepare($sql);
        
        // Primeiro parâmetro é a data
        $params = [$dataAtual];
        // Depois vêm os IDs
        $params = array_merge($params, $ids);
        
        return $stmt->execute($params);
    }

    /**
     * Lista todos os estados (UFs) únicos
     */
    public function listarUFs(): array
    {
        $sql = "SELECT DISTINCT uf_endereco 
                FROM tbl_endereco 
                WHERE excluido_em IS NULL 
                AND uf_endereco IS NOT NULL
                ORDER BY uf_endereco ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Lista cidades de uma UF específica
     */
    public function listarCidadesPorUF(string $uf): array
    {
        $sql = "SELECT DISTINCT cidade_endereco 
                FROM tbl_endereco 
                WHERE excluido_em IS NULL 
                AND uf_endereco = :uf
                AND cidade_endereco IS NOT NULL
                ORDER BY cidade_endereco ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':uf', $uf);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Geocodifica um endereço para obter coordenadas (latitude/longitude)
     * Usa a API Nominatim do OpenStreetMap
     * 
     * @param string $logradouro
     * @param string $numero
     * @param string $cidade
     * @param string $uf
     * @return array|null Array com 'lat' e 'lon' ou null se falhar
     */
    public function geocodificarEndereco(
        string $logradouro,
        string $numero,
        string $cidade,
        string $uf
    ): ?array {
        try {
            // Monta o endereço completo para busca
            $enderecoCompleto = sprintf(
                "%s, %s, %s, %s, Brasil",
                $logradouro,
                $numero,
                $cidade,
                $uf
            );
            
            // URL da API Nominatim
            $url = 'https://nominatim.openstreetmap.org/search?' . http_build_query([
                'q' => $enderecoCompleto,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1
            ]);
            
            // Configura contexto HTTP com User-Agent (obrigatório para Nominatim)
            $context = stream_context_create([
                'http' => [
                    'header' => "User-Agent: Impermax-Backend/1.0\r\n",
                    'timeout' => 5
                ]
            ]);
            
            // Faz requisição
            $response = @file_get_contents($url, false, $context);
            
            if ($response === false) {
                return null;
            }
            
            $data = json_decode($response, true);
            
            // Verifica se obteve resultados
            if (empty($data) || !isset($data[0]['lat']) || !isset($data[0]['lon'])) {
                return null;
            }
            
            return [
                'lat' => (float)$data[0]['lat'],
                'lon' => (float)$data[0]['lon'],
                'display_name' => $data[0]['display_name'] ?? ''
            ];
            
        } catch (\Exception $e) {
            // Em caso de erro, retorna null
            return null;
        }
    }

    // ✅ MÉTODO PARA PAGINAÇÃO NA API
    public function paginacaoAPI(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_endereco` WHERE excluido_em IS NULL";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_endereco` WHERE excluido_em IS NULL LIMIT :limit OFFSET :offset";
        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
        // $lastPage = ceil($total_de_registros / $por_pagina); // Não usado no retorno atual, mas mantido lógica se precisar

        return [
            'data' => $dados
        ];
    }
}