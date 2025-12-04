<?php
namespace App\Impermax\Config;

class Mail{
    public static function get(){
        return [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username'=> 'oieusolegaleujuro@gmail.com',
            'password'=> 'nhzg nqyi vrue dzbe',
            'encryption'=> 'tls',
            'from_address'=> 'noreply@impermax.com',
            'from_name'=> 'Impermax',
            
        ];
    }
}