<?php
namespace App\Impermax\Core\Helpers;

class AssetHelper
{
    /**
     * Retorna a URL completa para um asset (imagem, arquivo, etc)
     * Ex: AssetHelper::url('cards/servico1.jpg') -> '/assets/cards/servico1.jpg'
     * Ex: AssetHelper::upload('foto.jpg') -> '/upload/foto.jpg'
     * 
     * @param string $path Caminho relativo
     * @return string URL absoluta a partir da raiz do servidor
     */
    public static function url(string $path): string
    {
        // Remove barra inicial se houver para evitar duplicidade
        $path = ltrim($path, '/');
        return "/assets/{$path}"; 
    }

    /**
     * Retorna URL para arquivos de upload
     * 
     * @param string $filename Nome do arquivo
     * @return string
     */
    public static function upload(string $filename): string
    {
        // Se filename for vazio ou null, retorna placeholder
        if (empty($filename)) {
            return '/assets/cards/default.jpg';
        }

        $filename = ltrim($filename, '/');
        // Se a string já começar com http (url externa) ou /upload, retorna ela mesma
        if (strpos($filename, 'http') === 0 || strpos($filename, '/upload') === 0) {
            return $filename;
        }

        return "/upload/{$filename}";
    }
}
