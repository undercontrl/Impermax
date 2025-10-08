<div>Sou o create</div>
<?php $clientes = $usuarios;?>
<div>
    <label for="nome_cliente">Nome do Cliente:</label>
    <input type="text" id="nome_cliente" name="nome_cliente" list="clientes" required>
    <datalist id="clientes">
        <?php foreach ($clientes as $cliente): ?>
            <option value="<?= htmlspecialchars($cliente['nome_usuario']) ?>" data-id="<?= $cliente['id_cliente'] ?>"></option>
        <?php endforeach; ?>
    </datalist>
</div>
<script>
    document.getElementById('nome_cliente').addEventListener('change', function () {
        const selectedOption = Array.from(document.querySelectorAll('#clientes option')).find(option => option.value === this.value);
        if (selectedOption) {
            document.getElementById('id_cliente').value = selectedOption.getAttribute('data-id');
        } else {
            document.getElementById('id_cliente').value = '';
        }
    });
</script>
<form action="/backend/avaliacao/salvar" method="post">
    <label for="id_cliente">ID Cliente</label>
    <input type="number" name="id_cliente" id="id_cliente" required>
    <br>
    <label for="descricao_avaliacao">Descrição</label>
    <textarea name="descricao_avaliacao" id="descricao_avaliacao" required></textarea>
    <br>
    <label for="nota_avaliacao">Nota</label>
    <input type="number" name="nota_avaliacao" id="nota_avaliacao" min="0" max="5" step="0.1" required>
    <br>
    <label for="status_avaliacao">Status</label>
    <select name="status_avaliacao" id="status_avaliacao" required>
        <option value="publicada">Publicada</option>
        <option value="pendente">Pendente</option>
        <option value="oculta">Oculta</option>
    </select>
    <br>
    <button type="submit">Salvar Avaliação</button>
</form>