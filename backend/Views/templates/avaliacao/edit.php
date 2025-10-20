<div class="container mt-4">
    <h2>Editar Avaliação</h2>
    <form action="/backend/avaliacao/atualizar/<?= htmlspecialchars($avaliacao['id_avaliacao']) ?>" method="post" class="mt-3">

        <input type="hidden" name="id_avaliacao" value="<?= htmlspecialchars($avaliacao['id_avaliacao']) ?>">

        <div class="mb-3">
            <label for="id_cliente" class="form-label">Cliente:</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($avaliacao['nome_usuario'] ?? '') ?>" disabled>
            <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($avaliacao['id_cliente']) ?>">
        </div>

        <div class="mb-3">
            <label for="descricao_avaliacao" class="form-label">Descrição:</label>
            <textarea id="descricao_avaliacao" name="descricao_avaliacao" class="form-control" rows="3" required><?= htmlspecialchars($avaliacao['descricao_avaliacao']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="nota_avaliacao" class="form-label">Nota:</label>
            <input type="number" id="nota_avaliacao" name="nota_avaliacao" class="form-control" step="0.1" min="0" max="10"
                   value="<?= htmlspecialchars($avaliacao['nota_avaliacao']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="status_avaliacao" class="form-label">Status:</label>
            <select id="status_avaliacao" name="status_avaliacao" class="form-select" required>
                <?php
                $status = ["pendente", "aprovado", "rejeitado"];
                foreach ($status as $st):
                ?>
                    <option value="<?= $st ?>" <?= ($st == $avaliacao['status_avaliacao']) ? 'selected' : '' ?>>
                        <?= ucfirst($st) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="/backend/avaliacao/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
