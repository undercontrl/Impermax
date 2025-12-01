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
        <ul class="menu-nav">
            <li><a href="index.php">INICIO</a></li>
            <li><a href="sobre.php">SOBRE</a></li>
            <li><a href="servicos.php">SERVIÇOS</a></li>
            <li><a href="projetos.php">PROJETOS</a></li>
            <li><a href="#contato">CONTATO</a></li>
        </ul>
    </nav>
   </header>
   <main>
        <section class="hero">
            <!-- Conteúdo à Esquerda -->
            <div class="hero-content">
                <h3 class="titulo-hero">Seja Bem-Vindo à Impermax!</h3>
                <p class="texto-hero">Especialistas em Impermeabilização Residencial e Comercial</p>
            </div>

            <!-- Formulário à Direita -->
            <div id="caixa-orcamento">
                <h3>ENTRE EM CONTATO E FAÇA O SEU ORÇAMENTO!</h3>
                <form action="backend/enviar-contato" method="POST" id="form-contato-topo">
                    <input type="hidden" name="csrf_token" value="<?= $codigoToken; ?>">
                    <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
                    
                    <input type="text" name="nome" placeholder="Nome completo" required>
                    <input type="tel" name="telefone" placeholder="Telefone" required>
                    <input type="email" name="email" placeholder="E-mail" required>
                    <select name="servico" required>
                        <option value="">Escolha o tipo de serviço</option>
                        <option value="residencial">Impermeabilização Residencial</option>
                        <option value="comercial">Impermeabilização Comercial</option>
                        <option value="telhado">Impermeabilização de Telhado</option>
                        <option value="laje">Impermeabilização de Laje</option>
                    </select>
                    <button type="submit">Enviar Solicitação</button>
                </form>
                <div id="mensagem-flash-topo"></div>
            </div>
        </section>
        <section class="quem-somos">
            <h2 class="titulo-quem-somos">Quem Somos</h2>
            <h3 class="subtitulo-quem-somos">Soluções Profissionais em Impermeabilização</h2>
            <P class="texto-quem-somos">A <a href="index.php" class="texto-destaque">Impermax</a> oferece serviços especializados para proteger sua construção contra infiltrações e umidade. Atuamos em pisos, lajes, telhados, banheiros, piscinas e muito mais, com qualidade, compromisso e os melhores materiais do mercado.</P>
            <a class="botao-saiba-mais" href="sobre.php">Saiba Mais</a>
        </section>
        <section>

         <section class="servicos">
            <div class="container-servicos">
                <h3 class="titulo-servico">Serviços</h3>
                <div class="cards" id="cards-container">
                    <!-- Cards serão inseridos aqui via JS -->
                    <p class="loading">Carregando serviços...</p>
                </div>
                <div class="titulo-externo" id="titulos-externos">
                    <!-- Títulos externos serão gerados dinamicamente -->
                </div>
            </div>
        </section>


            <!-- <section class="servicos">
               <div class="container-servicos">
                   <h3 class="titulo-servico">Serviços</h3>
                   <div class="cards">
                       <div class="card-servico">
                           <a href="servicos.php">
                                <figure>
                                    <img src="assets/cards/card1.png" alt="" class="servico-imagem">
                                    <figcaption class="figcaption-servico">
                                        <p class="titulo-interno">Evita <span class="texto-destaque">infiltrações</span> em áreas expostas ao tempo, 
                                            aumentando a durabilidade da estrutura.</p>
                                    </figcaption>
                                </figure>
                           </a>
                       </div>
                       <div class="card-servico">
                           <a href="servicos.php">
                                <figure>
                                    <img src="assets/cards/card2.png" alt="" class="servico-imagem">
                                    <figcaption class="figcaption-servico">
                                        <p class="titulo-interno">Soluções específicas para áreas em contato constante 
                                            com água, garantindo total <span class="texto-destaque">estanqueidade</span>.</p>
                                    </figcaption>
                                </figure>
                           </a>
                       </div>
                       <div class="card-servico">
                           <a href="servicos.php">
                                <figure>
                                    <img src="assets/cards/card3.png" alt="" class="servico-imagem">
                                <figcaption class="figcaption-servico">
                                        <p class="titulo-interno">Proteção contra <span class="texto-destaque">vazamentos</span> e umidade em áreas internas 
                                            com alto uso de água.</p>
                                    </figcaption></a>
                                </figure>
                           </a>
                       </div>
                   </div>
                   <div class="titulo-externo">
                       <h3 id="titulo-externo1">Impermeabilização de Lajes</h3>
                       <h3 id="titulo-externo2">Vedação de Piscinas e Reservatórios</h3>
                       <h3 id="titulo-externo3">Impermeabilização de Banheiros</h3>
                   </div>
   
               </div>
                </section> -->
            <!-- <section class="antes-depois">
                <div class="img-comp-container">
                    <div class="img-comp-img">
                    <img src="assets/antes e depois/dpois.png" width="500" height="350">
                    </div>
                    <div class="img-comp-img img-comp-overlay">
                    <img src="assets/antes e depois/antes.png" width="500" height="350">
                    </div>
                </div>
                <h1 class="titulo-antes-depois">Confira Nossos Resultados</h1>
                <h2 class="subtitulo-antes-depois">Impermeabilização de Piscina</h2>
                <p class="texto-antes-depois">Nesta etapa da obra, executamos a <span class="texto-destaque">impermeabilização completa da estrutura da piscina</span>, aplicando técnicas especializadas para garantir máxima proteção contra infiltrações e vazamentos. O serviço foi realizado sobre base de concreto, preparando a área para receber o acabamento final com total segurança e durabilidade.
                    A impermeabilização é fundamental para preservar a integridade da piscina e evitar futuros problemas com umidade.</p>
            </section>
            <script src="js/javascript.js"></script>
            <script>initComparisons();</script> -->

    <section class="antes-depois" id="projetos-container">
        <div class="texto-content">
            <h1 class="titulo-antes-depois">Confira Nossos Resultados</h1>
            <h2 class="subtitulo-antes-depois">Impermeabilização de Piscina</h2>
            <p class="texto-antes-depois">
                Nesta etapa da obra, executamos a <span class="texto-destaque">impermeabilização completa da estrutura da piscina</span>, 
                aplicando técnicas especializadas para garantir máxima proteção contra infiltrações e vazamentos. O serviço foi realizado sobre base de concreto, preparando a área para receber o acabamento final com total segurança e durabilidade.
                    A impermeabilização é fundamental para preservar a integridade da piscina e evitar futuros problemas com umidade.
            </p>
        </div>
        
        <div id="comparisons-container">
            <!-- SERÁ PREENCHIDO DINAMICAMENTE -->
        </div>
    </section>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('/backend/api/projetos')
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success' && result.data.length > 0) {
                    const container = document.getElementById('comparisons-container');
                    container.innerHTML = ''; // Limpa

                    result.data.forEach(projeto => {
                        const div = document.createElement('div');
                        div.className = 'img-comp-container';
                        div.innerHTML = `
                            <div class="img-comp-img">
                                <img src="${projeto.depois}" width="500" height="350" alt="Depois">
                            </div>
                            <div class="img-comp-img img-comp-overlay">
                                <img src="${projeto.antes}" width="500" height="350" alt="Antes">
                            </div>
                        `;
                        container.appendChild(div);
                    });

                    // Reinicar comparações
                    setTimeout(initComparisons, 100);
                } else {
                    container.innerHTML = '';
                
                }
            })
            .catch(err => {
                console.error('Erro ao carregar projetos:', err);
                document.getElementById('comparisons-container').innerHTML = '';
            });
    });
    </script>

    <script src="js/javascript.js"></script>
    <script>initComparisons();</script>


            <section class="parallax" id="contato">
                <div class="bloco-contato">
                    <div id="caixa-orcamento2">
                        <h3>ENTRE EM CONTATO E FAÇA O SEU ORÇAMENTO!</h3>
                        <form action="backend/enviar-contato" method="POST" id="form-contato-topo2">
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
                        <div id="mensagem-flash-topo2"></div>
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

    <!-- Aba de serviços - carregamento dinâmico via JS -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const cardsContainer = document.getElementById('cards-container');
        const titulosContainer = document.getElementById('titulos-externos');

        if (!cardsContainer || !titulosContainer) return;

        cardsContainer.innerHTML = '<p class="loading">Carregando serviços...</p>';

        fetch('/backend/api/servicos')
            .then(response => {
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                return response.json();
            })
            .then(json => {
                if (json.status !== 'success' || !Array.isArray(json.data)) {
                    throw new Error('Dados inválidos');
                }

                const servicos = json.data;
                if (servicos.length === 0) {
                    cardsContainer.innerHTML = '<p style="color:#ccc;text-align:center;">Nenhum serviço ativo.</p>';
                    titulosContainer.innerHTML = '';
                    return;
                }

                // Limpa
                cardsContainer.innerHTML = '';
                titulosContainer.innerHTML = '';

                servicos.forEach(servico => {
                    // CARD
                    const cardHtml = `
                        <div class="card-servico">
                            <a href="servicos.php">
                                <figure>
                                    <img src="${servico.caminho_imagem}" 
                                        alt="${servico.nome_servico}" 
                                        class="servico-imagem"
                                        onerror="this.onerror=null; this.src='assets/cards/default.jpg';">
                                    <figcaption class="figcaption-servico">
                                        <p class="titulo-interno">
                                            ${servico.descricao_servico.replace(/<span[^>]*>([^<]+)<\/span>/g, '<span class="texto-destaque">$1</span>')}
                                        </p>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                    `;
                    cardsContainer.insertAdjacentHTML('beforeend', cardHtml);

                    // TÍTULO EXTERNO
                    const tituloHtml = `<h3 class="titulo-externo-item">${servico.nome_servico}</h3>`;
                    titulosContainer.insertAdjacentHTML('beforeend', tituloHtml);
                });

                // Ajusta gap
                titulosContainer.style.gap = '130px';
            })
            .catch(err => {
                console.error(err);
                cardsContainer.innerHTML = '<p style="color:#ff6b6b">Erro ao carregar.</p>';
            });
    });
    </script>
</body>
</html>
