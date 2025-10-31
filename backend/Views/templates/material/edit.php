<!-- ============================================ -->
<!-- ARQUIVO: /backend/Views/templates/material/edit.php -->
<!-- ============================================ -->

<div class="page-wrapper">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Material
                </h1>
                <p class="page-subtitle">Atualize as informações do material #<?= htmlspecialchars($material['id_material']) ?></p>
            </div>
            <a href="/backend/material/listar" class="btn-action-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar
            </a>
        </div>
    </div>

    <!-- Card de Informações -->
    <div class="info-card">
        <div class="info-header">
            <i class="bi bi-info-circle"></i>
            <span>Informações do Material</span>
        </div>
        <div class="info-content">
            <div class="info-item">
                <span class="info-label">Cadastrado em:</span>
                <span class="info-value"><?= date('d/m/Y H:i', strtotime($material['criado_em'])) ?></span>
            </div>
            <?php if (!empty($material['atualizado_em'])): ?>
                <div class="info-item">
                    <span class="info-label">Última Atualização:</span>
                    <span class="info-value"><?= date('d/m/Y H:i', strtotime($material['atualizado_em'])) ?></span>
                </div>
            <?php endif; ?>
            <div class="info-item">
                <span class="info-label">Status Estoque:</span>
                <span class="info-value">
                    <?php
                        $qtd = (int)$material['qtd_material'];
                        if ($qtd === 0) {
                            echo '<span style="color: #ef4444;">⚠️ Sem estoque</span>';
                        } elseif ($qtd < 10) {
                            echo '<span style="color: #f59e0b;">⚠️ Estoque baixo</span>';
                        } else {
                            echo '<span style="color: #22c55e;">✓ Estoque OK</span>';
                        }
                    ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/material/atualizar/<?= $material['id_material'] ?>" method="POST" id="formMaterial">
            <div class="form-grid">
                <!-- Nome do Material -->
                <div class="form-group">
                    <label for="nome_material" class="form-label required">
                        <i class="bi bi-box me-2"></i>
                        Nome do Material
                    </label>
                    <input type="text" 
                           name="nome_material" 
                           id="nome_material" 
                           class="form-control" 
                           required
                           value="<?= htmlspecialchars($material['nome_material']) ?>"
                           placeholder="Ex: Tinta Acrílica, Pincel, etc."
                           maxlength="100">
                    <small class="form-hint">Nome identificador do material</small>
                </div>

                <!-- Quantidade -->
                <div class="form-group">
                    <label for="qtd_material" class="form-label required">
                        <i class="bi bi-box-seam me-2"></i>
                        Quantidade
                    </label>
                    <div class="qty-input-wrapper">
                        <button type="button" class="qty-btn qty-btn-minus" onclick="changeQty(-1)">
                            <i class="bi bi-dash"></i>
                        </button>
                        <input type="number" 
                               name="qtd_material" 
                               id="qtd_material" 
                               class="form-control qty-input" 
                               required
                               min="0"
                               value="<?= htmlspecialchars($material['qtd_material']) ?>"
                               placeholder="0">
                        <button type="button" class="qty-btn qty-btn-plus" onclick="changeQty(1)">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                    <small class="form-hint">Quantidade atual em estoque</small>
                </div>

                <!-- Serviço -->
                <div class="form-group full-width">
                    <label for="id_servico" class="form-label required">
                        <i class="bi bi-gear-fill me-2"></i>
                        Serviço Vinculado
                    </label>
                    <select name="id_servico" id="id_servico" class="form-control" required>
                        <option value="">Selecione um serviço</option>
                        <?php if (!empty($servicos)): ?>
                            <?php foreach ($servicos as $servico): ?>
                                <option value="<?= $servico['id_servico'] ?>"
                                        <?= $servico['id_servico'] == $material['id_servico'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($servico['nome_servico']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <small class="form-hint">Serviço que utiliza este material</small>
                </div>
            </div>

            <!-- Descrição (largura total) -->
            <div class="form-group">
                <label for="descricao_material" class="form-label required">
                    <i class="bi bi-card-text me-2"></i>
                    Descrição
                </label>
                <textarea 
                    name="descricao_material" 
                    id="descricao_material" 
                    class="form-control" 
                    rows="5" 
                    required
                    placeholder="Descreva as características, especificações e uso do material..."
                    maxlength="500"><?= htmlspecialchars($material['descricao_material']) ?></textarea>
                <div class="char-counter">
                    <span id="charCount"><?= mb_strlen($material['descricao_material']) ?></span>/500 caracteres
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>
                    Atualizar Material
                </button>
                <a href="/backend/material/listar" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>
                    Cancelar
                </a>
                <button type="button" onclick="confirmarExclusao(<?= $material['id_material'] ?>)" class="btn btn-danger">
                    <i class="bi bi-trash me-2"></i>
                    Excluir
                </button>
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
        color: var(--cor-acento);
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

    /* ==================== INFO CARD ==================== */
    .info-card {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: var(--spacing-xl);
        border: 1px solid #bae6fd;
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: #0c4a6e;
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .info-header i {
        font-size: 1.25rem;
    }

    .info-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-size: 0.8125rem;
        color: #0369a1;
        font-weight: 500;
    }

    .info-value {
        font-size: 0.9375rem;
        color: #0c4a6e;
        font-weight: 600;
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
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
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

    /* ==================== QUANTITY INPUT ==================== */
    .qty-input-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.5rem;
    }

    .qty-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: white;
        color: #64748b;
        font-size: 1.125rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .qty-btn:hover {
        background: var(--cor-acento);
        color: white;
        transform: scale(1.05);
    }

    .qty-btn:active {
        transform: scale(0.95);
    }

    .qty-input {
        flex: 1;
        text-align: center;
        font-weight: 700;
        font-size: 1.125rem;
        border: none;
        background: transparent;
        padding: 0.5rem;
    }

    .qty-input:focus {
        box-shadow: none;
    }

    /* ==================== CONTADOR DE CARACTERES ==================== */
    .char-counter {
        text-align: right;
        font-size: 0.8125rem;
        color: #64748b;
        margin-top: 0.5rem;
    }

    .char-counter.warning {
        color: #f59e0b;
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
        flex: 1;
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

    .btn-danger {
        background: linear-gradient(135deg, var(--cor-danger), #dc2626);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        margin-left: auto;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
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

        .btn-danger {
            margin-left: 0;
        }

        .info-content {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
// ==================== CONTROLE DE QUANTIDADE ====================
function changeQty(delta) {
    const input = document.getElementById('qtd_material');
    const currentValue = parseInt(input.value) || 0;
    const newValue = Math.max(0, currentValue + delta);
    input.value = newValue;
    
    // Atualiza visual baseado na quantidade
    updateQtyVisual(newValue);
}

function updateQtyVisual(qty) {
    const wrapper = document.querySelector('.qty-input-wrapper');
    wrapper.classList.remove('qty-empty', 'qty-low', 'qty-ok');
    
    if (qty === 0) {
        wrapper.classList.add('qty-empty');
    } else if (qty < 10) {
        wrapper.classList.add('qty-low');
    } else {
        wrapper.classList.add('qty-ok');
    }
}

// ==================== CONTADOR DE CARACTERES ====================
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('descricao_material');
    const charCount = document.getElementById('charCount');
    const counter = document.querySelector('.char-counter');
    
    if (textarea && charCount) {
        // Atualiza contador inicial
        charCount.textContent = textarea.value.length;
        
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;
            
            // Muda cor baseado no limite
            if (length > 450) {
                counter.classList.add('danger');
                counter.classList.remove('warning');
            } else if (length > 400) {
                counter.classList.add('warning');
                counter.classList.remove('danger');
            } else {
                counter.classList.remove('warning', 'danger');
            }
        });
    }
    
    // Atualiza visual inicial da quantidade
    const qtyInput = document.getElementById('qtd_material');
    if (qtyInput) {
        updateQtyVisual(parseInt(qtyInput.value) || 0);
    }
});

// ==================== CONFIRMAÇÃO DE EXCLUSÃO ====================
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este material?\n\nEsta ação não pode ser desfeita.')) {
        window.location.href = `/backend/material/excluir/${id}`;
    }
}

// ==================== VALIDAÇÃO DO FORMULÁRIO ====================
document.getElementById('formMaterial').addEventListener('submit', function(e) {
    const nome = document.getElementById('nome_material').value.trim();
    const qtd = document.getElementById('qtd_material').value;
    const descricao = document.getElementById('descricao_material').value.trim();
    const servico = document.getElementById('id_servico').value;
    
    let erros = [];
    
    if (!nome || nome.length < 3) {
        erros.push('O nome deve ter no mínimo 3 caracteres');
    }
    
    if (!qtd || qtd < 0) {
        erros.push('A quantidade deve ser maior ou igual a zero');
    }
    
    if (!descricao || descricao.length < 10) {
        erros.push('A descrição deve ter no mínimo 10 caracteres');
    }
    
    if (!servico) {
        erros.push('Selecione um serviço');
    }
    
    if (erros.length > 0) {
        e.preventDefault();
        alert('Erros encontrados:\n\n' + erros.join('\n'));
    }
});

// ==================== ATALHOS DE TECLADO ====================
document.getElementById('qtd_material').addEventListener('keydown', function(e) {
    if (e.key === 'ArrowUp') {
        e.preventDefault();
        changeQty(1);
    } else if (e.key === 'ArrowDown') {
        e.preventDefault();
        changeQty(-1);
    }
});
</script>