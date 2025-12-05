<?php
namespace App\Impermax\Config;

class Mail{
    public static function get(){
        return [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username'=> 'alessandro.impermax@gmail.com',
            'password'=> 'bhfd vgtl yblp jxoi',
            'encryption'=> 'tls',
            'from_address'=> 'noreply@impermax.com',
            'from_name'=> 'Impermax',
            
        ];
    }
}