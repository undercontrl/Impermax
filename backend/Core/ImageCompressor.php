<?php

namespace App\Impermax\Core;

class ImageCompressor
{
    /**
     * Comprime e redimensiona uma imagem
     * 
     * @param string $source Caminho do arquivo original
     * @param string $destination Caminho onde salvar a imagem comprimida
     * @param int $quality Qualidade da compressão (0-100)
     * @param int $maxWidth Largura máxima permitida (redimensiona se maior)
     * @return bool
     */
    public static function compress(string $source, string $destination, int $quality = 75, int $maxWidth = 1920): bool
    {
        $info = getimagesize($source);
        if ($info === false) {
            return false;
        }

        $mime = $info['mime'];
        $image = null;

        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                // Converter PNG transparente para fundo branco ou manter transparência se possível
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($source);
                break;
            default:
                return false;
        }

        if (!$image) {
            return false;
        }

        // Redimensionar se necessário
        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = floor($height * ($maxWidth / $width));
            
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Manter transparência para PNG/WebP
            if ($mime == 'image/png' || $mime == 'image/webp') {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $newImage;
        }

        // Salvar imagem comprimida
        $result = false;
        switch ($mime) {
            case 'image/jpeg':
                $result = imagejpeg($image, $destination, $quality);
                break;
            case 'image/png':
                // PNG quality is 0-9 (compression level), mapped roughly from 0-100
                $pngQuality = floor((100 - $quality) / 10);
                $result = imagepng($image, $destination, $pngQuality);
                break;
            case 'image/webp':
                $result = imagewebp($image, $destination, $quality);
                break;
        }

        imagedestroy($image);
        return $result;
    }
}
