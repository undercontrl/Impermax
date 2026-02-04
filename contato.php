<?php
require __DIR__.'/vendor/autoload.php';
use App\Impermax\Core\CSRF;
use App\Impermax\Core\Session;
session_start();
$codigoToken = CSRF::generate();
$secao= new Session();
$secao->set('csrf_token', $codigoToken);
?>
 
 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impermax Impermeabilização</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="images/png" href="assets/icons/water.png">
</head>
<body>
   <header>
    <div class="header-secundario">
            <span class="span-header"><img src="assets/icons/telefone-icon2.svg" alt="Icone Telefone" class="icon">(11) 9 4396-1031</span>
            <span class="span-header"><img src="assets/icons/email-icon2.svg" alt="Icone Email" class="icon">aleimpermax@gmail.com</span>
        <div class="container-header-secundario">
            <a href="https://www.facebook.com/aleimpermax" target="_blank" class="ancora-header-secundaria"><img src="assets/icons/facebook.svg" alt="Facebook" class="icon-redes"></a>
            <a href="https://www.instagram.com/impermax_servicos?igsh=cHM2MW82a3lqOHNl" target="_blank" class="ancora-header-secundaria"><img src="assets/icons/instagram.svg" alt="Instagram" class="icon-redes"></a>
            <a href="https://wa.me/+5511999734979" target="_blank" class="ancora-header-secundaria"><img src="assets/icons/whatsapp.svg" alt="WhatsApp" class="icon-redes"></a>
            <a href="/backend/login" class="ancora-header-secundaria btn-admin" title="Acesso Administrativo">
                <img src="assets/icons/user-lock.svg" alt="Admin" class="icon-redes">
            </a>
        </div>
    </div>
    <nav class="header-primario">
        <a href="index.php">
            <img src="assets/icons/impermax-LOGO.svg" alt="Impermax Logo" class="logo">
        </a>
        
        <!-- Hamburger Menu Button (Mobile Only) -->
        <button class="hamburger-menu" id="hamburger-btn" aria-label="Menu">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
        
        <ul class="menu-nav" id="menu-nav">
            <li><a href="index.php">INICIO</a></li>
            <li><a href="sobre.php">SOBRE</a></li>
            <li><a href="servicos.php">SERVIÇOS</a></li>
            <li><a href="projetos.php">PROJETOS</a></li>
            <li><a href="#contato">CONTATO</a></li>
        </ul>
    </nav>

        <main>
            <section class="parallax-contato">
                <div class="bloco-contato">
                    <div id="caixa-orcamento2">
                        <h3>ENTRE EM CONTATO E FAÇA O SEU ORÇAMENTO!</h3>
                        <form action="backend/enviar-contato" method="POST" id="form-contato-topo3">
                        <!-- CSRF TOKEN -->
                        <input type="hidden" name="csrf_token" value="<?= $codigoToken; ?>">
 
                        <!-- HONEYPOT (escondido) -->
                        <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
 
                        <input type="text" name="nome" placeholder="Nome" required>
                        <input type="tel" name="telefone" placeholder="Telefone" required>
                        <input type="email" name="email" placeholder="E-mail" required>
                        <select name="servico" required>
                            <option value="">Escolha o tipo de serviço</option>
                            <option value="residencial">Impermeabilização Residencial</option>
                            <option value="comercial">Impermeabilização Comercial</option>
                            <option value="telhado">Impermeabilização de Telhado</option>
                            <option value="laje">Impermeabilização de Laje</option>
                        </select>
                        <button type="submit">Enviar solicitação de orçamento</button>
                        </form>
                    <div id="mensagem-flash-topo3"></div>
                    </div>
                    <div class="whatsapp-contato">
                        <h2>Prefere falar direto pelo WhatsApp?</h2>
                        <p>Se preferir um contato direto e imediato, fale com um dos nossos especialistas pelo WhatsApp. Estamos prontos para esclarecer dúvidas, apresentar soluções e enviar orçamentos sob medida.</p>
                        <p>📞 <strong>Alessandro Custódio</strong><br>+55 11 99973-4979</p>
                        <p>📞 <strong>Lucas Guimarães</strong><br>+55 11 99380-5951</p>
                        <p>Entre em contato e tenha um atendimento ágil, profissional e sem compromisso!</p>
                    </div>
                </div>
            </section>
            
        </main>
    <footer id="footer-impermax">
        <div class="footer-conteudo">
            <div class="logo-footer">
                <a href="index.html">
                    <img src="assets/icons/impermax-LOGO.svg" alt="Impermax Logo" class="logo-footer-img">
                </a>
            </div>
            <div class="redes-sociais">
                <a href="https://www.facebook.com/aleimpermax" target="_blank"><img src="assets/icons/facebook.svg" alt="Facebook"></a>
                <a href="https://www.instagram.com/impermax_servicos?igsh=cHM2MW82a3lqOHNl" target="_blank"><img src="assets/icons/instagram.svg" alt="Instagram"></a>
                <a href="https://wa.me/+5511999734979" target="_blank"><img src="assets/icons/whatsapp.svg" alt="WhatsApp"></a>
            </div>
        </div>
        <div class="linha-servicos">Impermeabilização de lajes • Piscinas • Banheiros • Paredes • Fachadas • Caixas d’água • Manta asfáltica • Tratamento de umidade</div>
        <div class="rodape-final">Ctrl+Ari+Malu | Todos os Direitos Reservados | © 2025</div>
    </footer>

    <div class="menu-overlay" id="menu-overlay"></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerBtn = document.getElementById('hamburger-btn');
            const menuNav = document.getElementById('menu-nav');
            const menuOverlay = document.getElementById('menu-overlay');
            
            if (hamburgerBtn && menuNav && menuOverlay) {
                hamburgerBtn.addEventListener('click', function() {
                    hamburgerBtn.classList.toggle('active');
                    menuNav.classList.toggle('active');
                    menuOverlay.classList.toggle('active');
                    
                    if (menuNav.classList.contains('active')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                });
                
                menuOverlay.addEventListener('click', function() {
                    hamburgerBtn.classList.remove('active');
                    menuNav.classList.remove('active');
                    menuOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
                
                const menuLinks = menuNav.querySelectorAll('a');
                menuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        hamburgerBtn.classList.remove('active');
                        menuNav.classList.remove('active');
                        menuOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                });
            }
        });
    </script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script src="js/formulario.js"></script>
    </body>
    </html>