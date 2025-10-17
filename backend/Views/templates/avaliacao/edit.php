<h3>Editar Avaliação</h3>

<form action="/backend/avaliacao/atualizar/<?= $avaliacao['id_avaliacao']; ?>" method="POST">
    <!-- ID oculto -->
    <input type="hidden" name="id_avaliacao" value="<?= $avaliacao['id_avaliacao']; ?>">
    <input type="hidden" name="id_cliente" value="<?= $avaliacao['id_cliente']; ?>">

    <!-- Exibição do cliente -->
    <label for="nome_cliente">Cliente:</label>
    <input type="text" id="nome_cliente" value="<?= htmlspecialchars($avaliacao['nome_usuario']); ?>" disabled>
    <br>

    <!-- Descrição -->
    <label for="descricao_avaliacao">Descrição:</label>
    <textarea name="descricao_avaliacao" id="descricao_avaliacao" required><?= htmlspecialchars($avaliacao['descricao_avaliacao']); ?></textarea>
    <br>

    <!-- Nota -->
    <label for="nota_avaliacao">Nota:</label>
    <input type="number"
           name="nota_avaliacao"
           id="nota_avaliacao"
           value="<?= htmlspecialchars($avaliacao['nota_avaliacao']); ?>"
           step="0.1"
           min="0"
           max="10"
           required>
    <br>

    <!-- Status -->
    <label for="status_avaliacao">Status:</label>
    <select name="status_avaliacao" id="status_avaliacao" required>
        <option value="pendente" <?= $avaliacao['status_avaliacao'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
        <option value="ativa" <?= $avaliacao['status_avaliacao'] == 'ativa' ? 'selected' : ''; ?>>Ativa</option>
        <option value="inativa" <?= $avaliacao['status_avaliacao'] == 'inativa' ? 'selected' : ''; ?>>Inativa</option>
    </select>
    <br>

    <button type="submit" class="btn btn-primary">Atualizar</button>
    <a href="/backend/avaliacao/listar" class="btn btn-secondary">Cancelar</a>
</form>
