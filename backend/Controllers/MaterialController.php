<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Material;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\MaterialValidador;
use App\Impermax\Core\ValidaToken;
use PDO;

class MaterialController {
    private $material;
    private $db;
     private $chaveAPI;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->material = new Material($this->db);
         $this->chaveAPI = new ValidaToken();
    }

        public function getMateriais($pagina=0){
         $this->chaveAPI->ValidaToken();
        //condição ternaria é igual if else
        $registros_por_pagina = $pagina===0 ? 200 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->material->paginacaoAPI($pagina, $registros_por_pagina);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function index() {
        $this->viewListarMateriais();
    }

    // ✅ VIEW LISTAR COM FILTROS E PAGINAÇÃO
    public function viewListarMateriais() {
        // Parâmetros de filtro
        $filtros = [
            'busca' => isset($_GET['busca']) && $_GET['busca'] !== '' ? trim($_GET['busca']) : '',
            'servico' => isset($_GET['servico']) && $_GET['servico'] !== '' ? trim($_GET['servico']) : '',
            'ordem_campo' => isset($_GET['ordem_campo']) && $_GET['ordem_campo'] !== '' ? $_GET['ordem_campo'] : 'id_material',
            'ordem_direcao' => isset($_GET['ordem_direcao']) && $_GET['ordem_direcao'] !== '' ? strtoupper($_GET['ordem_direcao']) : 'DESC'
        ];

        // Debug dos filtros
        error_log("Filtros recebidos: " . print_r($filtros, true));

        // Paginação
        $pagina_atual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
        $itens_por_pagina = 10;
        $offset = ($pagina_atual - 1) * $itens_por_pagina;

        // Buscar materiais com filtros
        $materiais = $this->material->buscarMateriais($filtros, $itens_por_pagina, $offset);
        
        // Contar total com os mesmos filtros
        $total_materiais = $this->material->contarMateriais($filtros);
        $total_paginas = $total_materiais > 0 ? ceil($total_materiais / $itens_por_pagina) : 1;

        // Debug
        error_log("Total de materiais encontrados: " . $total_materiais);
        error_log("Materiais retornados: " . count($materiais));

        // Estatísticas
        $stats = $this->material->obterEstatisticas();
        error_log("Estatísticas: " . print_r($stats, true));

        // Serviços únicos para o filtro
        $servicosUnicos = $this->material->buscarServicosUnicos();

        // Informações de paginação
        $paginacao = [
            'pagina_atual' => $pagina_atual,
            'total_paginas' => $total_paginas,
            'total' => $total_materiais,
            'inicio' => $total_materiais > 0 ? $offset + 1 : 0,
            'fim' => min($offset + $itens_por_pagina, $total_materiais)
        ];

        View::render("material/index", [
            "materiais" => $materiais,
            "stats" => $stats,
            "paginacao" => $paginacao,
            "servicosUnicos" => $servicosUnicos
        ]);
    }

    // ✅ SALVAR
    public function salvarMaterial() {
        $erros = MaterialValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("material/criar", "error", implode("<br>", $erros));
            return;
        }

        if ($this->material->inserirMaterial(
            $_POST["nome_material"],
            $_POST["qtd_material"],
            $_POST["descricao_material"],
            $_POST["id_servico"] ?? null
        )) {
            Redirect::redirecionarComMensagem("material/listar", "success", "Material cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("material/criar", "error", "Erro ao cadastrar material!");
        }
    }

    // ✅ ATUALIZAR
    public function atualizarMaterial(int $id) {
        $erros = MaterialValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("material/editar/{$id}", "error", implode("<br>", $erros));
            return;
        }

        if ($this->material->atualizarMaterial(
            $id,
            $_POST["nome_material"],
            $_POST["qtd_material"],
            $_POST["descricao_material"],
            $_POST["id_servico"] ?? null
        )) {
            Redirect::redirecionarComMensagem("material/listar", "success", "Material atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("material/editar/{$id}", "error", "Erro ao atualizar material!");
        }
    }

    // ✅ DELETAR INDIVIDUAL
    public function deletarMaterial(int $id) {
        if ($this->material->excluirMaterial($id)) {
            Redirect::redirecionarComMensagem("material/listar", "success", "Material excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("material/listar", "error", "Erro ao excluir material!");
        }
    }

    // ✅ DELETAR MÚLTIPLOS
    public function deletarMultiplos() {
        // Garantir que retorna JSON
        header('Content-Type: application/json; charset=utf-8');
        
        try {
            // Verificar se há IDs
            if (!isset($_POST['ids']) || !is_array($_POST['ids']) || empty($_POST['ids'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Nenhum material selecionado!'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }

            // Converter para inteiros e filtrar valores inválidos
            $ids = array_filter(array_map('intval', $_POST['ids']), function($id) {
                return $id > 0;
            });

            if (empty($ids)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'IDs inválidos!'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }

            // Log para debug
            error_log("Tentando excluir materiais: " . implode(', ', $ids));

            // Executar exclusão
            if ($this->material->excluirMultiplos($ids)) {
                echo json_encode([
                    'success' => true,
                    'message' => count($ids) . ' material(is) excluído(s) com sucesso!'
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao excluir materiais no banco de dados!'
                ], JSON_UNESCAPED_UNICODE);
            }
        } catch (\Exception $e) {
            error_log("Erro na exclusão múltipla: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao processar exclusão: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    // ✅ VIEW CRIAR - SEM DEPENDÊNCIA DE SERVICO MODEL
    public function viewCriarMateriais() {
        $servicos = $this->buscarServicos();
        View::render("material/create", ["servicos" => $servicos]);
    }

    // ✅ VIEW EDITAR - SEM DEPENDÊNCIA DE SERVICO MODEL
    public function viewEditarMateriais(int $id) {
        $material = $this->material->buscarMaterialPorID($id);
        $servicos = $this->buscarServicos();
        
        if ($material) {
            View::render("material/edit", [
                "material" => $material,
                "servicos" => $servicos
            ]);
        } else {
            Redirect::redirecionarComMensagem("material/listar", "error", "Material não encontrado!");
        }
    }

    // ✅ VIEW EXCLUIR
    public function viewExcluirMateriais(int $id) {
        $material = $this->material->buscarMaterialPorID($id);
        if ($material) {
            View::render("material/delete", ["material" => $material]);
        } else {
            Redirect::redirecionarComMensagem("material/listar", "error", "Material não encontrado!");
        }
    }

    // ✅ MÉTODO PRIVADO - Buscar Serviços Direto do Banco
    private function buscarServicos() {
        try {
            $sql = "SELECT id_servico, nome_servico 
                    FROM tbl_servico 
                    WHERE excluido_em IS NULL 
                    ORDER BY nome_servico ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Erro ao buscar serviços: " . $e->getMessage());
            return [];
        }
    }
}