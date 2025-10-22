<div class="container mt-4">
    <h2>Editar Material</h2>
    <form action="/backend/material/atualizar/<?= $material['id_material'] ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">Nome do Material</label>
            <input type="text" class="form-control" name="nome_material" 
                   value="<?= htmlspecialchars($material['nome_material']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantidade</label>
            <input type="number" class="form-control" name="qtd_material" 
                   value="<?= htmlspecialchars($material['qtd_material']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <input type="text" class="form-control" name="descricao_material" 
                   value="<?= htmlspecialchars($material['descricao_material']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Serviço</label>
            <select name="id_servico" class="form-select" required>
                <?php foreach ($servicos as $servico): ?>
                <option value="<?= $servico['id_servico'] ?>" 
                    <?= $material['id_servico'] == $servico['id_servico'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($servico['nome_servico']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="/backend/material/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>