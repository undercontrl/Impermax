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
</head>
<body>
   <header>
    <div class="header-secundario">
            <span class="span-header"><img src="assets/icons/telefone-icon2.svg" alt="Icone Telefone" class="icon">(11) 9 4396-1031</span>
            <span class="span-header"><img src="assets/icons/email-icon2.svg" alt="Icone Email" class="icon">aleimpermax@gmail.com</span>
        <div class="container-header-secundario">
            <a href="https://www.facebook.com/aleimpermax" target="_blank" class="ancora-header-secundaria"><img src="assets/icons/facebook 1.svg" alt="Facebook" class="icon-redes"></a>
            <a href="https://www.instagram.com/impermax_servicos?igsh=cHM2MW82a3lqOHNl" target="_blank" class="ancora-header-secundaria"><img src="assets/icons/instagram 1.svg" alt="Instagram" class="icon-redes"></a>
            <a href="https://wa.me/+5511999734979" target="_blank" class="ancora-header-secundaria"><img src="assets/icons/whatsapp 1.svg" alt="WhatsApp" class="icon-redes"></a>
        </div>
    </div>
    <nav class="header-primario">
        <a href="index.php">
            <img src="assets/icons/impermax-LOGO.svg" alt="Impermax Logo" class="logo">
        </a>
        <ul class="menu-nav">
            <li><a href="index.php">INICIO</a></li>
            <li><a href="sobre.php">SOBRE</a></li>
            <li><a href="servicos.php">SERVIÇOS</a></li>
            <li><a href="projetos.php">PROJETOS</a></li>
            <li><a href="contato.php">CONTATO</a></li>
        </ul>
    </nav>
   </header>
   <main>

 <section class="parallax-servicos">
        <h3 class="titulo-servicos">Serviços</h3>
    </section>
    <!-- <section class="tipo-servico">
            <img src="assets/icons/engrenagem.svg" class="icone-pagina-servico" >
                <p class="texto-pagina-servico">Página em construção</p>
            </div>
        </div>
    </section> -->
    <section id="servicos" class="services container">
    <h2 class="section-title">Nossos Serviços</h2>
        <div class="services-grid">
        
        <div class="service-item">
            <i class="fas fa-home"></i>
            <h3>Impermeabilização de Lajes</h3>
            <p>Proteção completa da laje exposta, evitando infiltrações e garantindo durabilidade.</p>
        </div>

        <div class="service-item">
            <i class="fas fa-swimming-pool"></i>
            <h3>Impermeabilização de Piscinas</h3>
            <p>Sistema de alta estanqueidade para piscinas em concreto ou alvenaria.</p>
        </div>

        <div class="service-item">
            <i class="fas fa-bath"></i>
            <h3>Áreas Molhadas e Banheiros</h3>
            <p>Membrana líquida para vedação total de piso e paredes em áreas molhadas.</p>
        </div>

        <div class="service-item">
            <i class="fas fa-umbrella"></i>
            <h3>Impermeabilização de Telhados</h3>
            <p>Manta asfáltica ou polímeros para proteger coberturas contra chuva e umidade.</p>
        </div>

        <div class="service-item">
            <i class="fas fa-building"></i>
            <h3>Vedação de Fachadas</h3>
            <p>Tratamento de trincas e aplicação de vedantes para proteger paredes externas.</p>
        </div>

        <div class="service-item">
            <i class="fas fa-water"></i>
            <h3>Caixas d’Água e Reservatórios</h3>
            <p>Argamassa polimérica para garantir estanqueidade e potabilidade da água.</p>
        </div>

        <div class="service-item">
            <i class="fas fa-layer-group"></i>
            <h3>Aplicação de Manta Asfáltica</h3>
            <p>Instalação soldada a quente de manta asfáltica para barreira impermeável.</p>
        </div>

        <div class="service-item">
            <i class="fas fa-shield-alt"></i>
            <h3>Tratamento de Umidade</h3>
            <p>Secagem e selagem de paredes para eliminar mofo, salitre e infiltrações.</p>
        </div>

        </div>
  </section>
  <section class="parallax" id="contato">
        <div class="bloco-contato">
                <div id="caixa-orcamento2">
                    <h3>ENTRE EM CONTATO E FAÇA O SEU ORÇAMENTO!</h3>
                    <form action="backend/enviar-contato" method="POST" id="form-contato-topo5">
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
                    <div id="mensagem-flash-topo5"></div>
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
                <a href="index.php">
                    <img src="assets/icons/impermax-LOGO.svg" alt="Impermax Logo" class="logo-footer-img">
                </a>
            </div>
            <div class="redes-sociais">
                <a href="https://www.facebook.com/aleimpermax" target="_blank"><img src="assets/icons/facebook 1.svg" alt="Facebook"></a>
                <a href="https://www.instagram.com/impermax_servicos?igsh=cHM2MW82a3lqOHNl" target="_blank"><img src="assets/icons/instagram 1.svg" alt="Instagram"></a>
                <a href="https://wa.me/+5511999734979" target="_blank"><img src="assets/icons/whatsapp 1.svg" alt="WhatsApp"></a>
            </div>
        </div>
        <div class="linha-servicos">Impermeabilização de lajes • Piscinas • Banheiros • Paredes • Fachadas • Caixas d’água • Manta asfáltica • Tratamento de umidade</div>
        <div class="rodape-final">Ctrl+Ari+Malu | Todos os Direitos Reservados | © 2025</div>
    </footer>
     <script src="js/formulario.js"></script>
</body>
</html>