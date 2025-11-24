<?php
namespace App\Impermax\Core;
use App\Impermax\Core\Flash;

class Redirect{
    public static function redirecionarPara($url){
        header("Location: /backend/" .$url);
        exit;
    }
    public static function redirecionarComMensagem($url, $type, $message){
        Flash::set($type, $message);
        self::redirecionarPara($url);
    }
    public static function voltarPaginaAnteriorComMensagem($type, $message){
        $url = $_SERVER["HTTP_REFERER"] ?? "/";
        self::redirecionarPara($url, $type, $message);
    }
}