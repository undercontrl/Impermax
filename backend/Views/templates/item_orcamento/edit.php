<div class="container mt-4">
    <h2>Editar Item de Orçamento</h2>

    <form action="/backend/item_orcamento/atualizar/<?= htmlspecialchars($item_orcamento['id_item_orcamento']) ?>" method="POST">

        <!-- Orçamento -->
        <div class="mb-3">
            <label for="id_orcamento" class="form-label">Orçamento:</label>
            <select id="id_orcamento" name="id_orcamento" class="form-select" required>
                <?php foreach ($orcamentos as $orc): ?>
                    <option value="<?= htmlspecialchars($orc['id_orcamento']) ?>"
                        <?= $orc['id_orcamento'] == $item_orcamento['id_orcamento'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars("Orçamento #" . $orc['id_orcamento'] . " - Cliente: " . $orc['nome_cliente']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Serviço -->
        <div class="mb-3">
            <label for="id_servico" class="form-label">Serviço:</label>
            <select id="id_servico" name="id_servico" class="form-select" required>
                <?php foreach ($servicos as $servico): ?>
                    <option value="<?= htmlspecialchars($servico['id_servico']) ?>"
                        <?= $servico['id_servico'] == $item_orcamento['id_servico'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($servico['nome_servico']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Descrição -->
        <div class="mb-3">
            <label for="descricao_item_orcamento" class="form-label">Descrição:</label>
            <textarea id="descricao_item_orcamento" name="descricao_item_orcamento" class="form-control" required><?= htmlspecialchars($item_orcamento['descricao_item_orcamento']) ?></textarea>
        </div>

        <!-- Metragem -->
        <div class="mb-3">
            <label for="metragem" class="form-label">Metragem:</label>
            <input type="number" step="0.01" id="metragem" name="metragem"
                   class="form-control" value="<?= htmlspecialchars($item_orcamento['metragem']) ?>" required>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status_item_orcamento" class="form-label">Status:</label>
            <select id="status_item_orcamento" name="status_item_orcamento" class="form-select" required>
                <option value="pendente" <?= $item_orcamento['status_item_orcamento'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                <option value="em_andamento" <?= $item_orcamento['status_item_orcamento'] == 'em andamento' ? 'selected' : '' ?>>Em andamento</option>
                <option value="finalizado" <?= $item_orcamento['status_item_orcamento'] == 'finalizado' ? 'selected' : '' ?>>Finalizado</option>
                <option value="finalizado" <?= $item_orcamento['status_item_orcamento'] == 'ativo' ? 'selected' : '' ?>>Ativo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="/backend/item_orcamento/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
