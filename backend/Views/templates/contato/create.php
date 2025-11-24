<?php
// resources/views/contato/create.php
?>
<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/contato">Contatos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Novo Contato</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Novo Contato
                </h1>
                <p class="page-subtitle">Preencha os dados para registrar um novo contato manualmente</p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/contato/salvar" method="post" id="formContato">
            
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-person-circle"></i>
                    Informações do Contato
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nome_contato" class="form-label">
                            Nome Completo <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-fill input-icon"></i>
                            <input type="text" 
                                   id="nome_contato" 
                                   name="nome_contato" 
                                   class="form-control" 
                                   placeholder="Ex: João Silva"
                                   required>
                        </div>
                        <small class="form-hint">Nome completo do contato</small>
                    </div>

                    <div class="form-group">
                        <label for="email_contato" class="form-label">
                            E-mail <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope-fill input-icon"></i>
                            <input type="email" 
                                   id="email_contato" 
                                   name="email_contato" 
                                   class="form-control" 
                                   placeholder="exemplo@email.com"
                                   required>
                        </div>
                        <small class="form-hint">E-mail para resposta</small>
                    </div>

                    <div class="form-group">
                        <label for="telefone_contato" class="form-label">
                            Telefone
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-telephone-fill input-icon"></i>
                            <input type="text" 
                                   id="telefone_contato" 
                                   name="telefone_contato" 
                                   class="form-control" 
                                   placeholder="(00) 00000-0000">
                        </div>
                        <small class="form-hint">Telefone com DDD</small>
                    </div>

                    <div class="form-group">
                        <label for="assunto_contato" class="form-label">
                            Assunto <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-chat-left-text-fill input-icon"></i>
                            <input type="text" 
                                   id="assunto_contato" 
                                   name="assunto_contato" 
                                   class="form-control" 
                                   placeholder="Ex: Orçamento para piscina"
                                   required>
                        </div>
                        <small class="form-hint">Resumo do motivo do contato</small>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/contato" class="btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Criar Contato
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --cor-primaria: #5f7396;
        --cor-acento: #1487df;
        --cor-success: #22c55e;
        --cor-warning: #f59e0b;
        --cor-danger: #ef4444;
        --cor-info: #3b82f6;
    }

    .page-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Breadcrumb */
    .breadcrumb-nav { margin-bottom: 1.5rem; }
    .breadcrumb { display: flex; flex-wrap: wrap; padding: 0; margin: 0; list-style: none; background: transparent; }
    .breadcrumb-item { font-size: 0.875rem; }
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; padding: 0 0.5rem; color: #94a3b8; }
    .breadcrumb-item a { color: #64748b; text-decoration: none; transition: color 0.2s; }
    .breadcrumb-item a:hover { color: var(--cor-acento); }
    .breadcrumb-item.active { color: #1e293b; font-weight: 500; }

    /* Header */
    .page-header { margin-bottom: 2rem; }
    .page-title { font-size: 1.875rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem 0; display: flex; align-items: center; }
    .page-title i { color: var(--cor-acento); }
    .page-subtitle { font-size: 0.9375rem; color: #64748b; margin: 0; }

    /* Formulário */
    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        padding: 2rem;
    }

    .form-section { margin-bottom: 2rem; }
    .form-section:last-of-type { margin-bottom: 0; }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f1f5f9;
    }
    .section-title i { color: var(--cor-acento); }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-group { display: flex; flex-direction: column; }
    .form-group.full-width { grid-column: 1 / -1; }

    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
    }
    .required { color: var(--cor-danger); }

    .input-wrapper { position: relative; }
    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.125rem;
        z-index: 1;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: all 0.2s;
        background: white;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }
    textarea.form-control { resize: vertical; min-height: 120px; }

    .form-hint {
        font-size: 0.8125rem;
        color: #94a3b8;
        margin-top: 0.375rem;
    }

    /* Botões */
    .form-actions {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f1f5f9;
    }

    .btn-primary, .btn-secondary {
        padding: 0.875rem 1.75rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--cor-acento), #0e6eb8);
        color: white;
        box-shadow: 0 4px 12px rgba(20, 135, 223, 0.3);
        flex: 1;
        justify-content: center;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 135, 223, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }
    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column-reverse; }
        .btn-primary, .btn-secondary { width: 100%; justify-content: center; }
    }
</style>

<script>
// Máscara de telefone
document.getElementById('telefone_contato').addEventListener('input', function(e) {
    let v = e.target.value.replace(/\D/g, '');
    v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
    v = v.replace(/(\d{5})(\d)/, '$1-$2');
    e.target.value = v.substring(0, 15);
});

// Validação extra
document.getElementById('formContato').addEventListener('submit', function(e) {
    const email = document.getElementById('email_contato').value;
    if (!email.includes('@') || !email.includes('.')) {
        alert('Por favor, insira um e-mail válido.');
        e.preventDefault();
    }
});
</script>