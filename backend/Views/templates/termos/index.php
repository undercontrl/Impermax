<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">

<div class="terms-page-container">
    <!-- Header -->
    <div class="terms-header">
        <h1 class="terms-title">
            <i class="bi bi-file-text-fill"></i>
            <?= htmlspecialchars($titulo) ?>
        </h1>
        <p class="terms-meta">
            <i class="bi bi-calendar3"></i>
            Última atualização: <?= htmlspecialchars($dataAtualizacao) ?>
        </p>
    </div>

    <!-- Content -->
    <div class="terms-content">
        <section class="terms-section">
            <h2>1. Aceitação dos Termos</h2>
            <p>Ao acessar e usar o sistema <?= htmlspecialchars($empresa) ?>, você concorda em cumprir e estar vinculado aos seguintes termos e condições de uso. Se você não concordar com qualquer parte destes termos, não deverá usar nosso sistema.</p>
        </section>

        <section class="terms-section">
            <h2>2. Descrição do Serviço</h2>
            <p>O <?= htmlspecialchars($empresa) ?> é um sistema de gestão empresarial que oferece funcionalidades para:</p>
            <ul>
                <li>Gerenciamento de agendamentos e atendimentos</li>
                <li>Controle de orçamentos e pagamentos</li>
                <li>Cadastro e gestão de clientes</li>
                <li>Relatórios e análises de desempenho</li>
                <li>Gestão de usuários e permissões</li>
            </ul>
        </section>

        <section class="terms-section">
            <h2>3. Cadastro e Conta de Usuário</h2>
            <p>Para utilizar o sistema, você deve:</p>
            <ul>
                <li>Fornecer informações verdadeiras, precisas e completas durante o cadastro</li>
                <li>Manter a confidencialidade de sua senha</li>
                <li>Notificar imediatamente sobre qualquer uso não autorizado de sua conta</li>
                <li>Ser responsável por todas as atividades realizadas em sua conta</li>
            </ul>
        </section>

        <section class="terms-section">
            <h2>4. Privacidade e Proteção de Dados</h2>
            <p>Levamos a sério a proteção de seus dados pessoais. Nosso sistema:</p>
            <ul>
                <li>Coleta apenas dados necessários para o funcionamento do serviço</li>
                <li>Utiliza criptografia para proteger informações sensíveis</li>
                <li>Não compartilha seus dados com terceiros sem consentimento</li>
                <li>Está em conformidade com a Lei Geral de Proteção de Dados (LGPD)</li>
                <li>Permite que você acesse, corrija ou exclua seus dados a qualquer momento</li>
            </ul>
        </section>

        <section class="terms-section">
            <h2>5. Uso Aceitável</h2>
            <p>Você concorda em NÃO:</p>
            <ul>
                <li>Usar o sistema para fins ilegais ou não autorizados</li>
                <li>Tentar acessar áreas restritas do sistema sem autorização</li>
                <li>Interferir ou interromper o funcionamento do sistema</li>
                <li>Transmitir vírus, malware ou códigos maliciosos</li>
                <li>Fazer engenharia reversa ou copiar o código do sistema</li>
                <li>Usar o sistema de forma que possa danificar nossa infraestrutura</li>
            </ul>
        </section>

        <section class="terms-section">
            <h2>6. Propriedade Intelectual</h2>
            <p>Todo o conteúdo, design, código-fonte, logotipos e marcas do <?= htmlspecialchars($empresa) ?> são propriedade exclusiva da empresa e estão protegidos por leis de direitos autorais e propriedade intelectual.</p>
        </section>

        <section class="terms-section">
            <h2>7. Disponibilidade do Serviço</h2>
            <p>Embora nos esforcemos para manter o sistema disponível 24/7, não garantimos que:</p>
            <ul>
                <li>O serviço estará sempre disponível sem interrupções</li>
                <li>Não haverá erros ou bugs no sistema</li>
                <li>Defeitos serão corrigidos imediatamente</li>
            </ul>
            <p>Reservamo-nos o direito de realizar manutenções programadas mediante aviso prévio.</p>
        </section>

        <section class="terms-section">
            <h2>8. Limitação de Responsabilidade</h2>
            <p>O <?= htmlspecialchars($empresa) ?> não se responsabiliza por:</p>
            <ul>
                <li>Perda de dados causada por falhas técnicas ou erros do usuário</li>
                <li>Danos indiretos, incidentais ou consequenciais</li>
                <li>Interrupções de serviço causadas por terceiros</li>
                <li>Decisões tomadas com base nas informações do sistema</li>
            </ul>
        </section>

        <section class="terms-section">
            <h2>9. Modificações nos Termos</h2>
            <p>Reservamo-nos o direito de modificar estes termos a qualquer momento. As alterações entrarão em vigor imediatamente após a publicação. É sua responsabilidade revisar periodicamente estes termos.</p>
        </section>

        <section class="terms-section">
            <h2>10. Rescisão</h2>
            <p>Podemos suspender ou encerrar sua conta a qualquer momento, sem aviso prévio, se você violar estes termos. Você também pode encerrar sua conta a qualquer momento entrando em contato conosco.</p>
        </section>

        <section class="terms-section">
            <h2>11. Lei Aplicável</h2>
            <p>Estes termos são regidos pelas leis da República Federativa do Brasil. Qualquer disputa será resolvida nos tribunais brasileiros.</p>
        </section>

        <section class="terms-section">
            <h2>12. Contato</h2>
            <p>Se você tiver dúvidas sobre estes termos, entre em contato conosco:</p>
            <div class="contact-info">
                <p><i class="bi bi-envelope-fill"></i> Email: <?= htmlspecialchars($email) ?></p>
                <p><i class="bi bi-headset"></i> Suporte: <a href="/backend/suporte">Central de Suporte</a></p>
            </div>
        </section>

        <!-- Acceptance -->
        <div class="terms-acceptance">
            <div class="acceptance-box">
                <i class="bi bi-check-circle-fill"></i>
                <p>Ao usar o sistema <?= htmlspecialchars($empresa) ?>, você declara que leu, compreendeu e concorda com estes Termos de Uso.</p>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="terms-footer">
        <button onclick="history.back()" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Voltar
        </button>
    </div>
</div>

<style>
.terms-page-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem;
}

/* Header */
.terms-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--border-color);
}

.terms-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.terms-meta {
    color: var(--text-secondary);
    font-size: 0.9375rem;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

/* Content */
.terms-content {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 12px;
    padding: 2.5rem;
    margin-bottom: 2rem;
}

.terms-section {
    margin-bottom: 2.5rem;
}

.terms-section:last-child {
    margin-bottom: 0;
}

.terms-section h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 1rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--accent-color);
}

.terms-section p {
    color: var(--text-secondary);
    line-height: 1.7;
    margin: 0 0 1rem 0;
}

.terms-section ul {
    color: var(--text-secondary);
    line-height: 1.7;
    margin: 0 0 1rem 0;
    padding-left: 1.5rem;
}

.terms-section li {
    margin-bottom: 0.5rem;
}

.contact-info {
    background: var(--bg-tertiary);
    padding: 1.5rem;
    border-radius: 8px;
    border-left: 4px solid var(--accent-color);
}

.contact-info p {
    margin: 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.contact-info i {
    color: var(--accent-color);
}

.contact-info a {
    color: var(--accent-color);
    text-decoration: none;
    font-weight: 500;
}

.contact-info a:hover {
    text-decoration: underline;
}

/* Acceptance Box */
.terms-acceptance {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid var(--border-color);
}

.acceptance-box {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    border: 2px solid var(--success-color);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.acceptance-box i {
    font-size: 1.5rem;
    color: var(--success-color);
    flex-shrink: 0;
    margin-top: 0.25rem;
}

.acceptance-box p {
    color: var(--text-primary);
    font-weight: 500;
    margin: 0;
}

/* Footer */
.terms-footer {
    text-align: center;
}

.btn-back {
    padding: 0.75rem 1.5rem;
    background: var(--card-bg);
    border: 2px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-back:hover {
    background: var(--accent-color);
    border-color: var(--accent-color);
    color: white;
    transform: translateY(-2px);
}

/* Dark Mode */
[data-theme="dark"] .terms-content {
    background: var(--card-bg);
    border-color: var(--card-border);
}

[data-theme="dark"] .contact-info {
    background: var(--bg-secondary);
}

/* Responsive */
@media (max-width: 768px) {
    .terms-page-container {
        padding: 1rem;
    }

    .terms-title {
        font-size: 2rem;
    }

    .terms-content {
        padding: 1.5rem;
    }

    .terms-section h2 {
        font-size: 1.25rem;
    }
}

@media print {
    .terms-footer {
        display: none;
    }
}
</style>
