<div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Nova Avaliação
                </h1>
                <p class="page-subtitle">Adicione uma nova avaliação de cliente</p>
            </div>
            <a href="/backend/avaliacao/listar" class="btn-action-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar
            </a>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/avaliacao/salvar" method="POST" id="formAvaliacao">
            
            <!-- Seção: Dados da Avaliação -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="bi bi-star-fill"></i>
                        Dados da Avaliação
                    </h3>
                    <p class="section-subtitle">Selecione o cliente e a nota</p>
                </div>

                <div class="form-grid">
                    <!-- Cliente -->
                    <div class="form-group">
                        <label for="id_cliente" class="form-label required">
                            <i class="bi bi-person-fill"></i>
                            Cliente
                        </label>
                        <select name="id_cliente" id="id_cliente" class="form-select" required>
                            <option value="">Selecione um cliente</option>
                            <?php 
                            if (isset($usuarios) && is_array($usuarios)) {
                                foreach ($usuarios as $usuario) {
                                    echo '<option value="' . htmlspecialchars($usuario['id_usuario']) . '">';
                                    echo htmlspecialchars($usuario['nome_usuario']);
                                    if (!empty($usuario['email_usuario'])) {
                                        echo ' - ' . htmlspecialchars($usuario['email_usuario']);
                                    }
                                    echo '</option>';
                                }
                            } else {
                                echo '<option value="" disabled>Nenhum cliente disponível</option>';
                            }
                            ?>
                        </select>
                        <small class="form-hint">Selecione o cliente que fez a avaliação</small>
                    </div>

                    <!-- Nota -->
                    <div class="form-group">
                        <label for="nota_avaliacao" class="form-label required">
                            <i class="bi bi-star-fill"></i>
                            Nota
                        </label>
                        <div class="rating-input">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <input type="radio" 
                                       name="nota_avaliacao" 
                                       id="nota_<?= $i ?>" 
                                       value="<?= $i ?>" 
                                       required>
                                <label for="nota_<?= $i ?>" class="star-label">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                            <?php endfor; ?>
                        </div>
                        <div id="nota_texto" class="rating-text"></div>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status_avaliacao" class="form-label required">
                            <i class="bi bi-eye-fill"></i>
                            Status
                        </label>
                        <select name="status_avaliacao" id="status_avaliacao" class="form-select" required>
                            <option value="">Selecione o status</option>
                            <option value="publicada">Publicada</option>
                            <option value="pendente" selected>Pendente</option>
                            <option value="oculta">Oculta</option>
                        </select>
                        <small class="form-hint">Define se a avaliação será exibida publicamente</small>
                    </div>
                </div>
            </div>

            <!-- Seção: Descrição -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="bi bi-chat-quote-fill"></i>
                        Avaliação
                    </h3>
                    <p class="section-subtitle">Escreva o comentário do cliente</p>
                </div>

                <div class="form-group">
                    <label for="descricao_avaliacao" class="form-label required">
                        Comentário
                    </label>
                    <textarea name="descricao_avaliacao" 
                              id="descricao_avaliacao" 
                              class="form-textarea"
                              rows="6"
                              placeholder="Escreva aqui o comentário do cliente sobre o serviço..."
                              required
                              minlength="10"
                              maxlength="1000"></textarea>
                    <div class="char-counter">
                        <span id="charCount">0</span> / 1000 caracteres
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/avaliacao/listar" class="btn-form-cancel">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn-form-submit">
                    <i class="bi bi-check-lg"></i>
                    Salvar Avaliação
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
        --cor-danger: #ef4444;
        --cor-warning: #f59e0b;
    }

    .page-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
        display: flex;
        align-items: center;
    }

    .page-title i {
        color: #fbbf24;
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: #64748b;
        margin: 0;
    }

    .btn-action-secondary {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-action-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Card do Formulário */
    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .form-section {
        padding: 2rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .section-header {
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.375rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--cor-acento);
        font-size: 1.25rem;
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
    }

    /* Grid de Formulário */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    /* Form Groups */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-label {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label.required::after {
        content: "*";
        color: var(--cor-danger);
        margin-left: 0.25rem;
    }

    .form-hint {
        font-size: 0.8125rem;
        color: #64748b;
        margin-top: 0.25rem;
    }

    /* Select e Input */
    .form-select {
        width: 100%;
        padding: 0.875rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
    }

    .form-select:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    /* Rating Input */
    .rating-input {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        padding: 0.5rem 0;
    }

    .rating-input input[type="radio"] {
        display: none;
    }

    .star-label {
        cursor: pointer;
        font-size: 2rem;
        color: #e2e8f0;
        transition: all 0.2s;
    }

    .rating-input input[type="radio"]:checked ~ .star-label,
    .rating-input .star-label:hover,
    .rating-input .star-label:hover ~ .star-label {
        color: #fbbf24;
        transform: scale(1.1);
    }

    .rating-input input[type="radio"]:checked + .star-label {
        color: #fbbf24;
    }

    .rating-text {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #334155;
        margin-top: 0.5rem;
        min-height: 1.5rem;
    }

    /* Textarea */
    .form-textarea {
        width: 100%;
        padding: 0.875rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        font-family: inherit;
        resize: vertical;
        transition: all 0.2s;
    }

    .form-textarea:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    .char-counter {
        font-size: 0.8125rem;
        color: #64748b;
        text-align: right;
    }

    /* Ações do Formulário */
    .form-actions {
        padding: 1.5rem 2rem;
        background: #f8fafc;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-form-cancel {
        padding: 0.75rem 1.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: white;
        color: #64748b;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-form-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-form-submit {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--cor-acento), #0e6eb8);
        color: white;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(20, 135, 223, 0.3);
    }

    .btn-form-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 135, 223, 0.4);
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-action-secondary {
            width: 100%;
            justify-content: center;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-form-cancel,
        .btn-form-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
// Sistema de Rating Interativo
document.querySelectorAll('.rating-input input[type="radio"]').forEach((radio, index) => {
    radio.addEventListener('change', function() {
        const nota = this.value;
        const textos = {
            1: '⭐ Muito Ruim',
            2: '⭐⭐ Ruim',
            3: '⭐⭐⭐ Regular',
            4: '⭐⭐⭐⭐ Bom',
            5: '⭐⭐⭐⭐⭐ Excelente'
        };
        document.getElementById('nota_texto').textContent = textos[nota];
        
        // Marcar todas as estrelas anteriores
        document.querySelectorAll('.star-label').forEach((label, i) => {
            if (i < nota) {
                label.style.color = '#fbbf24';
            } else {
                label.style.color = '#e2e8f0';
            }
        });
    });
});

// Efeito hover nas estrelas
document.querySelectorAll('.star-label').forEach((label, index) => {
    label.addEventListener('mouseenter', function() {
        document.querySelectorAll('.star-label').forEach((l, i) => {
            if (i <= index) {
                l.style.color = '#fbbf24';
            } else {
                l.style.color = '#e2e8f0';
            }
        });
    });
    
    label.addEventListener('mouseleave', function() {
        const checkedRadio = document.querySelector('.rating-input input[type="radio"]:checked');
        const checkedValue = checkedRadio ? checkedRadio.value : 0;
        
        document.querySelectorAll('.star-label').forEach((l, i) => {
            if (i < checkedValue) {
                l.style.color = '#fbbf24';
            } else {
                l.style.color = '#e2e8f0';
            }
        });
    });
});

// Contador de Caracteres
document.getElementById('descricao_avaliacao').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('charCount').textContent = count;
    
    if (count > 1000) {
        document.getElementById('charCount').style.color = 'var(--cor-danger)';
    } else if (count > 800) {
        document.getElementById('charCount').style.color = 'var(--cor-warning)';
    } else {
        document.getElementById('charCount').style.color = '#64748b';
    }
});

// Validação antes de enviar
document.getElementById('formAvaliacao').addEventListener('submit', function(e) {
    const cliente = document.getElementById('id_cliente').value;
    const nota = document.querySelector('.rating-input input[type="radio"]:checked');
    const status = document.getElementById('status_avaliacao').value;
    const descricao = document.getElementById('descricao_avaliacao').value;
    
    if (!cliente) {
        e.preventDefault();
        alert('Por favor, selecione um cliente.');
        return false;
    }
    
    if (!nota) {
        e.preventDefault();
        alert('Por favor, selecione uma nota.');
        return false;
    }
    
    if (!status) {
        e.preventDefault();
        alert('Por favor, selecione o status.');
        return false;
    }
    
    if (descricao.length < 10) {
        e.preventDefault();
        alert('A avaliação deve ter no mínimo 10 caracteres.');
        return false;
    }
    
    if (descricao.length > 1000) {
        e.preventDefault();
        alert('A avaliação deve ter no máximo 1000 caracteres.');
        return false;
    }
    
    // Mostrar loading
    const btnSubmit = this.querySelector('.btn-form-submit');
    btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Salvando...';
    btnSubmit.disabled = true;
});
</script>