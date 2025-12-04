<?php
namespace App\Impermax\Config;

class Mail{
    public static function get(){
        return [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username'=> 'arianerosadasilva142@gmail.com',
            'password'=> 'ctbi hipk abuy sefu',
            'encryption'=> 'tls',
            'from_address'=> 'noreply@kipedreiro.com',
            'from_name'=> 'Kipedreiro',
            
        ];
    }
}