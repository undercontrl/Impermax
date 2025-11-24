<div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Projeto #<?= htmlspecialchars($projeto['id_projeto']) ?>
                </h1>
                <p class="page-subtitle">Atualize as informações do projeto</p>
            </div>
            <a href="/backend/projeto/listar" class="btn-action-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar
            </a>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/projeto/atualizar" method="POST" enctype="multipart/form-data" id="formProjeto">
            <input type="hidden" name="id_projeto" value="<?= htmlspecialchars($projeto['id_projeto']) ?>">
            
            <!-- Seção: Imagens -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="bi bi-image"></i>
                        Imagens do Projeto
                    </h3>
                    <p class="section-subtitle">Atualize as fotos (opcional - deixe em branco para manter as atuais)</p>
                </div>

                <div class="images-grid">
                    <!-- Foto ANTES -->
                    <div class="form-group">
                        <label for="foto_antes_projeto" class="form-label">
                            <i class="bi bi-camera"></i>
                            Foto ANTES
                        </label>
                        <div class="image-upload-wrapper">
                            <input type="file" 
                                   name="foto_antes_projeto" 
                                   id="foto_antes_projeto" 
                                   class="image-input"
                                   accept="image/jpeg,image/png,image/webp,image/jpg"
                                   onchange="previewImage(this, 'preview_antes')">
                            
                            <!-- Preview Atual -->
                            <?php if (!empty($projeto['foto_antes_projeto'])): ?>
                            <div class="image-preview current" id="current_antes">
                                <img src="/upload/<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>" 
                                     alt="Foto Antes Atual"
                                     onerror="this.src='/assets/img/no-image.png'">
                                <div class="image-overlay">
                                    <button type="button" class="btn-change-image" onclick="document.getElementById('foto_antes_projeto').click()">
                                        <i class="bi bi-arrow-repeat"></i>
                                        Alterar Imagem
                                    </button>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="image-placeholder" onclick="document.getElementById('foto_antes_projeto').click()">
                                <i class="bi bi-image"></i>
                                <p>Clique para adicionar imagem</p>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Preview Nova -->
                            <div class="image-preview" id="preview_antes" style="display: none;">
                                <img src="" alt="Preview Antes">
                                <button type="button" class="btn-remove-image" onclick="cancelImageChange('foto_antes_projeto', 'preview_antes', 'current_antes')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-hint">Deixe em branco para manter a imagem atual</small>
                    </div>

                    <!-- Foto DEPOIS -->
                    <div class="form-group">
                        <label for="foto_depois_projeto" class="form-label">
                            <i class="bi bi-camera"></i>
                            Foto DEPOIS
                        </label>
                        <div class="image-upload-wrapper">
                            <input type="file" 
                                   name="foto_depois_projeto" 
                                   id="foto_depois_projeto" 
                                   class="image-input"
                                   accept="image/jpeg,image/png,image/webp,image/jpg"
                                   onchange="previewImage(this, 'preview_depois')">
                            
                            <!-- Preview Atual -->
                            <?php if (!empty($projeto['foto_depois_projeto'])): ?>
                            <div class="image-preview current" id="current_depois">
                                <img src="/upload/<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>" 
                                     alt="Foto Depois Atual"
                                     onerror="this.src='/assets/img/no-image.png'">
                                <div class="image-overlay">
                                    <button type="button" class="btn-change-image" onclick="document.getElementById('foto_depois_projeto').click()">
                                        <i class="bi bi-arrow-repeat"></i>
                                        Alterar Imagem
                                    </button>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="image-placeholder" onclick="document.getElementById('foto_depois_projeto').click()">
                                <i class="bi bi-image"></i>
                                <p>Clique para adicionar imagem</p>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Preview Nova -->
                            <div class="image-preview" id="preview_depois" style="display: none;">
                                <img src="" alt="Preview Depois">
                                <button type="button" class="btn-remove-image" onclick="cancelImageChange('foto_depois_projeto', 'preview_depois', 'current_depois')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-hint">Deixe em branco para manter a imagem atual</small>
                    </div>
                </div>
            </div>

            <!-- Seção: Descrição -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="bi bi-card-text"></i>
                        Descrição
                    </h3>
                    <p class="section-subtitle">Descreva os detalhes e melhorias do projeto</p>
                </div>

                <div class="form-group">
                    <label for="descricao_projeto" class="form-label required">
                        Descrição do Projeto
                    </label>
                    <textarea name="descricao_projeto" 
                              id="descricao_projeto" 
                              class="form-textarea"
                              rows="6"
                              placeholder="Descreva as melhorias, técnicas utilizadas, resultados alcançados..."
                              required
                              minlength="10"
                              maxlength="500"><?= htmlspecialchars($projeto['descricao_projeto']) ?></textarea>
                    <div class="char-counter">
                        <span id="charCount"><?= mb_strlen($projeto['descricao_projeto']) ?></span> / 500 caracteres
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/projeto/listar" class="btn-form-cancel">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn-form-submit">
                    <i class="bi bi-check-lg"></i>
                    Atualizar Projeto
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
        color: var(--cor-acento);
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

    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

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

    .image-upload-wrapper {
        position: relative;
    }

    .image-input {
        display: none;
    }

    .image-preview {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
    }

    .image-preview img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        display: block;
    }

    .image-preview.current {
        border-color: var(--cor-success);
    }

    .image-placeholder {
        height: 300px;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8fafc;
    }

    .image-placeholder:hover {
        border-color: var(--cor-acento);
        background: #f0f9ff;
    }

    .image-placeholder i {
        font-size: 3rem;
        color: #cbd5e1;
    }

    .image-placeholder p {
        margin: 0;
        color: #94a3b8;
        font-size: 0.875rem;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s;
    }

    .image-preview.current:hover .image-overlay {
        opacity: 1;
    }

    .btn-change-image {
        padding: 0.75rem 1.5rem;
        border: 2px solid white;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.95);
        color: var(--cor-acento);
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-change-image:hover {
        background: white;
        transform: scale(1.05);
    }

    .btn-remove-image {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        z-index: 10;
    }

    .btn-remove-image:hover {
        background: var(--cor-danger);
        transform: scale(1.1);
    }

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

    .btn-form-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    @media (max-width: 768px) {
        .images-grid {
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
// Preview de Nova Imagem
function previewImage(input, previewId) {
    const file = input.files[0];
    if (file) {
        // Validar tamanho (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('A imagem não pode ser maior que 5MB!');
            input.value = '';
            return;
        }
        
        // Validar tipo
        const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            alert('Apenas imagens JPG, PNG ou WEBP são permitidas!');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const currentPreview = document.getElementById('current_' + previewId.replace('preview_', ''));
            
            preview.querySelector('img').src = e.target.result;
            if (currentPreview) {
                currentPreview.style.display = 'none';
            }
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

// Cancelar Alteração de Imagem
function cancelImageChange(inputId, previewId, currentId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const currentPreview = document.getElementById(currentId);
    
    input.value = '';
    preview.querySelector('img').src = '';
    preview.style.display = 'none';
    if (currentPreview) {
        currentPreview.style.display = 'block';
    }
}

// Contador de Caracteres
const textarea = document.getElementById('descricao_projeto');
const charCount = document.getElementById('charCount');

textarea.addEventListener('input', function() {
    const count = this.value.length;
    charCount.textContent = count;
    
    if (count > 500) {
        charCount.style.color = 'var(--cor-danger)';
        charCount.style.fontWeight = '700';
    } else if (count > 450) {
        charCount.style.color = 'var(--cor-warning, #f59e0b)';
        charCount.style.fontWeight = '600';
    } else {
        charCount.style.color = '#64748b';
        charCount.style.fontWeight = '400';
    }
});

// Validação antes de enviar
document.getElementById('formProjeto').addEventListener('submit', function(e) {
    const descricao = document.getElementById('descricao_projeto').value.trim();
    
    if (descricao.length < 10) {
        e.preventDefault();
        alert('A descrição deve ter no mínimo 10 caracteres.');
        document.getElementById('descricao_projeto').focus();
        return false;
    }
    
    if (descricao.length > 500) {
        e.preventDefault();
        alert('A descrição deve ter no máximo 500 caracteres.');
        document.getElementById('descricao_projeto').focus();
        return false;
    }
    
    // Mostrar loading
    const btnSubmit = this.querySelector('.btn-form-submit');
    btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Atualizando...';
    btnSubmit.disabled = true;
    
    return true;
});
</script>