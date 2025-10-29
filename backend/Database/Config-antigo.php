<?php

namespace App\Impermax\Database;

class Config
{
    public static function get()
    {
        return [
            'database' => array (
  'driver' => 'mysql',
  'mysql' => 
  array (
    'host' => 'localhost',
    'db_name' => 'impermax',
    'username' => 'root',
    'password' => NULL,
    'charset' => 'utf8',
    'port' => NULL,
  ),
)
        ];
    }
}
