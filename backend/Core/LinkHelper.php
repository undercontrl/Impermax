<?php
namespace App\Impermax\Core\Helpers;

class LinkHelper
{
    /**
     * Retorna a URL do dashboard baseado no tipo de usuário
     * 
     * @return string URL do dashboard
     */
    public static function getDashboardUrl(): string
    {
        $tipoUsuario = $_SESSION['tipo_usuario'] ?? 'funcionario';
        
        return match($tipoUsuario) {
            'admin' => '/backend/admin/dashboard',
            'funcionario' => '/backend/funcionario/dashboard',
            default => '/backend/funcionario/dashboard'
        };
    }

    /**
     * Retorna o label do dashboard baseado no tipo de usuário
     * 
     * @return string Label do dashboard
     */
    public static function getDashboardLabel(): string
    {
        $tipoUsuario = $_SESSION['tipo_usuario'] ?? 'funcionario';
        
        return match($tipoUsuario) {
            'admin' => 'Dashboard Admin',
            'funcionario' => 'Dashboard',
            default => 'Dashboard'
        };
    }

    /**
     * Verifica se o usuário tem permissão para acessar determinada rota
     * 
     * @param array $tiposPermitidos Tipos de usuário permitidos
     * @return bool
     */
    public static function temPermissao(array $tiposPermitidos): bool
    {
        $tipoUsuario = $_SESSION['tipo_usuario'] ?? null;
        return in_array($tipoUsuario, $tiposPermitidos);
    }

    /**
     * Retorna array com links do menu baseado nas permissões do usuário
     * 
     * @return array Links do menu
     */
    public static function getMenuLinks(): array
    {
        $tipoUsuario = $_SESSION['tipo_usuario'] ?? 'funcionario';
        
        // Links comuns a todos
        $linksComuns = [
            'dashboard' => [
                'url' => self::getDashboardUrl(),
                'label' => self::getDashboardLabel(),
                'icon' => 'bi-speedometer2'
            ],
            'agendamentos' => [
                'url' => '/backend/agendamento/listar',
                'label' => 'Agendamentos',
                'icon' => 'bi-calendar-check'
            ],
            'orcamentos' => [
                'url' => '/backend/orcamento/listar',
                'label' => 'Orçamentos',
                'icon' => 'bi-newspaper'
            ],
            'projetos' => [
                'url' => '/backend/projeto/listar',
                'label' => 'Projetos',
                'icon' => 'bi-card-image'
            ],
        ];

        // Links exclusivos de admin
        $linksAdmin = [
            'usuarios' => [
                'url' => '/backend/usuario/listar',
                'label' => 'Usuários',
                'icon' => 'bi-people'
            ],
            'contatos' => [
                'url' => '/backend/contato/listar',
                'label' => 'Contatos',
                'icon' => 'bi-envelope'
            ],
            'avaliacoes' => [
                'url' => '/backend/avaliacao/listar',
                'label' => 'Avaliações',
                'icon' => 'bi-star'
            ],
            'pagamentos' => [
                'url' => '/backend/pagamento/listar',
                'label' => 'Pagamentos',
                'icon' => 'bi-cash-coin'
            ],
            'servicos' => [
                'url' => '/backend/servico/listar',
                'label' => 'Serviços',
                'icon' => 'bi-box-seam'
            ],
            'materiais' => [
                'url' => '/backend/material/listar',
                'label' => 'Material',
                'icon' => 'bi-tools'
            ],
        ];

        // Retorna links baseado no tipo
        if ($tipoUsuario === 'admin') {
            return array_merge($linksComuns, $linksAdmin);
        }

        return $linksComuns;
    }

    /**
     * Redireciona para o dashboard correto
     */
    public static function redirecionarParaDashboard(): void
    {
        header('Location: ' . self::getDashboardUrl());
        exit;
    }

    /**
     * Retorna URL de perfil
     * 
     * @return string
     */
    public static function getPerfilUrl(): string
    {
        return '/backend/perfil';
    }

    /**
     * Retorna URL de logout
     * 
     * @return string
     */
    public static function getLogoutUrl(): string
    {
        return '/backend/logout';
    }
}