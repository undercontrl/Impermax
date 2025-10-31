<?php
namespace App\Impermax\Core;

class RateLimiter {
    public static function allow($key, $action, $limit, $seconds) {
        $key = "rate_{$action}_{$key}";
        $now = time();
        $times = $_SESSION[$key] ?? [];

        $times = array_filter($times, fn($t) => $t > $now - $seconds);
        if (count($times) >= $limit) return false;

        $times[] = $now;
        $_SESSION[$key] = $times;
        return true;
    }
}