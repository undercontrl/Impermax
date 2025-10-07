<div>Sou o create</div>
<?php $clientes = $usuarios;?>

<div>
    <label for="nome_cliente">Nome do Cliente:</label>
    <input type="text" id="nome_cliente" name="nome_cliente" list="clientes" required>
    <datalist id="clientes">
        <?php foreach ($clientes as $cliente): ?>
            <option value="<?= htmlspecialchars($cliente['nome_usuario']) ?>" data-id="<?= $cliente['id_usuario'] ?>"></option>
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
<form action="/backend/agendamento/salvar" method="POST">
        <script>
        document.getElementById('id_agendamento').value = <?= $id_agendamento ?>;
    </script>
    <div>
        <label for="id_cliente">Cliente:</label>
        <input type="number" id="id_cliente" name="id_cliente" required>
    </div>
    <div>
        <label for="data_solicitada">Data Solicitada:</label>
        <input type="date" id="data_solicitada" name="data_solicitada" required>
    </div>
    <div>
        <label for="total_agendamento">Total do Agendamento:</label>
        <input type="number" step="0.01" id="total_agendamento" name="total_agendamento" required>
    </div>
    <div>
        <label for="status_agendamento">Status do Agendamento:</label>
        <select id="status_agendamento" name="status_agendamento" required>
            <option value="pendente">Pendente</option>
            <option value="agendada">Agendada</option>
            <option value="cancelada">Cancelada</option>
            <option value="realizada">Realizada</option>
        </select>
    </div>
    <button type="submit">Salvar</button>
</form>
