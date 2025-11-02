<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\ServicoSite;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ServicoSiteValidador;
use App\Impermax\Controllers\Admin\AdminController;
use App\Impermax\Core\FileManager;

class ServicoSiteController extends AdminController 
{
    private $model;
    private $db;
    private $gerenciarImagem;

    public function __construct() 
    {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->model = new ServicoSite($this->db);
        // Usar caminho absoluto como no ProjetoController
       $this->gerenciarImagem = new FileManager($_SERVER['DOCUMENT_ROOT'] . '/upload');
    }

    // ==================== VIEWS ====================

    public function index() 
    {
        $this->listar(1);
    }

    /**
     * Lista serviços do site com filtros e paginação
     */
    public function listar($pagina = 1) 
    {
        $pagina = max(1, (int)$pagina);
        $statusFiltro = $_GET['status'] ?? '';
        
        // Busca os dados
        $resultado = $this->model->listarTodos($pagina, 10);
        $servicos = $resultado['data'];
        
        // Aplica filtro de status se necessário
        if (!empty($statusFiltro)) {
            $servicos = array_filter($servicos, function($servico) use ($statusFiltro) {
                $statusServico = strtolower($servico['status_servico']);
                return $statusServico === strtolower($statusFiltro);
            });
            
            // Recalcula paginação após filtro
            $resultado['total'] = count($servicos);
            $resultado['total_paginas'] = 1;
        }
        
        View::render("servico-site/index", [
            'servicos' => $servicos,
            'paginacao' => $resultado
        ]);
    }

    /**
     * Exibe formulário de criação
     */
    public function criar() 
    {
        View::render("servico-site/create");
    }

    /**
     * Exibe formulário de edição
     */
    public function editar($id) 
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "ID do serviço não fornecido!");
            return;
        }

        $servico = $this->model->buscarPorId($id);
        
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "Serviço não encontrado.");
            return;
        }
        
        View::render("servico-site/edit", ['servico' => $servico]);
    }

    // ==================== AÇÕES ====================

    /**
     * Salva novo serviço
     */
    public function salvar() 
    {
        // Validação completa (foto obrigatória na criação)
        $erros = ServicoSiteValidador::validar($_POST, $_FILES, false);
        
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem(
                "servico-site/criar", 
                "error", 
                implode("<br>", $erros)
            );
            return;
        }

        try {
            // Upload da foto
            $foto_servico = $this->gerenciarImagem->salvarArquivo($_FILES['foto_servico'], 'servico');
            
            if (!$foto_servico) {
                Redirect::redirecionarComMensagem(
                    "servico-site/criar",
                    "error",
                    "Erro ao fazer upload da imagem. Verifique o formato e tamanho."
                );
                return;
            }

            // Insere no banco
            $sucesso = $this->model->inserir(
                $_POST['nome_servico'],
                $_POST['descricao_servico'],
                $foto_servico,
                'Inativo' // Status padrão
            );

            if ($sucesso) {
                Redirect::redirecionarComMensagem(
                    "servico-site/listar", 
                    "success", 
                    "Serviço criado com sucesso!"
                );
            } else {
                // Se falhou ao inserir no banco, deletar a imagem
                $caminhoCompleto = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $foto_servico['foto_servico'];
                if (file_exists($caminhoCompleto)) {
                    @unlink($caminhoCompleto);
                }
                
                Redirect::redirecionarComMensagem(
                    "servico-site/criar", 
                    "error", 
                    "Erro ao salvar serviço no banco de dados."
                );
            }
        } catch (\Exception $e) {
            error_log("Erro ao criar serviço: " . $e->getMessage());
            Redirect::redirecionarComMensagem(
                "servico-site/criar",
                "error",
                "Erro ao processar: " . $e->getMessage()
            );
        }
    }

    /**
     * Atualiza serviço existente
     */
    public function atualizar($id) 
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "ID do serviço não fornecido!");
            return;
        }

        // Buscar serviço atual
        $servicoAtual = $this->model->buscarPorId($id);
        
        if (!$servicoAtual) {
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "Serviço não encontrado!");
            return;
        }

        // Validação (foto opcional na atualização)
        $erros = ServicoSiteValidador::validar($_POST, $_FILES, true);
        
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem(
                "servico-site/editar/$id",
                "error",
                implode("<br>", $erros)
            );
            return;
        }

        try {
            // Manter foto atual por padrão
            $foto_servico = $servicoAtual['foto_servico'];
            
            // Verificar se há nova foto
            if (isset($_FILES['foto_servico']) && $_FILES['foto_servico']['error'] === UPLOAD_ERR_OK) {
                // Upload da nova foto
                $novaFoto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_servico'], 'servico');
                
                if ($novaFoto) {
                    // Deletar foto antiga se existir
                    if (!empty($servicoAtual['foto_servico'])) {
                        $caminhoAntigo = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $servicoAtual['foto_servico'];
                        if (file_exists($caminhoAntigo)) {
                            @unlink($caminhoAntigo);
                        }
                    }
                    $foto_servico = $novaFoto;
                } else {
                    Redirect::redirecionarComMensagem(
                        "servico-site/editar/$id",
                        "error",
                        "Erro ao fazer upload da nova imagem."
                    );
                    return;
                }
            }

            // Atualizar no banco
            $sucesso = $this->model->atualizar(
                $id,
                $_POST['nome_servico'],
                $_POST['descricao_servico'],
                $foto_servico,
                $_POST['status_servico'] ?? 'Inativo'
            );

            if ($sucesso) {
                Redirect::redirecionarComMensagem(
                    "servico-site/listar", 
                    "success", 
                    "Serviço atualizado com sucesso!"
                );
            } else {
                Redirect::redirecionarComMensagem(
                    "servico-site/editar/$id", 
                    "error", 
                    "Erro ao atualizar o serviço no banco de dados!"
                );
            }
        } catch (\Exception $e) {
            error_log("Erro ao atualizar serviço: " . $e->getMessage());
            Redirect::redirecionarComMensagem(
                "servico-site/editar/$id",
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
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "ID do serviço não fornecido!");
            return;
        }

        try {
            $sucesso = $this->model->alternarStatus($id);
            
            if ($sucesso) {
                Redirect::redirecionarComMensagem(
                    "servico-site/listar", 
                    "success", 
                    "Status alterado com sucesso!"
                );
            } else {
                Redirect::redirecionarComMensagem(
                    "servico-site/listar", 
                    "error", 
                    "Erro ao alterar status. Serviço não encontrado."
                );
            }
        } catch (\Exception $e) {
            error_log("Erro ao alternar status: " . $e->getMessage());
            Redirect::redirecionarComMensagem(
                "servico-site/listar",
                "error",
                "Erro ao processar: " . $e->getMessage()
            );
        }
    }

    /**
     * API: Retorna serviços ativos para o site público
     */
    public function api() 
    {
        try {
            $servicos = $this->model->listarAtivos();
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $servicos,
                'total' => count($servicos)
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao buscar serviços',
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }
}
?>