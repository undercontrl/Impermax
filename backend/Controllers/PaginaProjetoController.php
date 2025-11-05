<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\PaginaProjeto;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\PaginaProjetoValidador;
use App\Impermax\Controllers\Admin\AdminController;
use App\Impermax\Core\FileManager;

class PaginaProjetoController extends AdminController 
{
    private $model;
    private $gerenciarImagem;

    public function __construct() 
    {
        parent::__construct();
        $db = Database::getInstance();
        $this->model = new PaginaProjeto($db);
        // Caminho absoluto como no ProjetoController
        $this->gerenciarImagem = new FileManager($_SERVER['DOCUMENT_ROOT'] . '/upload');
    }

    // ==================== VIEWS ====================

    public function index() 
    {
        $this->listar(1);
    }

    /**
     * Lista projetos detalhados com filtros e paginação
     */
    public function listar($pagina = 1) 
    {
        $pagina = max(1, (int)$pagina);
        $statusFiltro = $_GET['status'] ?? '';
        
        // Busca os dados
        $resultado = $this->model->listarTodos($pagina, 12);
        $projetos = $resultado['data'];
        
        // Aplica filtro de status se necessário
        if (!empty($statusFiltro)) {
            $projetos = array_filter($projetos, function($projeto) use ($statusFiltro) {
                $statusProjeto = strtolower($projeto['status_projeto']);
                return $statusProjeto === strtolower($statusFiltro);
            });
            
            // Recalcula paginação após filtro
            $resultado['total'] = count($projetos);
            $resultado['total_paginas'] = 1;
        }
        
        // Busca estatísticas
        $stats = $this->model->buscarEstatisticas();
        
        View::render("pagina-projeto/index", [
            'projetos' => $projetos,
            'paginacao' => $resultado,
            'stats' => $stats
        ]);
    }

    /**
     * Exibe formulário de criação
     */
    public function criar() 
    {
        View::render("pagina-projeto/create");
    }

    /**
     * Exibe formulário de edição
     */
    public function editar($id) 
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("pagina-projeto/listar", "error", "ID do projeto não fornecido!");
            return;
        }

        $projeto = $this->model->buscarPorId($id);
        
        if (!$projeto) {
            Redirect::redirecionarComMensagem("pagina-projeto/listar", "error", "Projeto não encontrado.");
            return;
        }
        
        View::render("pagina-projeto/edit", ['projeto' => $projeto]);
    }

    // ==================== AÇÕES ====================

    /**
     * Salva novo projeto
     */
    public function salvar() 
    {
        // Validação completa (imagem obrigatória na criação)
        $erros = PaginaProjetoValidador::validar($_POST, $_FILES, false);
        
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem(
                "pagina-projeto/criar", 
                "error", 
                implode("<br>", $erros)
            );
            return;
        }

        try {
            // Upload da imagem
            $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem_projeto'], 'projetos');
            
            if (!$imagem) {
                Redirect::redirecionarComMensagem(
                    "pagina-projeto/criar",
                    "error",
                    "Erro ao fazer upload da imagem. Verifique o formato e tamanho."
                );
                return;
            }

            // Insere no banco
            $sucesso = $this->model->inserir(
                $_POST['nome_projeto'],
                $imagem,
                $_POST['descricao_projeto'],
                'Inativo' // Status padrão
            );

            if ($sucesso) {
                Redirect::redirecionarComMensagem(
                    "pagina-projeto/listar", 
                    "success", 
                    "Projeto criado com sucesso!"
                );
            } else {
                // Se falhou ao inserir no banco, deletar a imagem
                $caminhoCompleto = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $imagem;
                if (file_exists($caminhoCompleto)) {
                    @unlink($caminhoCompleto);
                }
                
                Redirect::redirecionarComMensagem(
                    "pagina-projeto/criar", 
                    "error", 
                    "Erro ao salvar projeto no banco de dados."
                );
            }
        } catch (\Exception $e) {
            error_log("Erro ao criar projeto detalhado: " . $e->getMessage());
            Redirect::redirecionarComMensagem(
                "pagina-projeto/criar",
                "error",
                "Erro ao processar: " . $e->getMessage()
            );
        }
    }

    /**
     * Atualiza projeto existente
     */
    public function atualizar($id) 
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("pagina-projeto/listar", "error", "ID do projeto não fornecido!");
            return;
        }

        // Buscar projeto atual
        $projetoAtual = $this->model->buscarPorId($id);
        
        if (!$projetoAtual) {
            Redirect::redirecionarComMensagem("pagina-projeto/listar", "error", "Projeto não encontrado!");
            return;
        }

        // Validação (imagem opcional na atualização)
        $erros = PaginaProjetoValidador::validar($_POST, $_FILES, true);
        
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem(
                "pagina-projeto/editar/$id",
                "error",
                implode("<br>", $erros)
            );
            return;
        }

        try {
            // Manter imagem atual por padrão
            $imagem = $projetoAtual['imagem_projeto'];
            
            // Verificar se há nova imagem
            if (isset($_FILES['imagem_projeto']) && $_FILES['imagem_projeto']['error'] === UPLOAD_ERR_OK) {
                // Upload da nova imagem
                $novaImagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem_projeto'], 'projetos');
                
                if ($novaImagem) {
                    // Deletar imagem antiga se existir
                    if (!empty($projetoAtual['imagem_projeto'])) {
                        $caminhoAntigo = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $projetoAtual['imagem_projeto'];
                        if (file_exists($caminhoAntigo)) {
                            @unlink($caminhoAntigo);
                        }
                    }
                    $imagem = $novaImagem;
                } else {
                    Redirect::redirecionarComMensagem(
                        "pagina-projeto/editar/$id",
                        "error",
                        "Erro ao fazer upload da nova imagem."
                    );
                    return;
                }
            }

            // Atualizar no banco
            $sucesso = $this->model->atualizar(
                $id,
                $_POST['nome_projeto'],
                $imagem,
                $_POST['descricao_projeto'],
                $_POST['status_projeto'] ?? 'Inativo'
            );

            if ($sucesso) {
                Redirect::redirecionarComMensagem(
                    "pagina-projeto/listar", 
                    "success", 
                    "Projeto atualizado com sucesso!"
                );
            } else {
                Redirect::redirecionarComMensagem(
                    "pagina-projeto/editar/$id", 
                    "error", 
                    "Erro ao atualizar o projeto no banco de dados!"
                );
            }
        } catch (\Exception $e) {
            error_log("Erro ao atualizar projeto: " . $e->getMessage());
            Redirect::redirecionarComMensagem(
                "pagina-projeto/editar/$id",
                "error",
                "Erro ao processar atualização: " . $e->getMessage()
            );
        }
    }

    /**
     * Alterna status entre Ativo/Inativo
     */
    public function alternar($id) 
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("pagina-projeto/listar", "error", "ID do projeto não fornecido!");
            return;
        }

        try {
            $sucesso = $this->model->alternarStatus($id);
            
            if ($sucesso) {
                Redirect::redirecionarComMensagem(
                    "pagina-projeto/listar", 
                    "success", 
                    "Status alterado com sucesso!"
                );
            } else {
                Redirect::redirecionarComMensagem(
                    "pagina-projeto/listar", 
                    "error", 
                    "Erro ao alterar status. Projeto não encontrado."
                );
            }
        } catch (\Exception $e) {
            error_log("Erro ao alternar status: " . $e->getMessage());
            Redirect::redirecionarComMensagem(
                "pagina-projeto/listar",
                "error",
                "Erro ao processar: " . $e->getMessage()
            );
        }
    }

    /**
     * Exclui projeto (soft delete)
     */
    public function deletar($id) 
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("pagina-projeto/listar", "error", "ID do projeto não fornecido!");
            return;
        }

        try {
            $sucesso = $this->model->excluir($id);
            
            if ($sucesso) {
                Redirect::redirecionarComMensagem(
                    "pagina-projeto/listar", 
                    "success", 
                    "Projeto excluído com sucesso!"
                );
            } else {
                Redirect::redirecionarComMensagem(
                    "pagina-projeto/listar", 
                    "error", 
                    "Erro ao excluir projeto."
                );
            }
        } catch (\Exception $e) {
            error_log("Erro ao excluir projeto: " . $e->getMessage());
            Redirect::redirecionarComMensagem(
                "pagina-projeto/listar",
                "error",
                "Erro ao processar exclusão: " . $e->getMessage()
            );
        }
    }

    /**
     * API: Retorna projetos ativos para o site público
     */
    public function api() 
    {
        try {
            $projetos = $this->model->listarAtivos();
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $projetos,
                'total' => count($projetos)
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao buscar projetos',
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }
}
?>