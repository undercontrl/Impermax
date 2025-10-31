<div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Novo Projeto
                </h1>
                <p class="page-subtitle">Adicione um novo projeto antes e depois</p>
            </div>
            <a href="/backend/projeto/listar" class="btn-action-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar
            </a>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/projeto/salvar" method="POST" enctype="multipart/form-data" id="formProjeto">
            
            <!-- Seção: Imagens -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="bi bi-image"></i>
                        Imagens do Projeto
                    </h3>
                    <p class="section-subtitle">Adicione as fotos antes e depois da transformação</p>
                </div>

                <div class="images-grid">
                    <!-- Foto ANTES -->
                    <div class="form-group">
                        <label for="foto_antes_projeto" class="form-label required">
                            <i class="bi bi-camera"></i>
                            Foto ANTES
                        </label>
                        <div class="image-upload-wrapper">
                            <input type="file" 
                                   name="foto_antes_projeto" 
                                   id="foto_antes_projeto" 
                                   class="image-input"
                                   accept="image/jpeg,image/png,image/webp"
                                   required
                                   onchange="previewImage(this, 'preview_antes')">
                            <div class="image-upload-area" id="upload_antes" onclick="document.getElementById('foto_antes_projeto').click()">
                                <i class="bi bi-cloud-upload"></i>
                                <span>Clique para selecionar</span>
                                <small>JPG, PNG ou WEBP (máx. 5MB)</small>
                            </div>
                            <div class="image-preview" id="preview_antes" style="display: none;">
                                <img src="" alt="Preview Antes">
                                <button type="button" class="btn-remove-image" onclick="removeImage('foto_antes_projeto', 'preview_antes')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-hint">Recomendado: mínimo 400x300 pixels</small>
                    </div>

                    <!-- Foto DEPOIS -->
                    <div class="form-group">
                        <label for="foto_depois_projeto" class="form-label required">
                            <i class="bi bi-camera"></i>
                            Foto DEPOIS
                        </label>
                        <div class="image-upload-wrapper">
                            <input type="file" 
                                   name="foto_depois_projeto" 
                                   id="foto_depois_projeto" 
                                   class="image-input"
                                   accept="image/jpeg,image/png,image/webp"
                                   required
                                   onchange="previewImage(this, 'preview_depois')">
                            <div class="image-upload-area" id="upload_depois" onclick="document.getElementById('foto_depois_projeto').click()">
                                <i class="bi bi-cloud-upload"></i>
                                <span>Clique para selecionar</span>
                                <small>JPG, PNG ou WEBP (máx. 5MB)</small>
                            </div>
                            <div class="image-preview" id="preview_depois" style="display: none;">
                                <img src="" alt="Preview Depois">
                                <button type="button" class="btn-remove-image" onclick="removeImage('foto_depois_projeto', 'preview_depois')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-hint">Recomendado: mínimo 400x300 pixels</small>
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
                              maxlength="500"></textarea>
                    <div class="char-counter">
                        <span id="charCount">0</span> / 500 caracteres
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
                    Salvar Projeto
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

    /* Grid de Imagens */
    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
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

    /* Upload de Imagens */
    .image-upload-wrapper {
        position: relative;
    }

    .image-input {
        display: none;
    }

    .image-upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8fafc;
    }

    .image-upload-area:hover {
        border-color: var(--cor-acento);
        background: #f0f9ff;
    }

    .image-upload-area i {
        font-size: 3rem;
        color: #94a3b8;
        display: block;
        margin-bottom: 1rem;
    }

    .image-upload-area span {
        display: block;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
    }

    .image-upload-area small {
        display: block;
        color: #64748b;
        font-size: 0.8125rem;
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
    }

    .btn-remove-image:hover {
        background: var(--cor-danger);
        transform: scale(1.1);
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
// Preview de Imagem
function previewImage(input, previewId) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const uploadArea = preview.previousElementSibling;
            
            preview.querySelector('img').src = e.target.result;
            uploadArea.style.display = 'none';
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

// Remover Imagem
function removeImage(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const uploadArea = preview.previousElementSibling;
    
    input.value = '';
    preview.querySelector('img').src = '';
    preview.style.display = 'none';
    uploadArea.style.display = 'block';
}

// Contador de Caracteres
document.getElementById('descricao_projeto').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('charCount').textContent = count;
    
    if (count > 500) {
        document.getElementById('charCount').style.color = 'var(--cor-danger)';
    } else {
        document.getElementById('charCount').style.color = '#64748b';
    }
});

// Validação antes de enviar
document.getElementById('formProjeto').addEventListener('submit', function(e) {
    const fotoAntes = document.getElementById('foto_antes_projeto').files[0];
    const fotoDepois = document.getElementById('foto_depois_projeto').files[0];
    const descricao = document.getElementById('descricao_projeto').value;
    
    if (!fotoAntes || !fotoDepois) {
        e.preventDefault();
        alert('Por favor, adicione as duas fotos (ANTES e DEPOIS).');
        return false;
    }
    
    if (descricao.length < 10) {
        e.preventDefault();
        alert('A descrição deve ter no mínimo 10 caracteres.');
        return false;
    }
    
    if (descricao.length > 500) {
        e.preventDefault();
        alert('A descrição deve ter no máximo 500 caracteres.');
        return false;
    }
    
    // Mostrar loading
    const btnSubmit = this.querySelector('.btn-form-submit');
    btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Salvando...';
    btnSubmit.disabled = true;
});
</script>