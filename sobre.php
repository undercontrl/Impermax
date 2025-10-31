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
        </div>
    </div>
    <nav class="header-primario">
        <a href="index.html">
            <img src="assets/icons/impermax-LOGO.svg" alt="Impermax Logo" class="logo">
        </a>
        <ul class="menu-nav">
            <li><a href="index.html">INICIO</a></li>
            <li><a href="sobre.html">SOBRE</a></li>
            <li><a href="servicos.html">SERVIÇOS</a></li>
            <li><a href="projetos.html">PROJETOS</a></li>
            <li><a href="#contato">CONTATO</a></li>
        </ul>
    </nav>
   </header>
   <main>
        <section class="parallax-sobre">
            <h3 class="titulo-sobre">Sobre Nós</h3>
        </section>

        <section class="historia">
            <div class="container-historia">
            <div class="container-sobre">
            <h2 class="titulo-historia">Nossa história</h2>
            <p class="texto-historia">A <span class="texto-destaque">Impermax</span> nasceu em 2017, fundada por Alessandro Custódio, com o objetivo de oferecer soluções confiáveis e especializadas em impermeabilização para obras residenciais, comerciais e industriais.
                <br>Desde o início, a empresa se destacou pela seriedade no atendimento e pelo compromisso com a qualidade técnica. Com uma atuação focada em proteger estruturas contra infiltrações, vazamentos e umidade, a Impermax construiu sua reputação com base na confiança, no profissionalismo e na entrega de resultados duradouros.
                 </p>
            </div>
            <img src="assets/icons/impermax-LOGO.svg" alt="impermax" class="logo-historia">
            </div>
        </section>

        <section class="icones">

                <div class="container-icones">
                    <div class="card-sobre" id="missao">
                        <img src="assets/icons/missao.svg" alt="Nossa missão" class="icons-sobre">
                        <h2 class="titulo-missao">Nossa Missão</h2>
                        <p class="texto-missao">Proteger e valorizar construções por meio de soluções eficazes de impermeabilização.</p>
                    </div>

                    <div class="card-sobre">
                        <img src="assets/icons/visao.svg" alt="Nossa visão" class="icons-sobre">
                        <h2 class="titulo-missao">Nossa Visão</h2>
                        <p class="texto-missao">Ser referência no mercado pela excelência dos serviços e satisfação dos nossos clientes.</p>
                    </div>

                    <div class="card-sobre">
                        <img src="assets/icons/valores.svg" alt="Nossos valores" class="icons-sobre">
                        <h2 class="titulo-missao">Nossos valores</h2>
                        <p class="texto-missao">Qualidade</p>
                        <p class="texto-missao">Responsabilidade</p>
                        <p class="texto-missao">Comprometimento</p>

                    </div>
                </div>
        </section>
          <section class="historia2">
            <div class="container-historia2">
            <div class="container-sobre">
            <h2 class="titulo-historia">Nossa história</h2>
            <p class="texto-historia">Com o passar dos anos, a equipe cresceu, novas tecnologias foram incorporadas aos serviços e o atendimento se expandiu, mas os valores essenciais permanecem os mesmos: <span class="texto-destaque">excelência, pontualidade e respeito ao cliente</span>.
                <br>Hoje, a <span class="texto-destaque">Impermax</span> é reconhecida por sua atuação em diversos tipos de impermeabilização, sempre utilizando materiais de alta qualidade e mão de obra especializada, garantindo segurança e tranquilidade em cada projeto.</p>
            </div>
            <img src="assets/img/MARIA.jpg" alt="impermax" class="logo-historia2">
            </div>
    </section>



    <!-- decidir se fica ou não com a caixa orçamento na pagina sobre -->

    <section class="parallax" id="contato">
        <div class="bloco-contato">
                <div id="caixa-orcamento2">
                    <h3>ENTRE EM CONTATO E FAÇA O SEU ORÇAMENTO!</h3>
                    <form action="backend/enviar-contato" method="POST" id="form-contato-topo4">
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
                    <div id="mensagem-flash-topo4"></div>
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

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script src="js/formulario.js"></script>
</body>
</html>