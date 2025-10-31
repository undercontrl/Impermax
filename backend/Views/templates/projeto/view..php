<?php if (!isset($projeto) || empty($projeto)): ?>
    <div class="page-wrapper">
        <div class="alert alert-danger">
            <h3>Projeto não encontrado</h3>
            <p>O projeto solicitado não existe ou foi excluído.</p>
            <a href="/backend/projeto/listar" class="btn-action-primary">Voltar para lista</a>
        </div>
    </div>
<?php else: ?>
<div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-eye-fill me-2"></i>
                    Projeto #<?= htmlspecialchars($projeto['id_projeto']) ?>
                </h1>
                <p class="page-subtitle">Visualização completa do projeto</p>
            </div>
            <div class="header-actions">
                <a href="/backend/projeto/editar/<?= $projeto['id_projeto'] ?>" class="btn-action-edit">
                    <i class="bi bi-pencil"></i>
                    Editar
                </a>
                <a href="/backend/projeto/listar" class="btn-action-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Card de Visualização -->
    <div class="view-card">
        <!-- Seção: Comparador de Imagens -->
        <div class="view-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="bi bi-images"></i>
                    Comparação Antes e Depois
                </h3>
            </div>

            <!-- Comparador Interativo -->
            <div class="before-after-viewer">
                <div class="before-after-slider-large" id="mainSlider">
                    <div class="image-before" style="background-image: url('/upload/<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>');"></div>
                    <div class="image-after" style="background-image: url('/upload/<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>');"></div>
                    <div class="slider-handle">
                        <div class="slider-line"></div>
                        <div class="slider-button">
                            <i class="bi bi-chevron-left"></i>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </div>
                    <div class="labels">
                        <span class="label-before">ANTES</span>
                        <span class="label-after">DEPOIS</span>
                    </div>
                </div>
            </div>

            <!-- Miniaturas -->
            <div class="thumbnails-grid">
                <div class="thumbnail-card">
                    <img src="/upload/<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>" alt="Antes">
                    <span class="thumbnail-label">Foto ANTES</span>
                </div>
                <div class="thumbnail-card">
                    <img src="/upload/<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>" alt="Depois">
                    <span class="thumbnail-label">Foto DEPOIS</span>
                </div>
            </div>
        </div>

        <!-- Seção: Informações -->
        <div class="view-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Informações do Projeto
                </h3>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">
                        <i class="bi bi-hash"></i>
                        ID do Projeto
                    </span>
                    <span class="info-value">#<?= htmlspecialchars($projeto['id_projeto']) ?></span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        <i class="bi bi-calendar-plus"></i>
                        Data de Criação
                    </span>
                    <span class="info-value"><?= date('d/m/Y \à\s H:i', strtotime($projeto['criado_em'])) ?></span>
                </div>

                <?php if ($projeto['atualizado_em']): ?>
                <div class="info-item">
                    <span class="info-label">
                        <i class="bi bi-calendar-check"></i>
                        Última Atualização
                    </span>
                    <span class="info-value"><?= date('d/m/Y \à\s H:i', strtotime($projeto['atualizado_em'])) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Seção: Descrição -->
        <div class="view-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="bi bi-card-text"></i>
                    Descrição do Projeto
                </h3>
            </div>

            <div class="description-box">
                <p><?= nl2br(htmlspecialchars($projeto['descricao_projeto'])) ?></p>
            </div>
        </div>

        <!-- Ações -->
        <div class="view-actions">
            <a href="/backend/projeto/listar" class="btn-action-back">
                <i class="bi bi-arrow-left"></i>
                Voltar para Lista
            </a>
            <div class="actions-right">
                <a href="/backend/projeto/editar/<?= $projeto['id_projeto'] ?>" class="btn-action-primary">
                    <i class="bi bi-pencil"></i>
                    Editar Projeto
                </a>
                <button onclick="confirmarExclusao(<?= $projeto['id_projeto'] ?>)" class="btn-action-danger">
                    <i class="bi bi-trash"></i>
                    Excluir
                </button>
            </div>
        </div>
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

    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-action-edit {
        background: var(--cor-acento);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-action-edit:hover {
        background: #0e6eb8;
        transform: translateY(-2px);
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
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-action-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Card de Visualização */
    .view-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .view-section {
        padding: 2rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .view-section:last-of-type {
        border-bottom: none;
    }

    .section-header {
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--cor-acento);
        font-size: 1.25rem;
    }

    /* Comparador de Imagens */
    .before-after-viewer {
        margin-bottom: 2rem;
    }

    .before-after-slider-large {
        position: relative;
        width: 100%;
        height: 500px;
        overflow: hidden;
        border-radius: 12px;
        cursor: ew-resize;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .image-before,
    .image-after {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
    }

    .image-after {
        clip-path: inset(0 50% 0 0);
    }

    .slider-handle {
        position: absolute;
        top: 0;
        left: 50%;
        width: 4px;
        height: 100%;
        transform: translateX(-50%);
        background: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 5;
    }

    .slider-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 56px;
        height: 56px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        font-size: 1.5rem;
        color: var(--cor-acento);
    }

    .slider-button i:first-child {
        margin-right: -6px;
    }

    .labels {
        position: absolute;
        top: 1.5rem;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 1.5rem;
        z-index: 6;
        pointer-events: none;
    }

    .label-before,
    .label-after {
        background: rgba(0, 0, 0, 0.75);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    /* Miniaturas */
    .thumbnails-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .thumbnail-card {
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        transition: all 0.2s;
    }

    .thumbnail-card:hover {
        border-color: var(--cor-acento);
        transform: translateY(-2px);
    }

    .thumbnail-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        display: block;
    }

    .thumbnail-label {
        display: block;
        padding: 0.75rem;
        background: #f8fafc;
        text-align: center;
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
    }

    /* Grid de Informações */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .info-label i {
        color: var(--cor-acento);
        font-size: 1rem;
    }

    .info-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1e293b;
    }

    /* Box de Descrição */
    .description-box {
        background: #f8fafc;
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
    }

    .description-box p {
        font-size: 1rem;
        line-height: 1.75;
        color: #334155;
        margin: 0;
    }

    /* Ações da View */
    .view-actions {
        padding: 1.5rem 2rem;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .actions-right {
        display: flex;
        gap: 0.75rem;
    }

    .btn-action-back {
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

    .btn-action-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-action-primary {
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
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(20, 135, 223, 0.3);
    }

    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 135, 223, 0.4);
    }

    .btn-action-danger {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 10px;
        background: var(--cor-danger);
        color: white;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-action-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .before-after-slider-large {
            height: 350px;
        }

        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .btn-action-edit,
        .btn-action-secondary {
            flex: 1;
            justify-content: center;
        }

        .thumbnails-grid {
            grid-template-columns: 1fr;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .view-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .actions-right {
            width: 100%;
            flex-direction: column;
        }

        .btn-action-back,
        .btn-action-primary,
        .btn-action-danger {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
// Comparador Before/After
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('mainSlider');
    let isDragging = false;
    const afterImage = slider.querySelector('.image-after');
    const handle = slider.querySelector('.slider-handle');
    
    function updateSlider(x) {
        const rect = slider.getBoundingClientRect();
        const position = Math.max(0, Math.min(x - rect.left, rect.width));
        const percentage = (position / rect.width) * 100;
        
        afterImage.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
        handle.style.left = `${percentage}%`;
    }
    
    slider.addEventListener('mousedown', (e) => {
        isDragging = true;
        updateSlider(e.clientX);
    });
    
    document.addEventListener('mousemove', (e) => {
        if (isDragging) {
            updateSlider(e.clientX);
        }
    });
    
    document.addEventListener('mouseup', () => {
        isDragging = false;
    });
    
    // Touch support
    slider.addEventListener('touchstart', (e) => {
        isDragging = true;
        updateSlider(e.touches[0].clientX);
    });
    
    document.addEventListener('touchmove', (e) => {
        if (isDragging) {
            updateSlider(e.touches[0].clientX);
        }
    });
    
    document.addEventListener('touchend', () => {
        isDragging = false;
    });
});

// Confirmação de Exclusão
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este projeto?\n\nEsta ação não pode ser desfeita.')) {
        window.location.href = `/backend/projeto/excluir/${id}`;
    }
}
</script>
<?php endif; ?>
        exit;