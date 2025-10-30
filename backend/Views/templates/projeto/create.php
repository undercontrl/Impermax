<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/projeto/listar">Projetos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Novo Projeto</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Novo Projeto
                </h1>
                <p class="page-subtitle">Adicione fotos antes e depois do projeto</p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/projeto/salvar" method="post" enctype="multipart/form-data" id="formProjeto">
            
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-images"></i>
                    Fotos do Projeto
                </h3>
                
                <div class="upload-grid">
                    <!-- Upload Foto ANTES -->
                    <div class="upload-area">
                        <label class="upload-label">Foto ANTES <span class="required">*</span></label>
                        <div class="upload-zone" id="uploadAntes">
                            <input type="file" 
                                   name="foto_antes_projeto" 
                                   id="foto_antes_projeto" 
                                   accept="image/*" 
                                   required 
                                   hidden>
                            <div class="upload-content">
                                <i class="bi bi-cloud-upload"></i>
                                <p class="upload-text">Clique ou arraste a foto</p>
                                <span class="upload-hint">PNG, JPG até 5MB</span>
                            </div>
                            <div class="upload-preview" style="display: none;">
                                <img src="" alt="Preview" id="previewAntes">
                                <button type="button" class="btn-remove-image" onclick="removerImagem('antes')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                                <span class="image-badge badge-antes">ANTES</span>
                            </div>
                        </div>
                        <small class="form-hint">Foto do estado inicial do projeto</small>
                    </div>

                    <!-- Upload Foto DEPOIS -->
                    <div class="upload-area">
                        <label class="upload-label">Foto DEPOIS <span class="required">*</span></label>
                        <div class="upload-zone" id="uploadDepois">
                            <input type="file" 
                                   name="foto_depois_projeto" 
                                   id="foto_depois_projeto" 
                                   accept="image/*" 
                                   required 
                                   hidden>
                            <div class="upload-content">
                                <i class="bi bi-cloud-upload"></i>
                                <p class="upload-text">Clique ou arraste a foto</p>
                                <span class="upload-hint">PNG, JPG até 5MB</span>
                            </div>
                            <div class="upload-preview" style="display: none;">
                                <img src="" alt="Preview" id="previewDepois">
                                <button type="button" class="btn-remove-image" onclick="removerImagem('depois')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                                <span class="image-badge badge-depois">DEPOIS</span>
                            </div>
                        </div>
                        <small class="form-hint">Foto do resultado final do projeto</small>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-file-text"></i>
                    Descrição do Projeto
                </h3>
                
                <div class="form-group">
                    <label for="descricao_projeto" class="form-label">
                        Descrição <span class="required">*</span>
                    </label>
                    <textarea id="descricao_projeto" 
                              name="descricao_projeto" 
                              class="form-control" 
                              rows="6"
                              placeholder="Descreva os detalhes do projeto, técnicas utilizadas, materiais..."
                              required></textarea>
                    <small class="form-hint">Explique o que foi realizado neste projeto</small>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/projeto/listar" class="btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Criar Projeto
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
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 1rem;
    }

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

    .form-section:last-of-type {
        margin-bottom: 0;
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

    .upload-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }

    .upload-area {
        display: flex;
        flex-direction: column;
    }

    .upload-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.75rem;
    }

    .required {
        color: var(--cor-danger);
    }

    .upload-zone {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        transition: all 0.3s;
        cursor: pointer;
        overflow: hidden;
        aspect-ratio: 4/3;
    }

    .upload-zone:hover {
        border-color: var(--cor-acento);
        background: #f0f9ff;
    }

    .upload-zone.dragover {
        border-color: var(--cor-acento);
        background: #dbeafe;
        transform: scale(1.02);
    }

    .upload-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 2rem;
        text-align: center;
    }

    .upload-content i {
        font-size: 3rem;
        color: #94a3b8;
        margin-bottom: 1rem;
    }

    .upload-text {
        font-size: 1rem;
        font-weight: 600;
        color: #334155;
        margin: 0 0 0.5rem 0;
    }

    .upload-hint {
        font-size: 0.8125rem;
        color: #94a3b8;
    }

    .upload-preview {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .upload-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn-remove-image {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        z-index: 10;
    }

    .btn-remove-image:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .image-badge {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: white;
        z-index: 5;
    }

    .badge-antes {
        background: rgba(0, 0, 0, 0.7);
    }

    .badge-depois {
        background: rgba(34, 197, 94, 0.9);
    }

    .form-hint {
        font-size: 0.8125rem;
        color: #94a3b8;
        margin-top: 0.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: all 0.2s;
        background: white;
        font-family: inherit;
        line-height: 1.5;
        resize: vertical;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

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

    .btn-secondary {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    @media (max-width: 768px) {
        .upload-grid {
            grid-template-columns: 1fr;
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
// ==================== UPLOAD DE IMAGENS ====================
function setupImageUpload(inputId, zoneId, previewId, tipo) {
    const input = document.getElementById(inputId);
    const zone = document.getElementById(zoneId);
    const preview = document.getElementById(previewId);
    const uploadContent = zone.querySelector('.upload-content');
    const uploadPreview = zone.querySelector('.upload-preview');
    
    // Click para abrir seletor
    zone.addEventListener('click', () => input.click());
    
    // Drag and drop
    zone.addEventListener('dragover', (e) => {
        e.preventDefault();
        zone.classList.add('dragover');
    });
    
    zone.addEventListener('dragleave', () => {
        zone.classList.remove('dragover');
    });
    
    zone.addEventListener('drop', (e) => {
        e.preventDefault();
        zone.classList.remove('dragover');
        
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            handleImageUpload(file, preview, uploadContent, uploadPreview);
        }
    });
    
    // Seleção de arquivo
    input.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            handleImageUpload(file, preview, uploadContent, uploadPreview);
        }
    });
}

function handleImageUpload(file, preview, uploadContent, uploadPreview) {
    // Validar tamanho (5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('A imagem deve ter no máximo 5MB!');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = (e) => {
        preview.src = e.target.result;
        uploadContent.style.display = 'none';
        uploadPreview.style.display = 'block';
    };
    reader.readAsDataURL(file);
}

function removerImagem(tipo) {
    const input = document.getElementById(`foto_${tipo}_projeto`);
    const preview = document.getElementById(`preview${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`);
    const zone = document.getElementById(`upload${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`);
    const uploadContent = zone.querySelector('.upload-content');
    const uploadPreview = zone.querySelector('.upload-preview');
    
    input.value = '';
    preview.src = '';
    uploadContent.style.display = 'flex';
    uploadPreview.style.display = 'none';
    
    event.stopPropagation();
}

// Inicializar uploads
document.addEventListener('DOMContentLoaded', () => {
    setupImageUpload('foto_antes_projeto', 'uploadAntes', 'previewAntes', 'antes');
    setupImageUpload('foto_depois_projeto', 'uploadDepois', 'previewDepois', 'depois');
});

// Validação do formulário
document.getElementById('formProjeto').addEventListener('submit', (e) => {
    const fotoAntes = document.getElementById('foto_antes_projeto').files[0];
    const fotoDepois = document.getElementById('foto_depois_projeto').files[0];
    
    if (!fotoAntes || !fotoDepois) {
        e.preventDefault();
        alert('Por favor, adicione ambas as fotos (antes e depois)!');
        return false;
    }
});
</script>