<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/projeto/listar">Projetos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar #<?= htmlspecialchars($projeto['id_projeto']) ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Projeto #<?= htmlspecialchars($projeto['id_projeto']) ?>
                </h1>
                <p class="page-subtitle">Atualize as fotos ou descrição do projeto</p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/projeto/atualizar/<?= htmlspecialchars($projeto['id_projeto']) ?>" method="post" enctype="multipart/form-data" id="formProjeto">
            
            <input type="hidden" name="foto_antes_atual" value="<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>">
            <input type="hidden" name="foto_depois_atual" value="<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>">
            
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-images"></i>
                    Fotos do Projeto
                </h3>
                
                <div class="upload-grid">
                    <!-- Upload Foto ANTES -->
                    <div class="upload-area">
                        <label class="upload-label">Foto ANTES</label>
                        <div class="upload-zone" id="uploadAntes">
                            <input type="file" 
                                   name="foto_antes_projeto" 
                                   id="foto_antes_projeto" 
                                   accept="image/*" 
                                   hidden>
                            <div class="upload-content" style="display: none;">
                                <i class="bi bi-cloud-upload"></i>
                                <p class="upload-text">Clique ou arraste a foto</p>
                                <span class="upload-hint">PNG, JPG até 5MB</span>
                            </div>
                            <div class="upload-preview">
                                <img src="<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>" alt="Preview" id="previewAntes">
                                <button type="button" class="btn-change-image" onclick="trocarImagem('antes')">
                                    <i class="bi bi-camera"></i>
                                    Trocar Foto
                                </button>
                                <span class="image-badge badge-antes">ANTES</span>
                            </div>
                        </div>
                        <small class="form-hint">Clique em "Trocar Foto" para alterar</small>
                    </div>

                    <!-- Upload Foto DEPOIS -->
                    <div class="upload-area">
                        <label class="upload-label">Foto DEPOIS</label>
                        <div class="upload-zone" id="uploadDepois">
                            <input type="file" 
                                   name="foto_depois_projeto" 
                                   id="foto_depois_projeto" 
                                   accept="image/*" 
                                   hidden>
                            <div class="upload-content" style="display: none;">
                                <i class="bi bi-cloud-upload"></i>
                                <p class="upload-text">Clique ou arraste a foto</p>
                                <span class="upload-hint">PNG, JPG até 5MB</span>
                            </div>
                            <div class="upload-preview">
                                <img src="<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>" alt="Preview" id="previewDepois">
                                <button type="button" class="btn-change-image" onclick="trocarImagem('depois')">
                                    <i class="bi bi-camera"></i>
                                    Trocar Foto
                                </button>
                                <span class="image-badge badge-depois">DEPOIS</span>
                            </div>
                        </div>
                        <small class="form-hint">Clique em "Trocar Foto" para alterar</small>
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
                              required><?= htmlspecialchars($projeto['descricao_projeto']) ?></textarea>
                    <small class="form-hint">Explique o que foi realizado neste projeto</small>
                </div>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <i class="bi bi-info-circle-fill"></i>
                <div>
                    <strong>Informação:</strong> Se não trocar as fotos, as imagens atuais serão mantidas.
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/projeto/listar" class="btn-secondary">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
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
        --cor-danger: #ef4444;
        --cor-info: #3b82f6;
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
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        background: white;
        overflow: hidden;
        aspect-ratio: 4/3;
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

    .btn-change-image {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        border: none;
        background: rgba(20, 135, 223, 0.95);
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    .btn-change-image:hover {
        background: #0e6eb8;
        transform: translateX(-50%) translateY(-2px);
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
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
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

    .info-box {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 10px;
        margin-top: 1.5rem;
        color: #0c4a6e;
    }

    .info-box i {
        font-size: 1.25rem;
        color: var(--cor-info);
        flex-shrink: 0;
        margin-top: 0.125rem;
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
function trocarImagem(tipo) {
    document.getElementById(`foto_${tipo}_projeto`).click();
}

function setupImageChange(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    input.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('A imagem deve ter no máximo 5MB!');
                input.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setupImageChange('foto_antes_projeto', 'previewAntes');
    setupImageChange('foto_depois_projeto', 'previewDepois');
});
</script>