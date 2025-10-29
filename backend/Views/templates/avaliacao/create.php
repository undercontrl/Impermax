<div class="container mt-4">
    <h2>Nova Avaliação</h2>
    <form action="/backend/avaliacao/salvar" method="post" class="mt-3">

        <div class="mb-3">
            <label for="id_cliente" class="form-label">Cliente:</label>
            <select id="id_cliente" name="id_cliente" class="form-select" required>
                <option value="">Selecione um cliente</option>
                <?php
                // Garante compatibilidade se a variável vier de outra página
                if (isset($avaliacao) && is_array($avaliacao)) {
                    foreach ($avaliacao as $cliente): ?>
                        <option value="<?= htmlspecialchars($cliente['id_usuario'] ?? '') ?>">
                            <?= htmlspecialchars($cliente['nome_usuario'] ?? '') ?>
                        </option>
                <?php endforeach; } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="descricao_avaliacao" class="form-label">Descrição:</label>
            <textarea id="descricao_avaliacao" name="descricao_avaliacao" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="nota_avaliacao" class="form-label">Nota:</label>
            <input type="number" id="nota_avaliacao" name="nota_avaliacao" class="form-control" step="0.1" min="0" max="10" required>
        </div>

        <div class="mb-3">
            <label for="status_avaliacao" class="form-label">Status:</label>
            <select id="status_avaliacao" name="status_avaliacao" class="form-select" required>
                <option value="pendente">Pendente</option>
                <option value="aprovado">Aprovado</option>
                <option value="rejeitado">Rejeitado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="/backend/avaliacao/listar" class="btn btn-secondary">Voltar</a>
    </form>
</div>
