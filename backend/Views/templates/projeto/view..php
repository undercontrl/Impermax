<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/projeto/listar">Projetos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detalhes #<?= htmlspecialchars($projeto['id_projeto']) ?></li>
        </ol>
    </nav>

    <!-- Header com Ações -->
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
                <button onclick="confirmarExclusao(<?= $projeto['id_projeto'] ?>)" class="btn-action-delete">
                    <i class="bi bi-trash"></i>
                    Excluir
                </button>
            </div>
        </div>
    </div>

    <!-- Comparador Before/After Grande -->
    <div class="comparador-destaque">
        <div class="before-after-slider" id="mainSlider">
            <div class="image-before" style="background-image: url('<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>');"></div>
            <div class="image-after" style="background-image: url('<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>');"></div>
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

    <!-- Grid de Informações -->
    <div class="info-grid">
        <!-- Card Descrição -->
        <div class="info-card card-descricao">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-file-text"></i>
                    Descrição do Projeto
                </h3>
            </div>
            <div class="card-body">
                <p class="description-text"><?= nl2br(htmlspecialchars($projeto['descricao_projeto'])) ?></p>
            </div>
        </div>

        <!-- Card Informações -->
        <div class="info-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-info-circle"></i>
                    Informações
                </h3>
            </div>
            <div class="card-body">
                <div class="detail-item">
                    <span class="detail-label">
                        <i class="bi bi-hash"></i>
                        ID do Projeto
                    </span>
                    <span class="detail-value">#<?= htmlspecialchars($projeto['id_projeto']) ?></span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">
                        <i class="bi bi-calendar-plus"></i>
                        Data de Criação
                    </span>
                    <span class="detail-value"><?= date('d/m/Y às H:i', strtotime($projeto['criado_em'])) ?></span>
                </div>

                <?php if (isset($projeto['atualizado_em']) && $projeto['atualizado_em']): ?>
                <div class="detail-item">
                    <span class="detail-label">
                        <i class="bi bi-pencil"></i>
                        Última Atualização
                    </span>
                    <span class="detail-value"><?= date('d/m/Y às H:i', strtotime($projeto['atualizado_em'])) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Card Ações Rápidas -->
        <div class="info-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-lightning-charge"></i>
                    Ações Rápidas
                </h3>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="/backend/projeto/editar/<?= $projeto['id_projeto'] ?>" class="quick-action-btn btn-edit">
                        <i class="bi bi-pencil-square"></i>
                        <span>Editar Projeto</span>
                    </a>
                    <button onclick="baixarImagens()" class="quick-action-btn btn-download">
                        <i class="bi bi-download"></i>
                        <span>Baixar Fotos</span>
                    </button>
                    <button onclick="compartilhar()" class="quick-action-btn btn-share">
                        <i class="bi bi-share"></i>
                        <span>Compartilhar</span>
                    </button>
                    <button onclick="imprimirProjeto()" class="quick-action-btn btn-print">
                        <i class="bi bi-printer"></i>
                        <span>Imprimir</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Card Timeline -->
        <div class="info-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-clock-history"></i>
                    Linha do Tempo
                </h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon timeline-success">
                            <i class="bi bi-plus-circle-fill"></i>
                        </div>
                        <div class="timeline-content">
                            <h5 class="timeline-title">Projeto Criado</h5>
                            <p class="timeline-date">
                                <?= date('d/m/Y às H:i', strtotime($projeto['criado_em'])) ?>
                            </p>
                        </div>
                    </div>
                    
                    <?php if (isset($projeto['atualizado_em']) && $projeto['atualizado_em']): ?>
                    <div class="timeline-item">
                        <div class="timeline-icon timeline-info">
                            <i class="bi bi-pencil-fill"></i>
                        </div>
                        <div class="timeline-content">
                            <h5 class="timeline-title">Última Modificação</h5>
                            <p class="timeline-date">
                                <?= date('d/m/Y às H:i', strtotime($projeto['atualizado_em'])) ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="page-actions">
        <a href="/backend/projeto/listar" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Voltar para Lista
        </a>
        <div class="action-group">
            <a href="/backend/projeto/editar/<?= $projeto['id_projeto'] ?>" class="btn-primary">
                <i class="bi bi-pencil"></i>
                Editar Projeto
            </a>
        </div>
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
        max-width: 1200px;
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

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
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

    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-action-edit,
    .btn-action-delete {
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
    }

    .btn-action-edit {
        background: var(--cor-acento);
        color: white;
    }

    .btn-action-edit:hover {
        background: #0e6eb8;
        transform: translateY(-1px);
    }

    .btn-action-delete {
        background: white;
        color: var(--cor-danger);
        border: 1px solid #fee2e2;
    }

    .btn-action-delete:hover {
        background: #fee2e2;
        border-color: var(--cor-danger);
    }

    /* Comparador Destaque */
    .comparador-destaque {
        position: relative;
        width: 100%;
        height: 500px;
        margin-bottom: 2rem;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .before-after-slider {
        position: relative;
        width: 100%;
        height: 100%;
        cursor: ew-resize;
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
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
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
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    /* Grid de Informações */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .card-descricao {
        grid-column: 1 / -1;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: var(--cor-acento);
    }

    .card-body {
        padding: 1.5rem;
    }

    .description-text {
        font-size: 1rem;
        color: #334155;
        line-height: 1.7;
        margin: 0;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-value {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #1e293b;
    }

    /* Ações Rápidas */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .quick-action-btn {
        padding: 1rem;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .quick-action-btn i {
        font-size: 1.5rem;
    }

    .quick-action-btn span {
        font-size: 0.8125rem;
        font-weight: 600;
    }

    .btn-edit {
        color: var(--cor-acento);
        border-color: #e0f2fe;
    }

    .btn-edit:hover {
        background: #e0f2fe;
        transform: translateY(-2px);
    }

    .btn-download {
        color: var(--cor-success);
        border-color: #dcfce7;
    }

    .btn-download:hover {
        background: #dcfce7;
        transform: translateY(-2px);
    }

    .btn-share {
        color: #8b5cf6;
        border-color: #ede9fe;
    }

    .btn-share:hover {
        background: #ede9fe;
        transform: translateY(-2px);
    }

    .btn-print {
        color: #64748b;
        border-color: #f1f5f9;
    }

    .btn-print:hover {
        background: #f8fafc;
        transform: translateY(-2px);
    }

    /* Timeline */
    .timeline {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .timeline-item {
        display: flex;
        gap: 1rem;
    }

    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .timeline-success {
        background: #dcfce7;
        color: #166534;
    }

    .timeline-info {
        background: #dbeafe;
        color: #1e40af;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
    }

    .timeline-date {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
    }

    /* Page Actions */
    .page-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 2rem 0;
    }

    .btn-back,
    .btn-primary {
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

    .btn-back {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
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

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .comparador-destaque {
            height: 400px;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }

        .page-header-content {
            flex-direction: column;
        }

        .header-actions {
            width: 100%;
        }

        .btn-action-edit,
        .btn-action-delete {
            flex: 1;
            justify-content: center;
        }

        .page-actions {
            flex-direction: column;
        }

        .btn-back,
        .btn-primary {
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

function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este projeto?\n\nEsta ação não pode ser desfeita.')) {
        window.location.href = `/backend/projeto/excluir/${id}`;
    }
}

function baixarImagens() {
    alert('Função de download em desenvolvimento!');
}

function compartilhar() {
    if (navigator.share) {
        navigator.share({
            title: 'Projeto',
            text: 'Confira este projeto incrível!',
            url: window.location.href
        });
    } else {
        alert('Compartilhamento não suportado neste navegador');
    }
}

function imprimirProjeto() {
    window.print();
}
</script>