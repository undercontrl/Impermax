<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Confirmar Exclusão
                </h1>
                <p class="page-subtitle">Você está prestes a excluir uma avaliação</p>
            </div>
        </div>
    </div>

    <div class="delete-card">
        <div class="alert-danger">
            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="alert-content">
                <h3 class="alert-title">Atenção! Esta ação não pode ser desfeita.</h3>
                <p class="alert-message">
                    Ao confirmar, a avaliação #<?= htmlspecialchars($avaliacao['id_avaliacao']) ?> será excluída permanentemente.
                </p>
            </div>
        </div>

        <div class="delete-preview">
            <h4 class="preview-title">Avaliação que será excluída:</h4>
            
            <div class="preview-content">
                <div class="preview-info">
                    <div class="info-row">
                        <span class="info-label">ID:</span>
                        <span class="info-value">#<?= htmlspecialchars($avaliacao['id_avaliacao']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Cliente:</span>
                        <span class="info-value"><?= htmlspecialchars($avaliacao['nome_usuario']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nota:</span>
                        <span class="info-value">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star-fill <?= $i <= $avaliacao['nota_avaliacao'] ? 'star-active' : 'star-inactive' ?>"></i>
                            <?php endfor; ?>
                            (<?= $avaliacao['nota_avaliacao'] ?>/5)
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Avaliação:</span>
                        <span class="info-value"><?= htmlspecialchars($avaliacao['descricao_avaliacao']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <form action="/backend/avaliacao/deletar" method="POST" id="deleteForm">
            <input type="hidden" name="id_avaliacao" value="<?= htmlspecialchars($avaliacao['id_avaliacao']) ?>">
            
            <div class="confirmation-checkbox">
                <label class="checkbox-label">
                    <input type="checkbox" id="confirmDelete" required>
                    <span class="checkbox-text">
                        Confirmo que li o aviso e desejo excluir esta avaliação permanentemente
                    </span>
                </label>
            </div>

            <div class="delete-actions">
                <a href="/backend/avaliacao/listar" class="btn-cancel">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn-delete" id="btnDelete" disabled>
                    <i class="bi bi-trash-fill"></i>
                    Confirmar Exclusão
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* ... CSS igual ao delete.php de projeto ... */
    .star-active { color: #fbbf24; }
    .star-inactive { color: #e2e8f0; }
</style>

<script>
document.getElementById('confirmDelete').addEventListener('change', function() {
    const btnDelete = document.getElementById('btnDelete');
    btnDelete.disabled = !this.checked;
});

document.getElementById('deleteForm').addEventListener('submit', function(e) {
    if (!confirm('ÚLTIMA CONFIRMAÇÃO: Deseja realmente excluir esta avaliação?')) {
        e.preventDefault();
        return false;
    }
    
    const btnDelete = document.getElementById('btnDelete');
    btnDelete.innerHTML = '<i class="bi bi-hourglass-split"></i> Excluindo...';
    btnDelete.disabled = true;
});
</script>