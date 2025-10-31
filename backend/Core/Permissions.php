<?php
namespace App\Impermax\Core;

class Permissions
{
    /**
     * Define todas as permissões por tipo de usuário
     */
    private static array $permissions = [
        'admin' => [
            'agendamento' => ['ver', 'criar', 'editar', 'excluir'],
            'orcamento' => ['ver', 'criar', 'editar', 'excluir'],
            'projeto' => ['ver', 'criar', 'editar', 'excluir'],
            'pagamento' => ['ver', 'criar', 'editar', 'excluir'],
            'contato' => ['ver', 'responder', 'excluir'],
            'avaliacao' => ['ver', 'responder', 'excluir'],
            'usuario' => ['ver', 'criar', 'editar', 'excluir'],
            'servico' => ['ver', 'criar', 'editar', 'excluir'],
            'material' => ['ver', 'criar', 'editar', 'excluir'],
            'endereco' => ['ver', 'criar', 'editar', 'excluir'],
            'dashboard' => ['admin']
        ],
        'funcionario' => [
            'agendamento' => ['ver', 'criar', 'editar', 'excluir'],
            'orcamento' => ['ver'], // Apenas visualizar
            'projeto' => ['ver'], // Apenas visualizar
            'pagamento' => [], // Sem acesso
            'contato' => ['ver', 'responder'],
            'avaliacao' => ['ver'], // Apenas visualizar
            'usuario' => [], // Sem acesso
            'servico' => ['ver'], // Apenas visualizar
            'material' => ['ver'], // Apenas visualizar
            'endereco' => ['ver'], // Apenas visualizar
            'dashboard' => ['funcionario']
        ]
    ];

    /**
     * Verifica se o usuário tem permissão para uma ação
     */
    public static function can(string $tipoUsuario, string $modulo, string $acao): bool
    {
        // Admin tem acesso total
        if ($tipoUsuario === 'admin') {
            return true;
        }

        // Verifica permissões específicas
        if (!isset(self::$permissions[$tipoUsuario])) {
            return false;
        }

        if (!isset(self::$permissions[$tipoUsuario][$modulo])) {
            return false;
        }

        return in_array($acao, self::$permissions[$tipoUsuario][$modulo]);
    }

    /**
     * Verifica se o usuário pode acessar o módulo (qualquer ação)
     */
    public static function canAccess(string $tipoUsuario, string $modulo): bool
    {
        if ($tipoUsuario === 'admin') {
            return true;
        }

        if (!isset(self::$permissions[$tipoUsuario][$modulo])) {
            return false;
        }

        return !empty(self::$permissions[$tipoUsuario][$modulo]);
    }

    /**
     * Retorna todas as permissões de um tipo de usuário
     */
    public static function getPermissions(string $tipoUsuario): array
    {
        return self::$permissions[$tipoUsuario] ?? [];
    }

    /**
     * Verifica se pode criar
     */
    public static function canCreate(string $tipoUsuario, string $modulo): bool
    {
        return self::can($tipoUsuario, $modulo, 'criar');
    }

    /**
     * Verifica se pode editar
     */
    public static function canEdit(string $tipoUsuario, string $modulo): bool
    {
        return self::can($tipoUsuario, $modulo, 'editar');
    }

    /**
     * Verifica se pode excluir
     */
    public static function canDelete(string $tipoUsuario, string $modulo): bool
    {
        return self::can($tipoUsuario, $modulo, 'excluir');
    }

    /**
     * Verifica se pode visualizar
     */
    public static function canView(string $tipoUsuario, string $modulo): bool
    {
        return self::can($tipoUsuario, $modulo, 'ver');
    }

    /**
     * Retorna mensagem de erro personalizada
     */
    public static function getAccessDeniedMessage(string $acao): string
    {
        $mensagens = [
            'criar' => 'Você não tem permissão para criar novos registros neste módulo.',
            'editar' => 'Você não tem permissão para editar registros neste módulo.',
            'excluir' => 'Você não tem permissão para excluir registros neste módulo.',
            'ver' => 'Você não tem permissão para acessar este módulo.',
            'responder' => 'Você não tem permissão para responder neste módulo.',
        ];

        return $mensagens[$acao] ?? 'Você não tem permissão para realizar esta ação.';
    }
}