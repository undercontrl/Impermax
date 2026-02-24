<?php
namespace App\Impermax\Core;
use App\Impermax\Core\EmailService;

class EmailNotification {
    private EmailService $emailService;
    private string $baseUrl;
    private string $logoUrl;
    
    public function __construct() {
        $this->emailService = new EmailService();
        $this->baseUrl = 'https://aleimpermax.com.br/'; 
        $this->logoUrl = $this->baseUrl . 'assets/icons/impermax-LOGO.svg'; 
    }

    /**
     * Template base HTML para emails
     */
    private function getEmailTemplate(string $titulo, string $conteudo, string $corPrimaria = '#1487df'): string {
        return <<<HTML
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{$titulo}</title>
    </head>
    <body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f9;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f6f9; padding: 40px 0;">
            <tr>
                <td align="center">
                    <!-- Container Principal -->
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">
                        
                        <!-- Header com Logo -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #5f7396 0%, {$corPrimaria} 100%); padding: 30px; text-align: center;">
                                <img src="{$this->logoUrl}" alt="Impermax Logo" style="max-width: 180px; height: auto;">
                            </td>
                        </tr>
                        
                        <!-- Conteúdo -->
                        <tr>
                            <td style="padding: 40px 30px;">
                                {$conteudo}
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="background-color: #f8fafc; padding: 30px; text-align: center; border-top: 1px solid #e2e8f0;">
                                <p style="margin: 0 0 15px 0; font-size: 14px; color: #64748b;">
                                    <strong style="color: #1e293b;">Impermax Impermeabilização</strong>
                                </p>
                                <p style="margin: 0 0 10px 0; font-size: 13px; color: #64748b;">
                                    📞 (11) 9 4396-1031 | 📧 aleimpermax@gmail.com
                                </p>
                                <p style="margin: 0 0 15px 0; font-size: 12px; color: #94a3b8;">
                                    Impermeabilização de lajes • Piscinas • Banheiros • Fachadas
                                </p>
                                <div style="margin-top: 20px;">
                                    <a href="https://www.facebook.com/aleimpermax" style="text-decoration: none; margin: 0 8px;">
                                        <img src="https://img.icons8.com/color/32/000000/facebook.png" alt="Facebook" style="width: 28px; height: 28px;">
                                    </a>
                                    <a href="https://www.instagram.com/impermax_servicos" style="text-decoration: none; margin: 0 8px;">
                                        <img src="https://img.icons8.com/color/32/000000/instagram-new.png" alt="Instagram" style="width: 28px; height: 28px;">
                                    </a>
                                    <a href="https://wa.me/+5511999734979" style="text-decoration: none; margin: 0 8px;">
                                        <img src="https://img.icons8.com/color/32/000000/whatsapp.png" alt="WhatsApp" style="width: 28px; height: 28px;">
                                    </a>
                                </div>
                                <p style="margin: 20px 0 0 0; font-size: 11px; color: #94a3b8;">
                                    © 2025 Impermax. Todos os direitos reservados.
                                </p>
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Aviso de Email Automático -->
                    <table width="600" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                        <tr>
                            <td style="text-align: center; font-size: 12px; color: #94a3b8;">
                                <p style="margin: 0;">
                                    Este é um e-mail automático. Por favor, não responda diretamente.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
    HTML;
        }

        /**
         * 🔐 Email: Esqueci a Senha -- acho q o professor vai fazer com a gente ? - deixar por último
         */
        public function esqueciASenha(string $email, string $token): void {
            $resetUrl = $this->baseUrl . '/backend/redefinir-senha?token=' . urlencode($token); // criei a view mas preciso fazer ela funcionar agora, checar model usuario e authcontroller ⚠️
            
            $conteudo = <<<HTML
    <h2 style="margin: 0 0 20px 0; color: #1e293b; font-size: 24px;">Redefinição de Senha</h2>

    <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Recebemos uma solicitação para redefinir a senha da sua conta Impermax.
    </p>

    <p style="margin: 0 0 25px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Clique no botão abaixo para criar uma nova senha:
    </p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{$resetUrl}" style="display: inline-block; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);">
            🔑 Redefinir Senha
        </a>
    </div>

    <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 6px; margin: 25px 0;">
        <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;">
            ⚠️ <strong>Importante:</strong> Este link expira em <strong>1 hora</strong> por segurança.
        </p>
    </div>

    <p style="margin: 25px 0 0 0; color: #64748b; font-size: 14px; line-height: 1.6;">
        Se você não solicitou esta redefinição, pode ignorar este e-mail com segurança. Sua senha permanecerá inalterada.
    </p>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
        <p style="margin: 0; color: #94a3b8; font-size: 13px;">
            Se o botão não funcionar, copie e cole este link no seu navegador:
        </p>
        <p style="margin: 10px 0 0 0; color: #1487df; font-size: 12px; word-break: break-all;">
            {$resetUrl}
        </p>
    </div>
    HTML;

            $html = $this->getEmailTemplate('Redefinição de Senha', $conteudo, '#ef4444');
            $this->emailService->send($email, 'Redefinição de Senha - Impermax', $html);
        }

        /**
         * 👋 Email: Boas-vindas (Novo Cadastro) -- feito! ✅
         */
        public function boasVindas(string $email, string $nome): void {
            $loginUrl = $this->baseUrl . 'backend/login';
            $siteUrl = $this->baseUrl;
            
            $conteudo = <<<HTML
    <h2 style="margin: 0 0 10px 0; color: #1e293b; font-size: 28px;">Bem-vindo à Impermax! 🎉</h2>

    <p style="margin: 0 0 25px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Olá, <strong style="color: #1487df;">{$nome}</strong>!
    </p>

    <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Ficamos muito felizes em tê-lo(a) conosco! Sua conta foi criada com sucesso e agora você faz parte da família Impermax.
    </p>

    <div style="background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%); border-radius: 10px; padding: 25px; margin: 25px 0;">
        <h3 style="margin: 0 0 15px 0; color: #1e293b; font-size: 18px;">✨ O que você pode fazer agora:</h3>
        <ul style="margin: 0; padding-left: 20px; color: #475569; font-size: 15px; line-height: 1.8;">
            <li>Avaliar nossos serviços e compartilhar sua experiência</li>
            <!-- <li>Acompanhar suas solicitações de orçamento</li> -->
            <li>Receber notificações sobre seus agendamentos</li>
            <li>Acessar conteúdo exclusivo sobre impermeabilização</li>
        </ul>
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{$loginUrl}" style="display: inline-block; background: linear-gradient(135deg, #1487df 0%, #0e6eb8 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 12px rgba(20, 135, 223, 0.3);">
            🚀 Acessar Minha Conta
        </a>
    </div>

    <div style="background-color: #dcfce7; border-left: 4px solid #22c55e; padding: 15px; border-radius: 6px; margin: 25px 0;">
        <p style="margin: 0; color: #166534; font-size: 14px; line-height: 1.6;">
            💡 <strong>Dica:</strong> Salve nossos contatos para facilitar a comunicação!
        </p>
    </div>

    <p style="margin: 25px 0 0 0; color: #64748b; font-size: 15px; line-height: 1.6;">
        Estamos aqui para ajudar! Se tiver alguma dúvida, entre em contato conosco.
    </p>

    <p style="margin: 20px 0 0 0; color: #475569; font-size: 15px; line-height: 1.6;">
        Atenciosamente,<br>
        <strong style="color: #1487df;">Equipe Impermax</strong> 💙
    </p>
    HTML;

            $html = $this->getEmailTemplate('Bem-vindo à Impermax!', $conteudo);
            $this->emailService->send($email, 'Bem-vindo(a) à Impermax! 🎉', $html);
        }

        /**
         * ✅ Email: Avaliação Aprovada -- nao ta funcionando fazer quando der kkkkkk
         */
        public function avaliacaoAprovada(string $email, string $nome): void {
            $siteUrl = $this->baseUrl;
            
            $conteudo = <<<HTML
    <h2 style="margin: 0 0 10px 0; color: #1e293b; font-size: 24px;">Sua Avaliação foi Aprovada! ⭐</h2>

    <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Olá, <strong style="color: #1487df;">{$nome}</strong>!
    </p>

    <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Temos ótimas notícias! Sua avaliação sobre nossos serviços foi aprovada e já está publicada em nosso site.
    </p>

    <div style="background-color: #dcfce7; border-left: 4px solid #22c55e; padding: 20px; border-radius: 8px; margin: 25px 0;">
        <p style="margin: 0 0 10px 0; color: #166534; font-size: 16px;">
            <strong>🎉 Obrigado por compartilhar sua experiência!</strong>
        </p>
        <p style="margin: 0; color: #166534; font-size: 14px; line-height: 1.6;">
            Sua opinião é muito importante para nós e ajuda outros clientes a conhecerem nosso trabalho.
        </p>
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{$siteUrl}" style="display: inline-block; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);">
            👀 Ver Minha Avaliação
        </a>
    </div>

    <p style="margin: 25px 0 0 0; color: #64748b; font-size: 15px; line-height: 1.6;">
        Agradecemos pela confiança e esperamos atendê-lo(a) novamente em breve!
    </p>
    HTML;

            $html = $this->getEmailTemplate('Avaliação Aprovada', $conteudo, '#22c55e');
            $this->emailService->send($email, 'Sua Avaliação foi Aprovada! ⭐ - Impermax', $html);
        }

        /**
         * 📅 Email: Confirmação de Agendamento -- mesma coisa de orcamentoaprovado - não sei fazer, pesquisar depois
         */
        public function agendamentoConfirmado(string $email, string $nome, string $dataAgendamento, string $servico): void {
            $conteudo = <<<HTML
    <h2 style="margin: 0 0 10px 0; color: #1e293b; font-size: 24px;">Agendamento Confirmado! 📅</h2>

    <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Olá, <strong style="color: #1487df;">{$nome}</strong>!
    </p>

    <p style="margin: 0 0 25px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Seu agendamento foi confirmado com sucesso. Confira os detalhes abaixo:
    </p>

    <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 10px; padding: 25px; margin: 25px 0;">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="padding: 10px 0; color: #64748b; font-size: 14px; font-weight: 600;">📅 Data e Hora:</td>
                <td style="padding: 10px 0; color: #1e293b; font-size: 15px; font-weight: 700; text-align: right;">{$dataAgendamento}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; color: #64748b; font-size: 14px; font-weight: 600; border-top: 1px solid #cbd5e1;">🛠️ Serviço:</td>
                <td style="padding: 10px 0; color: #1e293b; font-size: 15px; font-weight: 700; text-align: right; border-top: 1px solid #cbd5e1;">{$servico}</td>
            </tr>
        </table>
    </div>

    <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 6px; margin: 25px 0;">
        <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;">
            📞 <strong>Importante:</strong> Entraremos em contato 1 dia antes para confirmar sua presença.
        </p>
    </div>

    <p style="margin: 25px 0 0 0; color: #64748b; font-size: 15px; line-height: 1.6;">
        Qualquer dúvida, estamos à disposição nos telefones: <strong>(11) 9 4396-1031</strong>
    </p>
    HTML;

            $html = $this->getEmailTemplate('Agendamento Confirmado', $conteudo, '#1487df');
            $this->emailService->send($email, 'Agendamento Confirmado - Impermax 📅', $html);
        }

        /**
         * 💰 Email: Orçamento Aprovado -- feito! ✅
         */
        public function orcamentoAprovado(string $email, string $nome, string $numeroOrcamento, string $valor): void {
            $conteudo = <<<HTML
    <h2 style="margin: 0 0 10px 0; color: #1e293b; font-size: 24px;">Orçamento Aprovado! 💰</h2>

    <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Olá, <strong style="color: #1487df;">{$nome}</strong>!
    </p>

    <p style="margin: 0 0 25px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Seu orçamento foi aprovado! Vamos iniciar o serviço em breve.
    </p>

    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 10px; padding: 25px; margin: 25px 0; text-align: center;">
        <p style="margin: 0 0 10px 0; color: #64748b; font-size: 14px; font-weight: 600;">Orçamento Nº</p>
        <p style="margin: 0 0 20px 0; color: #1e293b; font-size: 28px; font-weight: 700;">{$numeroOrcamento}</p>
        <p style="margin: 0 0 5px 0; color: #64748b; font-size: 14px; font-weight: 600;">Valor Total</p>
        <p style="margin: 0; color: #22c55e; font-size: 32px; font-weight: 700;">R$ {$valor}</p>
    </div>

    <div style="background-color: #dbeafe; border-left: 4px solid #1487df; padding: 15px; border-radius: 6px; margin: 25px 0;">
        <p style="margin: 0; color: #1e40af; font-size: 14px; line-height: 1.6;">
            📋 <strong>Próximos Passos:</strong> Nossa equipe entrará em contato para agendar o início do serviço.
        </p>
    </div>

    <p style="margin: 25px 0 0 0; color: #64748b; font-size: 15px; line-height: 1.6;">
        Agradecemos pela confiança! Estamos ansiosos para realizar um excelente trabalho.
    </p>
    HTML;

            $html = $this->getEmailTemplate('Orçamento Aprovado', $conteudo, '#22c55e');
            
            $this->emailService->send($email, 'Orçamento Aprovado - Impermax 💰', $html);
        }

        /**
         * 📧 Email: Contato Recebido (Confirmação) -- feito! ✅
         */
        public function contatoRecebido(string $email, string $nome): void {
            $whatsappUrl = 'https://wa.me/5511999734979';
            
            $conteudo = <<<HTML
    <h2 style="margin: 0 0 10px 0; color: #1e293b; font-size: 24px;">Mensagem Recebida! 📧</h2>

    <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Olá, <strong style="color: #1487df;">{$nome}</strong>!
    </p>

    <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        Recebemos sua mensagem e agradecemos pelo contato!
    </p>

    <div style="background-color: #dcfce7; border-left: 4px solid #22c55e; padding: 20px; border-radius: 8px; margin: 25px 0;">
        <p style="margin: 0 0 10px 0; color: #166534; font-size: 15px; line-height: 1.6;">
            <strong>✅ Nossa equipe analisará sua solicitação e responderá em breve!</strong>
        </p>
        <p style="margin: 0; color: #166534; font-size: 14px; line-height: 1.6;">
            Geralmente respondemos em até <strong>24 horas úteis</strong>.
        </p>
    </div>

    <p style="margin: 25px 0 15px 0; color: #475569; font-size: 16px; line-height: 1.6;">
        <strong>Precisa de uma resposta mais rápida?</strong>
    </p>

    <div style="text-align: center; margin: 25px 0;">
        <a href="{$whatsappUrl}" style="display: inline-block; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);">
            💬 Fale Conosco no WhatsApp
        </a>
    </div>

    <p style="margin: 25px 0 0 0; color: #64748b; font-size: 14px; line-height: 1.6;">
        📞 Telefone: (11) 9 4396-1031<br>
        📧 E-mail: aleimpermax@gmail.com
    </p>
    HTML;

            $html = $this->getEmailTemplate('Mensagem Recebida', $conteudo, '#22c55e');
            $this->emailService->send($email, 'Mensagem Recebida - Impermax 📧', $html);
        }
}