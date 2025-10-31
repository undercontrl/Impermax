<div class="page-wrapper">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-star-fill me-2"></i>
                    Nova Avaliação
                </h1>
                <p class="page-subtitle">Cadastre uma nova avaliação de cliente</p>
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
            <div class="form-grid">
                <!-- Cliente -->
                <div class="form-group">
                    <label for="id_cliente" class="form-label required">
                        <i class="bi bi-person-fill me-2"></i>
                        Cliente
                    </label>
                    <select name="id_cliente" id="id_cliente" class="form-control" required>
                        <option value="">Selecione um cliente</option>
                        <?php if (!empty($clientes)): ?>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id_usuario'] ?>">
                                    <?= htmlspecialchars($cliente['nome_usuario']) ?> 
                                    (<?= htmlspecialchars($cliente['email_usuario']) ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <small class="form-hint">Selecione o cliente que fez a avaliação</small>
                </div>

                <!-- Nota -->
                <div class="form-group">
                    <label for="nota_avaliacao" class="form-label required">
                        <i class="bi bi-star-fill me-2"></i>
                        Nota
                    </label>
                    <div class="rating-input">
                        <input type="hidden" name="nota_avaliacao" id="nota_avaliacao" value="5" required>
                        <div class="star-rating" id="starRating">
                            <i class="bi bi-star-fill star" data-value="1"></i>
                            <i class="bi bi-star-fill star" data-value="2"></i>
                            <i class="bi bi-star-fill star" data-value="3"></i>
                            <i class="bi bi-star-fill star" data-value="4"></i>
                            <i class="bi bi-star-fill star" data-value="5"></i>
                        </div>
                        <span class="rating-text">5 estrelas</span>
                    </div>
                    <small class="form-hint">Clique nas estrelas para avaliar</small>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status_avaliacao" class="form-label required">
                        <i class="bi bi-eye-fill me-2"></i>
                        Status
                    </label>
                    <select name="status_avaliacao" id="status_avaliacao" class="form-control" required>
                        <option value="pendente">Pendente</option>
                        <option value="publicada" selected>Publicada</option>
                        <option value="oculta">Oculta</option>
                    </select>
                    <small class="form-hint">Status de visibilidade da avaliação</small>
                </div>
            </div>

            <!-- Descrição (largura total) -->
            <div class="form-group">
                <label for="descricao_avaliacao" class="form-label required">
                    <i class="bi bi-chat-left-text-fill me-2"></i>
                    Descrição da Avaliação
                </label>
                <textarea 
                    name="descricao_avaliacao" 
                    id="descricao_avaliacao" 
                    class="form-control" 
                    rows="6" 
                    required
                    placeholder="Digite o comentário da avaliação..."
                    maxlength="1000"></textarea>
                <div class="char-counter">
                    <span id="charCount">0</span>/1000 caracteres
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>
                    Salvar Avaliação
                </button>
                <a href="/backend/avaliacao/listar" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --cor-primaria: #5f7396;
        --cor-acento: #1487df;
        --cor-clara: #ffffff;
        --cor-cinza: #a7a7a7;
        --cor-fundo: #f4f6f9;
        --cor-success: #22c55e;
        --cor-warning: #f59e0b;
        --cor-danger: #ef4444;
        --border-radius: 12px;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-wrapper {
        max-width: 900px;
        margin: 0 auto;
    }

    /* ==================== HEADER ==================== */
    .page-header {
        margin-bottom: var(--spacing-xl);
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-md);
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
        display: flex;
        align-items: center;
        letter-spacing: -0.025em;
    }

    .page-title i {
        color: #fbbf24;
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: var(--cor-cinza);
        margin: 0;
    }

    .btn-action-secondary {
        background: white;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-action-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }

    /* ==================== FORMULÁRIO ==================== */
    .form-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid #f1f5f9;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .form-label.required::after {
        content: '*';
        color: var(--cor-danger);
        margin-left: 0.25rem;
        font-size: 1rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: var(--transition);
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    .form-control:disabled {
        background: #f8fafc;
        color: #94a3b8;
        cursor: not-allowed;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
    }

    .form-hint {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.8125rem;
        color: #64748b;
    }

    /* ==================== RATING INPUT ==================== */
    .rating-input {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
    }

    .star-rating {
        display: flex;
        gap: 0.5rem;
    }

    .star {
        font-size: 1rem;
        color: #e2e8f0;
        cursor: pointer;
        transition: var(--transition);
    }

    .star:hover,
    .star.active {
        color: #fbbf24;
        transform: scale(1.1);
    }

    .star.active {
        animation: starPop 0.3s ease;
    }

    @keyframes starPop {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    .rating-text {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.9375rem;
    }

    /* ==================== CONTADOR DE CARACTERES ==================== */
    .char-counter {
        text-align: right;
        font-size: 0.8125rem;
        color: #64748b;
        margin-top: 0.5rem;
    }

    .char-counter.warning {
        color: var(--cor-warning);
    }

    .char-counter.danger {
        color: var(--cor-danger);
    }

    /* ==================== BOTÕES ==================== */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #f1f5f9;
    }

    .btn {
        padding: 0.875rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9375rem;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--cor-acento), #0e6eb8);
        color: white;
        box-shadow: 0 4px 12px rgba(20, 135, 223, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 135, 223, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* ==================== RESPONSIVIDADE ==================== */
    @media (max-width: 768px) {
        .form-card {
            padding: 1.5rem;
        }

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

        .btn {
            width: 100%;
        }

        .rating-input {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<script>
// ==================== RATING STARS ====================
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('nota_avaliacao');
    const ratingText = document.querySelector('.rating-text');
    
    // Define nota inicial como 5
    updateStars(5);
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            ratingInput.value = value;
            updateStars(value);
            
            // Atualiza texto
            const textos = {
                1: '1 estrela - Muito ruim',
                2: '2 estrelas - Ruim',
                3: '3 estrelas - Regular',
                4: '4 estrelas - Bom',
                5: '5 estrelas - Excelente'
            };
            ratingText.textContent = textos[value];
        });
        
        // Efeito hover
        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.dataset.value);
            stars.forEach((s, index) => {
                if (index < value) {
                    s.style.color = '#fbbf24';
                } else {
                    s.style.color = '#e2e8f0';
                }
            });
        });
    });
    
    // Restaura estrelas ao sair
    document.querySelector('.star-rating').addEventListener('mouseleave', function() {
        const currentValue = parseInt(ratingInput.value);
        updateStars(currentValue);
    });
    
    function updateStars(value) {
        stars.forEach((star, index) => {
            if (index < value) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }
});

// ==================== CONTADOR DE CARACTERES ====================
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('descricao_avaliacao');
    const charCount = document.getElementById('charCount');
    const counter = document.querySelector('.char-counter');
    
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;
            
            // Muda cor baseado no limite
            if (length > 900) {
                counter.classList.add('danger');
                counter.classList.remove('warning');
            } else if (length > 800) {
                counter.classList.add('warning');
                counter.classList.remove('danger');
            } else {
                counter.classList.remove('warning', 'danger');
            }
        });
    }
});

// ==================== VALIDAÇÃO DO FORMULÁRIO ====================
document.getElementById('formAvaliacao').addEventListener('submit', function(e) {
    const idCliente = document.getElementById('id_cliente').value;
    const descricao = document.getElementById('descricao_avaliacao').value.trim();
    const nota = document.getElementById('nota_avaliacao').value;
    
    let erros = [];
    
    if (!idCliente) {
        erros.push('Selecione um cliente');
    }
    
    if (!descricao || descricao.length < 10) {
        erros.push('A descrição deve ter no mínimo 10 caracteres');
    }
    
    if (!nota || nota < 1 || nota > 5) {
        erros.push('Selecione uma nota válida (1 a 5 estrelas)');
    }
    
    if (erros.length > 0) {
        e.preventDefault();
        alert('Erros encontrados:\n\n' + erros.join('\n'));
    }
});
</script>