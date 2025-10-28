<?php 
$servico = $servico ?? null;
if (!$servico) {
    echo "<p class='text-danger'>Serviço não encontrado.</p>";
    return;
}
$isAtivo = strcasecmp($servico['status_servico'], 'Ativo') === 0;
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Editar Serviço: <?= htmlspecialchars($servico['nome_servico']) ?></h4>
                    <span class="badge <?= $isAtivo ? 'bg-success' : 'bg-danger' ?>">
                        <?= $isAtivo ? 'Ativo' : 'Inativo' ?>
                    </span>
                </div>
                <div class="card-body">
                    <form action="/backend/servico-site/atualizar/<?= $servico['id_servico'] ?>" method="POST" enctype="multipart/form-data">
                        <!-- NOME -->
                        <div class="mb-3">
                            <label for="nome_servico" class="form-label">Nome do Serviço *</label>
                            <input type="text" 
                                   name="nome_servico" 
                                   id="nome_servico" 
                                   class="form-control" 
                                   value="<?= htmlspecialchars($servico['nome_servico']) ?>" 
                                   required 
                                   minlength="3" 
                                   maxlength="255">
                        </div>

                        <!-- DESCRIÇÃO -->
                        <div class="mb-3">
                            <label for="descricao_servico" class="form-label">Descrição *</label>
                            <textarea name="descricao_servico" 
                                      id="descricao_servico" 
                                      class="form-control" 
                                      rows="5" 
                                      required 
                                      minlength="10" 
                                      maxlength="1000"><?= htmlspecialchars($servico['descricao_servico']) ?></textarea>
                        </div>

                        <!-- FOTO ATUAL + NOVO UPLOAD -->
                        <div class="mb-3">
                            <label class="form-label">Foto Atual</label>
                            <div class="mb-2">
                                <?php if ($servico['foto_servico']): ?>
                                    <img src="/backend/upload/<?= htmlspecialchars($servico['foto_servico']) ?>" 
                                         alt="Foto atual" 
                                         class="img-thumbnail" 
                                         style="max-height: 200px;">
                                    <input type="hidden" name="foto_servico_atual" value="<?= htmlspecialchars($servico['foto_servico']) ?>">
                                <?php else: ?>
                                    <p class="text-muted">Nenhuma foto cadastrada.</p>
                                <?php endif; ?>
                            </div>

                            <label for="foto_servico" class="form-label">Nova Foto (deixe em branco para manter)</label>
                            <input type="file" 
                                   name="foto_servico" 
                                   id="foto_servico" 
                                   class="form-control" 
                                   accept="image/jpeg,image/png,image/webp">
                            <div class="form-text">
                                JPG, PNG ou WEBP - máx 5MB
                            </div>
                        </div>

                        <!-- STATUS -->
                        <div class="mb-3">
                            <label for="status_servico" class="form-label">Status no Site</label>
                            <select name="status_servico" id="status_servico" class="form-select">
                                <option value="Ativo" <?= $isAtivo ? 'selected' : '' ?>>Ativo</option>
                                <option value="Inativo" <?= !$isAtivo ? 'selected' : '' ?>>Inativo</option>
                            </select>
                        </div>

                        <!-- BOTÕES -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Atualizar
                            </button>
                            <a href="/backend/servico-site/listar" class="btn btn-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            
        </div>
    </div>
</div>

<!-- JS: Preview da nova foto -->
<script>
document.getElementById('foto_servico').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.getElementById('nova-foto-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'nova-foto-preview';
                preview.className = 'img-thumbnail mt-2';
                preview.style.maxHeight = '200px';
                e.target.parentElement.appendChild(preview);
            }
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>