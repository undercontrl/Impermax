<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Endereco;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\EnderecoValidador;

class EnderecoController
{
    private $endereco;
    private $usuario;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->endereco = new Endereco($this->db);
        $this->usuario = new Usuario($this->db);
    }

   
    public function viewListarEnderecos()
    {
        // Captura filtros da URL
        $busca = $_GET['busca'] ?? '';
        $uf = $_GET['uf'] ?? '';
        $cidade = $_GET['cidade'] ?? '';
        
        // Captura ordenação
        $ordemCampo = $_GET['ordem_campo'] ?? 'id_endereco';
        $ordemDirecao = $_GET['ordem_direcao'] ?? 'DESC';
        
        // Paginação
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $itensPorPagina = 10;
        $offset = ($paginaAtual - 1) * $itensPorPagina;
        
        // Busca endereços com filtros
        $enderecos = $this->endereco->buscarEnderecosComFiltros(
            $busca,
            $uf,
            $cidade,
            $ordemCampo,
            $ordemDirecao,
            $itensPorPagina,
            $offset
        );
        
        // Conta total para paginação
        $totalRegistros = $this->endereco->contarEnderecosComFiltros($busca, $uf, $cidade);
        $totalPaginas = ceil($totalRegistros / $itensPorPagina);
        
        // Calcula estatísticas
        $stats = $this->endereco->calcularEstatisticas();
        
        // Lista de UFs e Cidades para filtros
        $ufs = $this->endereco->listarUFs();
        $cidades = $uf ? $this->endereco->listarCidadesPorUF($uf) : [];
        
        // Monta dados de paginação
        $paginacao = [
            'pagina_atual' => $paginaAtual,
            'total_paginas' => $totalPaginas,
            'total_registros' => $totalRegistros,
            'itens_por_pagina' => $itensPorPagina,
            'inicio' => $offset + 1,
            'fim' => min($offset + $itensPorPagina, $totalRegistros)
        ];
        
        View::render("endereco/index", [
            "enderecos" => $enderecos,
            "stats" => $stats,
            "paginacao" => $paginacao,
            "filtros" => [
                'busca' => $busca,
                'uf' => $uf,
                'cidade' => $cidade
            ],
            "ordenacao" => [
                'campo' => $ordemCampo,
                'direcao' => $ordemDirecao
            ],
            "ufs" => $ufs,
            "cidades" => $cidades
        ]);
    }


    public function viewVisualizarEndereco($id)
    {
        $endereco = $this->endereco->buscarEnderecoPorIdComUsuario($id);
        
        if (!$endereco) {
            Redirect::redirecionarComMensagem(
                "endereco/listar",
                "error",
                "Endereço não encontrado!"
            );
            return;
        }
        
        View::render("endereco/view", ["endereco" => $endereco]);
    }

    public function viewCriarEndereco()
    {
        $usuarios = $this->usuario->buscarUsuarios();
        View::render("endereco/create", ["usuarios" => $usuarios]);
    }

    public function salvarEndereco()
    {
        $erros = EnderecoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("endereco/criar", "error", implode("<br>", $erros));
            return;
        }

        $ok = $this->endereco->inserirEndereco(
            $_POST["id_usuario"],
            $_POST["cep_endereco"],
            $_POST["logadouro_endereco"],
            $_POST["numero_endereco"],
            $_POST["complemento_endereco"] ?? '',
            $_POST["bairro_endereco"],
            $_POST["cidade_endereco"],
            $_POST["uf_endereco"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("endereco/listar", "success", "Endereço cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("endereco/criar", "error", "Erro ao cadastrar endereço!");
        }
    }

 
    public function viewEditarEndereco($id)
    {
        $endereco = $this->endereco->buscarEnderecoPorId($id);
        $usuarios = $this->usuario->buscarUsuarios();
        
        if (!$endereco) {
            Redirect::redirecionarComMensagem("endereco/listar", "error", "Endereço não encontrado!");
            return;
        }
        
        View::render("endereco/edit", [
            "endereco" => $endereco,
            "usuarios" => $usuarios
        ]);
    }

    public function atualizarEndereco($id)
    {
        $erros = EnderecoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("endereco/editar/{$id}", "error", implode("<br>", $erros));
            return;
        }

        $ok = $this->endereco->atualizarEndereco(
            $id,
            $_POST["cep_endereco"],
            $_POST["logadouro_endereco"],
            $_POST["numero_endereco"],
            $_POST["complemento_endereco"] ?? '',
            $_POST["bairro_endereco"],
            $_POST["cidade_endereco"],
            $_POST["uf_endereco"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("endereco/listar", "success", "Endereço atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("endereco/editar/{$id}", "error", "Erro ao atualizar endereço!");
        }
    }

   
    public function viewExcluirEndereco($id)
    {
        $endereco = $this->endereco->buscarEnderecoPorIdComUsuario($id);
        
        if (!$endereco) {
            Redirect::redirecionarComMensagem("endereco/listar", "error", "Endereço não encontrado!");
            return;
        }
        
        View::render("endereco/delete", ["endereco" => $endereco]);
    }

    public function deletarEndereco($id)
    {
        $ok = $this->endereco->excluirEndereco($id);

        if ($ok) {
            Redirect::redirecionarComMensagem("endereco/listar", "success", "Endereço excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("endereco/listar", "error", "Erro ao excluir endereço!");
        }
    }

  
    public function excluirEmMassa()
    {
        $ids = $_POST['ids'] ?? [];
        
        if (empty($ids) || !is_array($ids)) {
            Redirect::redirecionarComMensagem("endereco/listar", "error", "Nenhum endereço selecionado!");
            return;
        }
        
        $ok = $this->endereco->excluirEmMassa($ids);
        
        if ($ok) {
            $total = count($ids);
            Redirect::redirecionarComMensagem(
                "endereco/listar",
                "success",
                "{$total} endereço(s) excluído(s) com sucesso!"
            );
        } else {
            Redirect::redirecionarComMensagem("endereco/listar", "error", "Erro ao excluir endereços!");
        }
    }


    public function buscarCep()
    {
        header('Content-Type: application/json');
        
        $cep = $_GET['cep'] ?? '';
        $cep = preg_replace('/[^0-9]/', '', $cep);
        
        if (strlen($cep) != 8) {
            echo json_encode(['erro' => 'CEP inválido']);
            return;
        }
        
        // Consulta API ViaCEP
        $url = "https://viacep.com.br/ws/{$cep}/json/";
        $response = @file_get_contents($url);
        
        if ($response === false) {
            echo json_encode(['erro' => 'Erro ao consultar CEP']);
            return;
        }
        
        echo $response;
    }
}