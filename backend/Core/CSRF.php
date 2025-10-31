<?php
namespace App\Impermax\Core;

class CSRF {
    public static function generate() {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    public static function validate($token) {
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }
}