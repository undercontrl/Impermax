<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/admin/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/servico-site/listar">Serviços do Site</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Serviço #<?= $servico['id_servico'] ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Serviço do Site
                </h1>
                <p class="page-subtitle">Atualize as informações e imagem do serviço #<?= $servico['id_servico'] ?></p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/servico-site/atualizar/<?= $servico['id_servico'] ?>" method="POST" enctype="multipart/form-data" id="formServicoSite">
            
            <!-- Hidden: foto atual -->
            <input type="hidden" name="foto_servico_atual" value="<?= htmlspecialchars($servico['foto_servico'] ?? '') ?>">
            
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-globe"></i>
                    Informações do Serviço
                </h3>
                
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="nome_servico" class="form-label">
                            Nome do Serviço <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-gear-fill input-icon"></i>
                            <input type="text" 
                                   id="nome_servico" 
                                   name="nome_servico" 
                                   class="form-control" 
                                   value="<?= htmlspecialchars($servico['nome_servico']) ?>"
                                   placeholder="Ex: Impermeabilização de Laje"
                                   minlength="3"
                                   maxlength="255"
                                   required>
                        </div>
                        <small class="form-hint">Nome que será exibido no site para os visitantes</small>
                    </div>

                    <div class="form-group full-width">
                        <label for="descricao_servico" class="form-label">
                            Descrição do Serviço <span class="required">*</span>
                        </label>
                        <div class="textarea-wrapper">
                            <i class="bi bi-text-left textarea-icon"></i>
                            <textarea id="descricao_servico" 
                                      name="descricao_servico" 
                                      class="form-control form-textarea" 
                                      rows="6"
                                      placeholder="Descreva o serviço de forma atrativa..."
                                      minlength="10"
                                      maxlength="1000"
                                      required><?= htmlspecialchars($servico['descricao_servico']) ?></textarea>
                        </div>
                        <small class="form-hint">
                            <span id="char-count"><?= strlen($servico['descricao_servico']) ?></span>/1000 caracteres
                        </small>
                    </div>

                    <div class="form-group full-width">
                        <label for="status_servico" class="form-label">
                            Status de Exibição <span class="required">*</span>
                        </label>
                        <div class="status-selector-edit">
                            <label class="status-option-edit">
                                <input type="radio" 
                                       name="status_servico" 
                                       value="Ativo" 
                                       <?= (strcasecmp($servico['status_servico'], 'Ativo') === 0) ? 'checked' : '' ?>>
                                <span class="status-card-edit status-ativo">
                                    <i class="bi bi-eye-fill"></i>
                                    <span class="status-text">Ativo no Site</span>
                                </span>
                            </label>
                            
                            <label class="status-option-edit">
                                <input type="radio" 
                                       name="status_servico" 
                                       value="Inativo" 
                                       <?= (strcasecmp($servico['status_servico'], 'Inativo') === 0) ? 'checked' : '' ?>>
                                <span class="status-card-edit status-inativo">
                                    <i class="bi bi-eye-slash-fill"></i>
                                    <span class="status-text">Inativo (Oculto)</span>
                                </span>
                            </label>
                        </div>
                        <small class="form-hint">Define se o serviço aparece no site público</small>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-image"></i>
                    Imagem do Serviço
                </h3>
                
                <!-- Imagem Atual -->
                <?php if (!empty($servico['foto_servico'])): ?>
                <div class="current-image-section">
                    <label class="form-label">Imagem Atual</label>
                    <div class="current-image-wrapper">
                        <img src="/backend/upload/<?= htmlspecialchars($servico['foto_servico']) ?>" 
                             alt="<?= htmlspecialchars($servico['nome_servico']) ?>"
                             id="currentImage">
                        <div class="current-image-info">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Imagem carregada</span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Upload Nova Imagem -->
                <div class="upload-area" id="uploadArea">
                    <input type="file" 
                           id="foto_servico" 
                           name="foto_servico" 
                           class="file-input" 
                           accept="image/jpeg,image/png,image/webp">
                    
                    <div class="upload-content" id="uploadContent">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div class="upload-text">
                            <strong>Clique para alterar a imagem</strong> ou arraste aqui
                        </div>
                        <div class="upload-info">
                            JPG, PNG ou WEBP • Máximo 5MB • Deixe vazio para manter a atual
                        </div>
                    </div>

                    <!-- Preview da nova imagem -->
                    <div class="preview-container" id="previewContainer" style="display: none;">
                        <img id="imagePreview" src="" alt="Preview">
                        <div class="preview-overlay">
                            <button type="button" class="btn-change-image" onclick="document.getElementById('foto_servico').click()">
                                <i class="bi bi-pencil"></i>
                                Alterar Imagem
                            </button>
                            <button type="button" class="btn-remove-image" onclick="removeNewImage()">
                                <i class="bi bi-x-lg"></i>
                                Remover
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informação de Atualização -->
            <div class="info-box info-secondary">
                <div class="info-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="info-content">
                    <?php if (!empty($servico['atualizado_em'])): ?>
                    <strong>Última atualização:</strong> 
                    <?= date('d/m/Y \à\s H:i', strtotime($servico['atualizado_em'])) ?>
                    <br>
                    <?php endif; ?>
                    <strong>Criado em:</strong> 
                    <?= date('d/m/Y \à\s H:i', strtotime($servico['criado_em'])) ?>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/servico-site/listar" class="btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Salvar Alterações
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
    .breadcrumb-nav {
        margin-bottom: 1.5rem;
    }

    .breadcrumb {
        display: flex;
        flex-wrap: wrap;
        padding: 0;
        margin: 0;
        list-style: none;
        background: transparent;
    }

    .breadcrumb-item {
        font-size: 0.875rem;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        padding: 0 0.5rem;
        color: #94a3b8;
    }

    .breadcrumb-item a {
        color: #64748b;
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: var(--cor-acento);
    }

    .breadcrumb-item.active {
        color: #1e293b;
        font-weight: 500;
    }

    /* Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
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

    /* Formulário */
    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        padding: 2rem;
    }

    .form-section {
        margin-bottom: 2rem;
    }

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

    .section-title i {
        color: var(--cor-acento);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
    }

    .required {
        color: var(--cor-danger);
    }

    .input-wrapper,
    .textarea-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.125rem;
        z-index: 1;
    }

    .textarea-icon {
        position: absolute;
        left: 1rem;
        top: 1rem;
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

    .form-textarea {
        min-height: 150px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    .form-hint {
        font-size: 0.8125rem;
        color: #94a3b8;
        margin-top: 0.375rem;
    }

    /* Status Selector (Edit) */
    .status-selector-edit {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .status-option-edit {
        cursor: pointer;
    }

    .status-option-edit input[type="radio"] {
        display: none;
    }

    .status-card-edit {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1.25rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.2s;
        background: white;
    }

    .status-card-edit i {
        font-size: 1.75rem;
    }

    .status-text {
        font-size: 0.875rem;
        font-weight: 600;
    }

    .status-option-edit input:checked + .status-card-edit {
        border-width: 2px;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .status-ativo {
        color: #166534;
    }

    .status-option-edit input:checked + .status-ativo {
        background: #dcfce7;
        border-color: #22c55e;
    }

    .status-inativo {
        color: #991b1b;
    }

    .status-option-edit input:checked + .status-inativo {
        background: #fee2e2;
        border-color: #ef4444;
    }

    /* Imagem Atual */
    .current-image-section {
        margin-bottom: 1.5rem;
    }

    .current-image-wrapper {
        position: relative;
        max-width: 400px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
    }

    .current-image-wrapper img {
        width: 100%;
        height: auto;
        display: block;
    }

    .current-image-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: #f0fdf4;
        border-top: 1px solid #bbf7d0;
        color: #166534;
        font-size: 0.875rem;
        font-weight: 600;
    }

    /* Upload Area */
    .upload-area {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        background: #f8fafc;
    }

    .upload-area:hover {
        border-color: var(--cor-acento);
        background: #eff6ff;
    }

    .file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .upload-content {
        pointer-events: none;
    }

    .upload-icon {
        font-size: 3rem;
        color: var(--cor-acento);
        margin-bottom: 1rem;
    }

    .upload-text {
        font-size: 0.9375rem;
        color: #334155;
        margin-bottom: 0.5rem;
    }

    .upload-text strong {
        color: var(--cor-acento);
    }

    .upload-info {
        font-size: 0.8125rem;
        color: #94a3b8;
    }

    /* Preview */
    .preview-container {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
    }

    .preview-container img {
        width: 100%;
        height: auto;
        display: block;
    }

    .preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .preview-container:hover .preview-overlay {
        opacity: 1;
    }

    .btn-change-image,
    .btn-remove-image {
        padding: 0.625rem 1.25rem;
        background: white;
        color: #1e293b;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-remove-image {
        background: var(--cor-danger);
        color: white;
    }

    .btn-change-image:hover,
    .btn-remove-image:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Info Box */
    .info-box {
        display: flex;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        margin-bottom: 2rem;
    }

    .info-box.info-secondary .info-icon {
        color: #64748b;
    }

    .info-box.info-secondary .info-content {
        color: #475569;
    }

    .info-icon {
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .info-content {
        font-size: 0.875rem;
        line-height: 1.6;
    }

    /* Botões de Ação */
    .form-actions {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f1f5f9;
    }

    .btn-primary,
    .btn-secondary {
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

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
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
        .form-grid {
            grid-template-columns: 1fr;
        }

        .status-selector-edit {
            grid-template-columns: 1fr;
        }

        .upload-area {
            padding: 1.5rem 1rem;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
        }

        .preview-overlay {
            opacity: 1;
            background: rgba(0, 0, 0, 0.5);
        }
    }
</style>

<script>
// Contador de caracteres
const textarea = document.getElementById('descricao_servico');
const charCount = document.getElementById('char-count');

textarea.addEventListener('input', function() {
    charCount.textContent = this.value.length;
});

// Upload de imagem com preview
const fileInput = document.getElementById('foto_servico');
const uploadArea = document.getElementById('uploadArea');
const uploadContent = document.getElementById('uploadContent');
const previewContainer = document.getElementById('previewContainer');
const imagePreview = document.getElementById('imagePreview');
const currentImage = document.getElementById('currentImage');

fileInput.addEventListener('change', function(e) {
    handleFile(this.files[0]);
});

// Drag and drop
uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.borderColor = 'var(--cor-acento)';
    this.style.background = '#eff6ff';
});

uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.style.borderColor = '';
    this.style.background = '';
});

uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.borderColor = '';
    this.style.background = '';
    
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        handleFile(file);
    }
});

function handleFile(file) {
    if (!file) return;
    
    // Valida tipo
    const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        alert('Por favor, selecione uma imagem JPG, PNG ou WEBP.');
        return;
    }
    
    // Valida tamanho
    const maxSize = 5 * 1024 * 1024;
    if (file.size > maxSize) {
        alert('A imagem deve ter no máximo 5MB.');
        return;
    }
    
    // Mostra preview
    const reader = new FileReader();
    reader.onload = function(e) {
        imagePreview.src = e.target.result;
        uploadContent.style.display = 'none';
        previewContainer.style.display = 'block';
    };
    reader.readAsDataURL(file);
}

// Remove nova imagem
function removeNewImage() {
    fileInput.value = '';
    uploadContent.style.display = 'block';
    previewContainer.style.display = 'none';
}

// Validação do formulário
document.getElementById('formServicoSite').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('.btn-primary');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Salvando...';
});
</script>