<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">

<div class="support-page-container">
    <!-- Header -->
    <div class="support-header">
        <div class="support-header-content">
            <h1 class="support-title">
                <i class="bi bi-headset"></i>
                <?= htmlspecialchars($titulo) ?>
            </h1>
            <p class="support-subtitle">Estamos aqui para ajudar você! Encontre respostas rápidas ou entre em contato conosco.</p>
        </div>
    </div>

    <!-- Contact Cards -->
    <div class="contact-cards-grid">
        <div class="contact-card">
            <div class="contact-icon email-icon">
                <i class="bi bi-envelope-fill"></i>
            </div>
            <h3>Email</h3>
            <p><?= htmlspecialchars($email) ?></p>
            <a href="mailto:<?= htmlspecialchars($email) ?>" class="btn-contact">Enviar Email</a>
        </div>

        <div class="contact-card">
            <div class="contact-icon phone-icon">
                <i class="bi bi-telephone-fill"></i>
            </div>
            <h3>Telefone</h3>
            <p><?= htmlspecialchars($telefone) ?></p>
            <a href="tel:<?= str_replace(['(', ')', ' ', '-'], '', $telefone) ?>" class="btn-contact">Ligar Agora</a>
        </div>

        <div class="contact-card">
            <div class="contact-icon schedule-icon">
                <i class="bi bi-clock-fill"></i>
            </div>
            <h3>Horário de Atendimento</h3>
            <p><?= htmlspecialchars($horario) ?></p>
            <span class="badge badge-success">Disponível</span>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section">
        <div class="faq-header">
            <h2><i class="bi bi-question-circle-fill"></i> Perguntas Frequentes</h2>
            <p>Encontre respostas para as dúvidas mais comuns</p>
        </div>

        <div class="faq-accordion">
            <?php foreach ($faqs as $index => $faq): ?>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(<?= $index ?>)" aria-expanded="false" aria-controls="faq-answer-<?= $index ?>">
                        <span><?= htmlspecialchars($faq['pergunta']) ?></span>
                        <i class="bi bi-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer" id="faq-answer-<?= $index ?>" style="display: none;">
                        <p><?= htmlspecialchars($faq['resposta']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Additional Help -->
    <div class="help-section">
        <div class="help-card">
            <i class="bi bi-book-fill"></i>
            <h3>Documentação</h3>
            <p>Acesse nossa documentação completa para aprender mais sobre o sistema</p>
            <a href="#" class="btn-help">Ver Documentação</a>
        </div>

        <div class="help-card">
            <i class="bi bi-chat-dots-fill"></i>
            <h3>Chat ao Vivo</h3>
            <p>Converse com nossa equipe em tempo real durante o horário comercial</p>
            <a href="#" class="btn-help">Iniciar Chat</a>
        </div>

        <div class="help-card">
            <i class="bi bi-youtube"></i>
            <h3>Tutoriais em Vídeo</h3>
            <p>Assista tutoriais passo a passo sobre as funcionalidades do sistema</p>
            <a href="#" class="btn-help">Ver Vídeos</a>
        </div>
    </div>
</div>

<style>
.support-page-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

/* Header */
.support-header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 2rem;
    background: linear-gradient(135deg, var(--accent-color) 0%, var(--accent-hover) 100%);
    border-radius: 16px;
    color: white;
}

.support-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.support-subtitle {
    font-size: 1.125rem;
    opacity: 0.95;
    margin: 0;
}

/* Contact Cards */
.contact-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.contact-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px var(--shadow-color);
}

.contact-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
}

.email-icon {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.phone-icon {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.schedule-icon {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.contact-card h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
}

.contact-card p {
    color: var(--text-secondary);
    margin: 0 0 1rem 0;
}

.btn-contact {
    display: inline-block;
    padding: 0.625rem 1.25rem;
    background: var(--accent-color);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-contact:hover {
    background: var(--accent-hover);
    transform: scale(1.05);
    color: white;
}

/* FAQ Section */
.faq-section {
    margin-bottom: 3rem;
}

.faq-header {
    text-align: center;
    margin-bottom: 2rem;
}

.faq-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.faq-header p {
    color: var(--text-secondary);
    margin: 0;
}

.faq-accordion {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.faq-item {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item:hover {
    border-color: var(--accent-color);
}

.faq-question {
    width: 100%;
    padding: 1.25rem 1.5rem;
    background: transparent;
    border: none;
    text-align: left;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    transition: all 0.2s ease;
}

.faq-question:hover {
    background: var(--bg-tertiary);
}

.faq-icon {
    transition: transform 0.3s ease;
    color: var(--accent-color);
}

.faq-question[aria-expanded="true"] .faq-icon {
    transform: rotate(180deg);
}

.faq-answer {
    padding: 0 1.5rem 1.25rem 1.5rem;
    color: var(--text-secondary);
    line-height: 1.6;
}

.faq-answer p {
    margin: 0;
}

/* Help Section */
.help-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.help-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
}

.help-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px var(--shadow-color);
    border-color: var(--accent-color);
}

.help-card i {
    font-size: 3rem;
    color: var(--accent-color);
    margin-bottom: 1rem;
}

.help-card h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
}

.help-card p {
    color: var(--text-secondary);
    margin: 0 0 1.5rem 0;
    line-height: 1.6;
}

.btn-help {
    display: inline-block;
    padding: 0.625rem 1.25rem;
    background: transparent;
    color: var(--accent-color);
    border: 2px solid var(--accent-color);
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-help:hover {
    background: var(--accent-color);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .support-title {
        font-size: 2rem;
    }

    .contact-cards-grid,
    .help-section {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function toggleFaq(index) {
    const answer = document.getElementById('faq-answer-' + index);
    const question = answer.previousElementSibling;
    const isExpanded = question.getAttribute('aria-expanded') === 'true';
    
    // Close all other FAQs
    document.querySelectorAll('.faq-question').forEach(q => {
        q.setAttribute('aria-expanded', 'false');
        q.nextElementSibling.style.display = 'none';
    });
    
    // Toggle current FAQ
    if (!isExpanded) {
        question.setAttribute('aria-expanded', 'true');
        answer.style.display = 'block';
    }
}
</script>
