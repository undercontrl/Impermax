<div class="container mt-4">
    <h2>Criar Item de Orçamento</h2>

    <form action="/backend/item_orcamento/salvar" method="POST">

        <!-- Orçamento -->
        <div class="mb-3">
            <label for="id_orcamento" class="form-label">Orçamento:</label>
            <select id="id_orcamento" name="id_orcamento" class="form-select" required>
                <option value="">Selecione um orçamento</option>
                <?php foreach ($orcamentos as $orc): ?>
                    <option value="<?= htmlspecialchars($orc['id_orcamento']) ?>">
                        <?= htmlspecialchars("Orçamento #" . $orc['id_orcamento'] . " - Cliente: " . $orc['nome_cliente']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Serviço -->
        <div class="mb-3">
            <label for="id_servico" class="form-label">Serviço:</label>
            <select id="id_servico" name="id_servico" class="form-select" required>
                <option value="">Selecione um serviço</option>
                <?php foreach ($servicos as $servico): ?>
                    <option value="<?= htmlspecialchars($servico['id_servico']) ?>">
                        <?= htmlspecialchars($servico['nome_servico']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Descrição -->
        <div class="mb-3">
            <label for="descricao_item_orcamento" class="form-label">Descrição do Item:</label>
            <textarea id="descricao_item_orcamento" name="descricao_item_orcamento" class="form-control" required></textarea>
        </div>

        <!-- Metragem -->
        <div class="mb-3">
            <label for="metragem" class="form-label">Metragem:</label>
            <input type="number" step="0.01" id="metragem" name="metragem" class="form-control" required>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status_item_orcamento" class="form-label">Status:</label>
            <select id="status_item_orcamento" name="status_item_orcamento" class="form-select" required>
                <option value="pendente">Pendente</option>
                <option value="em_andamento">Em andamento</option>
                <option value="finalizado">Finalizado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="/backend/item_orcamento/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
