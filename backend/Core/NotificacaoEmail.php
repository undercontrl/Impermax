<?php
namespace App\Impermax\Core;
use App\Impermax\Core\EmailService;

class NotificacaoEmail{
    private $emailService;
    public function __construct(){
        $this->emailService = new EmailService();
    }
    public function esqueciASenha(string $email, string $token): void {
        $assunto = "Redefinição de Senha";
        $mensagem = "Clique no link para redefinir sua senha: ";
        $mensagem .= "hhtp://localhost:5000/backend/redefinir-senha?token=". urlencode($token);
        $this->emailService->send($email, $assunto, $mensagem);
    }
    public function boasVindas(string $email, string $nome): void{
        $assunto = "Bem-vindo ao Impermax!";
        $mensagem = "<b><h2>Olá " . htmlspecialchars($nome) . "</h2></b>,\n\n";
        $mensagem .= "<p>Obrigado por se registrar no Impermax!</p>\n\n";
        $mensagem .= "<p>Atenciosamente, \nEquipe Impermax</p>";
        $this->emailService->send($email, $assunto, $mensagem);

    }
}