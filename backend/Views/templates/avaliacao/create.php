<h3>Cadastrar Avaliação</h3>

<form action="/backend/avaliacao/salvar" method="POST">
    <label for="id_cliente">Cliente:</label>
    <select name="id_cliente" id="id_cliente" required>
        <option value="">Selecione um cliente</option>
        <?php foreach ($usuarios as $usuario): ?>
            <option value="<?= $usuario['id_usuario']; ?>"><?= htmlspecialchars($usuario['nome_usuario']); ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for="descricao_avaliacao">Descrição:</label>
    <textarea name="descricao_avaliacao" id="descricao_avaliacao" required></textarea>
    <br>

    <label for="nota_avaliacao">Nota:</label>
    <input type="number" name="nota_avaliacao" id="nota_avaliacao" step="0.1" min="0" max="10" required>
    <br>

    <label for="status_avaliacao">Status:</label>
    <select name="status_avaliacao" id="status_avaliacao" required>
        <option value="pendente">Pendente</option>
        <option value="ativa">Ativa</option>
        <option value="inativa">Inativa</option>
    </select>
    <br>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
