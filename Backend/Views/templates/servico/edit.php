<div class="container mt-4">
    <h2>Editar Serviço</h2>
    <form action="/backend/servico/atualizar/<?php echo $servico['id_servico']; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="foto_servico_atual" value="<?php echo htmlspecialchars($servico['foto_servico']); ?>">
        
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome_servico" value="<?php echo htmlspecialchars($servico['nome_servico']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao_servico" required><?php echo htmlspecialchars($servico['descricao_servico']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Valor Base (R$)</label>
            <input type="number" step="0.01" class="form-control" name="valor_base_servico" value="<?php echo htmlspecialchars($servico['valor_base_servico']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Atual</label>
            <img src="/backend/upload/<?php echo htmlspecialchars($servico['foto_servico']); ?>" width="150" class="img-thumbnail mb-2">
            <input type="file" class="form-control" name="foto_servico" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status_servico" class="form-select" required>
                <option value="Ativo" <?php echo $servico['status_servico'] === 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
                <option value="Inativo" <?php echo $servico['status_servico'] === 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="/backend/servico/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>