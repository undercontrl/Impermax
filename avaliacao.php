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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
   <main class="main-avaliacao">
    <section class="avaliacao-section">
        <div class="container-avaliacao">
            <!-- Header -->
            <div class="avaliacao-header">
                <div class="header-icon">
                    <i class="bi bi-star-fill"></i>
                </div>
                <h1 class="avaliacao-titulo">Conte sua Experiência</h1>
                <p class="avaliacao-subtitulo">
                    Sua opinião é muito importante para nós! Compartilhe como foi sua experiência com nossos serviços.
                </p>
            </div>

            <!-- Formulário -->
            <div class="avaliacao-card">
                <form action="/enviar-avaliacao" method="POST" id="formAvaliacao" class="avaliacao-form">
                    
                    <!-- Nome -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-person-fill"></i>
                            Seu Nome <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nome_cliente" 
                            id="nomeCliente"
                            class="form-input" 
                            placeholder="Digite seu nome completo"
                            required
                        >
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-envelope-fill"></i>
                            Seu E-mail <span class="required">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="email_cliente" 
                            id="emailCliente"
                            class="form-input" 
                            placeholder="seu@email.com"
                            required
                        >
                        <small class="form-hint">Não será exibido publicamente</small>
                    </div>

                    <!-- Avaliação em Estrelas -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-star-fill"></i>
                            Sua Avaliação <span class="required">*</span>
                        </label>
                        <div class="rating-container">
                            <div class="stars-wrapper">
                                <input type="radio" name="nota_avaliacao" value="5" id="star5" required>
                                <label for="star5" class="star" title="Excelente">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                                
                                <input type="radio" name="nota_avaliacao" value="4" id="star4">
                                <label for="star4" class="star" title="Muito Bom">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                                
                                <input type="radio" name="nota_avaliacao" value="3" id="star3">
                                <label for="star3" class="star" title="Bom">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                                
                                <input type="radio" name="nota_avaliacao" value="2" id="star2">
                                <label for="star2" class="star" title="Regular">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                                
                                <input type="radio" name="nota_avaliacao" value="1" id="star1">
                                <label for="star1" class="star" title="Ruim">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                            </div>
                            <div class="rating-text" id="ratingText">Clique nas estrelas para avaliar</div>
                        </div>
                    </div>

                    <!-- Comentário -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-chat-left-text-fill"></i>
                            Seu Comentário <span class="required">*</span>
                        </label>
                        <textarea 
                            name="descricao_avaliacao" 
                            id="descricaoAvaliacao"
                            class="form-textarea" 
                            placeholder="Conte-nos sobre sua experiência com nossos serviços..."
                            rows="5"
                            maxlength="500"
                            required
                        ></textarea>
                        <div class="char-counter">
                            <span id="charCount">0</span>/500 caracteres
                        </div>
                    </div>

                    <!-- Termos -->
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="aceita_termos" id="aceitaTermos" required>
                            <span class="checkbox-text">
                                Concordo que minha avaliação seja publicada no site da Impermax <span class="required">*</span>
                            </span>
                        </label>
                    </div>

                    <!-- Hidden field para status -->
                    <input type="hidden" name="status_avaliacao" value="Pendente">

                    <!-- Botão de Envio -->
                    <div class="form-actions">
                        <button type="submit" class="btn-submit" id="btnSubmit">
                            <i class="bi bi-send-fill"></i>
                            Enviar Avaliação
                        </button>
                    </div>
                </form>

                <!-- Mensagem de Sucesso -->
                <div class="success-message" id="successMessage" style="display: none;">
                    <div class="success-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h3>Avaliação Enviada com Sucesso!</h3>
                    <p>Obrigado por compartilhar sua experiência conosco. Sua avaliação será analisada e publicada em breve.</p>
                    <button class="btn-nova-avaliacao" onclick="resetarFormulario()">
                        <i class="bi bi-plus-circle"></i>
                        Enviar Outra Avaliação
                    </button>
                </div>
            </div>

            <!-- Cards de Benefícios -->
            <!-- <div class="beneficios-grid">
                <div class="beneficio-card">
                    <div class="beneficio-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4>100% Seguro</h4>
                    <p>Seus dados estão protegidos</p>
                </div>
                <div class="beneficio-card">
                    <div class="beneficio-icon">
                        <i class="bi bi-eye-slash"></i>
                    </div>
                    <h4>E-mail Privado</h4>
                    <p>Não será exibido publicamente</p>
                </div>
                <div class="beneficio-card">
                    <div class="beneficio-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4>Análise Rápida</h4>
                    <p>Publicação em até 24 horas</p>
                </div>
            </div> -->
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
                        <a href="servicos.html?id=${servico.id_servico}">
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
            titulosContainer.style.gap = '100px';
        })
        .catch(err => {
            console.error(err);
            cardsContainer.innerHTML = '<p style="color:#ff6b6b">Erro ao carregar.</p>';
        });
});

// Atualizar texto da avaliação
const stars = document.querySelectorAll('.star');
const ratingText = document.getElementById('ratingText');
const ratingTexts = {
    5: '⭐ Excelente! Ficamos felizes!',
    4: '⭐ Muito Bom! Obrigado!',
    3: '⭐ Bom! Agradecemos!',
    2: '⭐ Regular. Como podemos melhorar?',
    1: '⭐ Ruim. Sentimos muito!'
};

document.querySelectorAll('input[name="nota_avaliacao"]').forEach(input => {
    input.addEventListener('change', function() {
        ratingText.textContent = ratingTexts[this.value];
        ratingText.classList.add('rated');
    });
});

// Contador de caracteres
const textarea = document.getElementById('descricaoAvaliacao');
const charCount = document.getElementById('charCount');

textarea.addEventListener('input', function() {
    charCount.textContent = this.value.length;
    
    if (this.value.length >= 480) {
        charCount.style.color = '#ef4444';
    } else {
        charCount.style.color = '#6b7280';
    }
});

// Envio do formulário
const form = document.getElementById('formAvaliacao');
const successMessage = document.getElementById('successMessage');
const btnSubmit = document.getElementById('btnSubmit');

form.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Validação
    const nome = document.getElementById('nomeCliente').value.trim();
    const email = document.getElementById('emailCliente').value.trim();
    const nota = document.querySelector('input[name="nota_avaliacao"]:checked');
    const descricao = document.getElementById('descricao_avaliacao').value.trim();
    const termos = document.getElementById('aceitaTermos').checked;
    
    if (!nome || !email || !nota || !descricao || !termos) {
        alert('⚠️ Por favor, preencha todos os campos obrigatórios!');
        return;
    }
    
    if (descricao.length < 20) {
        alert('⚠️ O comentário deve ter no mínimo 20 caracteres!');
        return;
    }
    
    // Desabilita botão
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Enviando...';
    
    // Simula envio (substitua pela chamada real à API)
    try {
        const formData = new FormData(form);
        
        const response = await fetch('/enviar-avaliacao', {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            // Esconde formulário e mostra sucesso
            form.style.display = 'none';
            successMessage.style.display = 'block';
            
            // Scroll suave para o topo
            successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            throw new Error('Erro ao enviar');
        }
    } catch (error) {
        alert('❌ Erro ao enviar avaliação. Tente novamente!');
        btnSubmit.disabled = false;
        btnSubmit.innerHTML = '<i class="bi bi-send-fill"></i> Enviar Avaliação';
    }
});

// Resetar formulário
function resetarFormulario() {
    form.reset();
    form.style.display = 'block';
    successMessage.style.display = 'none';
    btnSubmit.disabled = false;
    btnSubmit.innerHTML = '<i class="bi bi-send-fill"></i> Enviar Avaliação';
    ratingText.textContent = 'Clique nas estrelas para avaliar';
    ratingText.classList.remove('rated');
    charCount.textContent = '0';
    
    // Scroll suave para o topo
    document.querySelector('.avaliacao-header').scrollIntoView({ behavior: 'smooth' });
}

</script>
</body>
</html>
