<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Avaliação - Impermax</title>
    <link rel="icon" type="images/png" href="/assets/icons/water.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* background: var(--bg-color, #f1f5f9); */
            background: linear-gradient(180deg, #5f7396,rgb(40, 73, 129));
            min-height: 100vh;
            padding: 20px;
        }

        .cliente-container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header */
        .cliente-header {
            background: white;
            border-radius: 16px;
            padding: 20px 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            height: 50px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 16px;
        }

        .btn-logout {
            background: #ef4444;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        /* Main Content */
        .cliente-main {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .page-title-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .title-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
        }

        .page-title-section h1 {
            font-size: 32px;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .page-title-section p {
            color: #64748b;
            font-size: 16px;
        }

        /* Alerts */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        /* Form */
        .avaliacao-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .required {
            color: #ef4444;
        }

        /* Rating Stars */
        .rating-container {
            background: #f8fafc;
            padding: 30px;
            border-radius: 12px;
            border: 2px dashed #e2e8f0;
        }

        .stars-wrapper {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .stars-wrapper input {
            display: none;
        }

        .star {
            font-size: 48px;
            color: #e2e8f0;
            cursor: pointer;
            transition: all 0.2s;
        }

        .stars-wrapper input:checked ~ label,
        .stars-wrapper label:hover,
        .stars-wrapper label:hover ~ label {
            color: #fbbf24;
            transform: scale(1.1);
        }

        .rating-text {
            text-align: center;
            font-size: 16px;
            color: #64748b;
            font-weight: 600;
        }

        .rating-text.rated {
            color: #1e293b;
            font-size: 18px;
        }

        /* Textarea */
        .form-textarea {
            width: 100%;
            padding: 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            resize: vertical;
            transition: all 0.2s;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .char-counter {
            text-align: right;
            font-size: 14px;
            color: #64748b;
            margin-top: 8px;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg,rgb(118, 123, 138),rgb(13, 41, 102));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        /* Avaliações Anteriores */
        .avaliacoes-anteriores {
            margin-top: 40px;
            padding-top: 40px;
            border-top: 2px solid #e2e8f0;
        }

        .avaliacoes-anteriores h3 {
            font-size: 20px;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .avaliacao-item {
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
        }

        .avaliacao-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .avaliacao-status {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pendente {
            background: #fef3c7;
            color: #92400e;
        }

        .status-aprovado {
            background: #dcfce7;
            color: #166534;
        }

        .avaliacao-stars {
            color: #fbbf24;
            font-size: 18px;
        }

        .avaliacao-text {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .cliente-main {
                padding: 20px;
            }

            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .star {
                font-size: 36px;
            }
        }
        /* Footer */
        .cliente-footer {
            background: white;
            border-radius: 16px;
            margin-top: 30px;
            padding: 40px 30px 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .footer-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .footer-logo-section {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f1f5f9;
        }

        .footer-logo {
            height: 50px;
            margin-bottom: 15px;
            opacity: 0.9;
            transition: all 0.3s;
        }

        .footer-logo:hover {
            opacity: 1;
            transform: scale(1.05);
        }

        .footer-tagline {
            font-size: 15px;
            color: #64748b;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .footer-redes-sociais {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .footer-social-link {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5f7396;
            font-size: 20px;
            text-decoration: none;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .footer-social-link:hover {
            background: linear-gradient(135deg, #5f7396, #284981);
            color: white;
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(95, 115, 150, 0.3);
        }

        .footer-info {
            text-align: center;
            margin-bottom: 25px;
        }

        .footer-contato {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
            margin-bottom: 20px;
        }

        .footer-contato-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #64748b;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .footer-contato-item i {
            font-size: 16px;
            color: #5f7396;
            width: 20px;
            text-align: center;
        }

        .footer-contato-item:hover {
            color: #284981;
            transform: translateX(3px);
        }

        .footer-servicos {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.8;
            margin-bottom: 20px;
            padding: 0 20px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }

        .footer-copy {
            color: #94a3b8;
            font-size: 13px;
            font-weight: 500;
        }

        .footer-heart {
            color: #ef4444;
            animation: heartbeat 1.5s ease-in-out infinite;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.1); }
            50% { transform: scale(1); }
        }

        @media (max-width: 768px) {
            .cliente-footer {
                padding: 30px 20px 20px;
            }

            .footer-servicos {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="cliente-container">
        <!-- Header -->
        <header class="cliente-header">
            <div class="header-content">
                <a href="/index.php">
                    <img src="/assets/icons/impermax-LOGO.svg" alt="Impermax" class="logo">
                </a>
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($nome_cliente ?? 'Cliente') ?></span>
                    <a href="/backend/logout" class="btn-logout">
                        <i class="bi bi-box-arrow-right"></i>
                        Sair
                    </a>
                </div>
            </div>
        </header>

        <!-- Conteúdo Principal -->
        <main class="cliente-main">
            <div class="page-title-section">
                <div class="title-icon">
                    <i class="bi bi-star-fill"></i>
                </div>
                <h1>Deixe sua Avaliação</h1>
                <p>Conte-nos sobre sua experiência com nossos serviços</p>
            </div>

            <!-- Mensagens -->
            <?php
            $flashMsg = null;
            if (isset($_SESSION['flash'])) {
                $flashMsg = $_SESSION['flash'];
                unset($_SESSION['flash']);
            }
            ?>
            <?php if ($flashMsg): ?>
                <div class="alert alert-<?= htmlspecialchars($flashMsg['type'] ?? 'info') ?>">
                    <i class="bi bi-<?= ($flashMsg['type'] ?? '') === 'success' ? 'check-circle' : 'exclamation-triangle' ?>-fill"></i>
                    <span><?= htmlspecialchars($flashMsg['mensagem'] ?? '') ?></span>
                </div>
            <?php endif; ?>

            <!-- Formulário -->
            <form action="/backend/cliente/avaliacao/salvar" method="POST" class="avaliacao-form">
                
                <!-- Estrelas -->
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
                        placeholder="Conte-nos sobre sua experiência..."
                        rows="6"
                        maxlength="500"
                        required
                    ></textarea>
                    <div class="char-counter">
                        <span id="charCount">0</span>/500 caracteres
                    </div>
                </div>

                <!-- Botão -->
                <button type="submit" class="btn-submit">
                    <i class="bi bi-send-fill"></i>
                    Enviar Avaliação
                </button>
            </form>

            <!-- Avaliações Anteriores -->
            <?php if (!empty($avaliacoes_anteriores)): ?>
                <div class="avaliacoes-anteriores">
                    <h3><i class="bi bi-clock-history"></i> Minhas Avaliações</h3>
                    <?php foreach ($avaliacoes_anteriores as $aval): ?>
                        <div class="avaliacao-item">
                            <div class="avaliacao-header">
                                <div class="avaliacao-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star-fill" style="color: <?= $i <= $aval['nota_avaliacao'] ? '#fbbf24' : '#e2e8f0' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="avaliacao-status status-<?= strtolower($aval['status_avaliacao']) ?>">
                                    <?= $aval['status_avaliacao'] ?>
                                </span>
                            </div>
                            <p class="avaliacao-text"><?= htmlspecialchars($aval['descricao_avaliacao']) ?></p>
                            <small style="color: #94a3b8; font-size: 12px;">
                                <?= date('d/m/Y', strtotime($aval['criado_em'])) ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
        <footer class="cliente-footer">
            <div class="footer-content">
                    <!-- Logo e Tagline -->
                    <div class="footer-logo-section">
                        <a href="/index.php">
                            <img src="/assets/icons/impermax-LOGO.svg" alt="Impermax" class="footer-logo">
                        </a>
                        <p class="footer-tagline">Proteção e qualidade para o seu patrimônio</p>
                    </div>

                    <!-- Redes Sociais -->
                    <div class="footer-redes-sociais">
                        <a href="https://www.facebook.com/aleimpermax" target="_blank" class="footer-social-link" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/impermax_servicos" target="_blank" class="footer-social-link" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://wa.me/+5511999734979" target="_blank" class="footer-social-link" title="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>

                    <!-- Informações de Contato -->
                    <div class="footer-info">
                        <div class="footer-contato">
                            <a href="tel:+5511943961031" class="footer-contato-item">
                                <i class="bi bi-telephone-fill"></i>
                                <span>(11) 9 4396-1031</span>
                            </a>
                            <a href="mailto:aleimpermax@gmail.com" class="footer-contato-item">
                                <i class="bi bi-envelope-fill"></i>
                                <span>aleimpermax@gmail.com</span>
                            </a>
                        </div>
                    </div>

                    <!-- Serviços -->
                    <div class="footer-servicos">
                        Impermeabilização de lajes • Piscinas • Banheiros • Paredes • Fachadas<br>
                        Caixas d'água • Manta asfáltica • Tratamento de umidade
                    </div>

                    <!-- Copyright -->
                    <div class="footer-bottom">
                        <p class="footer-copy">
                            Desenvolvido com <i class="bi bi-heart-fill footer-heart"></i> por Ctrl+Ari+Malu<br>
                            © 2025 Impermax Impermeabilização. Todos os direitos reservados.
                        </p>
                    </div>
            </div>
        </footer>
    </div>
    <script>
        // Atualizar texto da avaliação
        const ratingText = document.getElementById('ratingText');
        const ratingTexts = {
            5: '⭐ Excelente! Ficamos felizes!',
            4: '⭐ Muito Bom! Obrigado!',
            3: '⭐ Bom! Agradecemos!',
            2: '⭐ Regular. Como podemos melhorar?',
            1: '⭐ Ruim. Sentimos muito! Diga-nos em o que podemos melhorar'
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
                charCount.style.color = '#64748b';
            }
        });
    </script>
</body>
</html>