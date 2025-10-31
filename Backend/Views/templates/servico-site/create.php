<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/servico-site/listar">Serviços do Site</a></li>
            <li class="breadcrumb-item active" aria-current="page">Novo Serviço</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Novo Serviço para o Site
                </h1>
                <p class="page-subtitle">Adicione um serviço com foto para exibição no site público</p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/servico-site/salvar" method="POST" enctype="multipart/form-data" id="formServicoSite">
            
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
                                      placeholder="Descreva o serviço de forma atrativa para os visitantes do site. Destaque os benefícios e diferenciais..."
                                      minlength="10"
                                      maxlength="1000"
                                      required></textarea>
                        </div>
                        <small class="form-hint">
                            <span id="char-count">0</span>/1000 caracteres
                        </small>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-image"></i>
                    Imagem do Serviço
                </h3>
                
                <div class="upload-area" id="uploadArea">
                    <input type="file" 
                           id="foto_servico" 
                           name="foto_servico" 
                           class="file-input" 
                           accept="image/jpeg,image/png,image/webp"
                           required>
                    
                    <div class="upload-content" id="uploadContent">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div class="upload-text">
                            <strong>Clique para selecionar</strong> ou arraste a imagem aqui
                        </div>
                        <div class="upload-info">
                            JPG, PNG ou WEBP • Máximo 5MB • Tamanho ideal: 800x600px
                        </div>
                    </div>

                    <!-- Preview da imagem -->
                    <div class="preview-container" id="previewContainer" style="display: none;">
                        <img id="imagePreview" src="" alt="Preview">
                        <div class="preview-overlay">
                            <button type="button" class="btn-change-image" onclick="document.getElementById('foto_servico').click()">
                                <i class="bi bi-pencil"></i>
                                Alterar Imagem
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informação Adicional -->
            <div class="info-box">
                <div class="info-icon">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
                <div class="info-content">
                    <strong>Dica:</strong> Use imagens de alta qualidade e que representem bem o serviço. 
                    A imagem será redimensionada automaticamente para o tamanho ideal. 
                    O serviço será criado como <strong>Inativo</strong> por padrão - você pode ativá-lo depois na listagem.
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
                    Criar Serviço
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

    /* Upload Area */
    .upload-area {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        background: #f8fafc;
    }

    .upload-area:hover {
        border-color: var(--cor-acento);
        background: #eff6ff;
    }

    .upload-area.dragover {
        border-color: var(--cor-acento);
        background: #eff6ff;
        transform: scale(1.02);
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
        font-size: 4rem;
        color: var(--cor-acento);
        margin-bottom: 1rem;
    }

    .upload-text {
        font-size: 1rem;
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
        max-width: 500px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
    }

    .preview-container img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 12px;
    }

    .preview-overlay {
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
        transition: opacity 0.3s;
    }

    .preview-container:hover .preview-overlay {
        opacity: 1;
    }

    .btn-change-image {
        padding: 0.75rem 1.5rem;
        background: white;
        color: #1e293b;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-change-image:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Info Box */
    .info-box {
        display: flex;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        margin-bottom: 2rem;
    }

    .info-icon {
        color: #3b82f6;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .info-content {
        font-size: 0.875rem;
        color: #1e40af;
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

        .upload-area {
            padding: 2rem 1rem;
        }

        .upload-icon {
            font-size: 3rem;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
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

fileInput.addEventListener('change', function(e) {
    handleFile(this.files[0]);
});

// Drag and drop
uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
});

uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        // Simula a seleção do arquivo
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        
        handleFile(file);
    }
});

function handleFile(file) {
    if (!file) return;
    
    // Valida tipo de arquivo
    const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        alert('Por favor, selecione uma imagem JPG, PNG ou WEBP.');
        return;
    }
    
    // Valida tamanho (5MB)
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

// Validação do formulário
document.getElementById('formServicoSite').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('foto_servico');
    
    if (!fileInput.files || fileInput.files.length === 0) {
        e.preventDefault();
        alert('Por favor, selecione uma imagem para o serviço.');
        return false;
    }
    
    // Desabilita botão de submit para evitar duplo clique
    const submitBtn = this.querySelector('.btn-primary');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Enviando...';
});

// Auto-focus no primeiro campo
document.getElementById('nome_servico').focus();
</script>