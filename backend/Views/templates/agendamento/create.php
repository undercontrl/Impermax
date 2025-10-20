<div class="container mt-4">
    <h2>Novo Agendamento</h2>
    <form action="/backend/agendamento/salvar" method="post" class="mt-3">
        
        <div class="mb-3">
            <label for="id_cliente" class="form-label">Cliente:</label>
            <select id="id_cliente" name="id_cliente" class="form-select" required>
                <option value="">Selecione um cliente</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= htmlspecialchars($usuario['id_usuario']) ?>">
                        <?= htmlspecialchars($usuario['nome_usuario']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="data_solicitada" class="form-label">Data Solicitada:</label>
            <input type="date" id="data_solicitada" name="data_solicitada" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="total_agendamento" class="form-label">Total (R$):</label>
            <input type="number" id="total_agendamento" name="total_agendamento" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="status_agendamento" class="form-label">Status:</label>
            <select id="status_agendamento" name="status_agendamento" class="form-select" required>
                <option value="pendente">Pendente</option>
                <option value="confirmado">Confirmado</option>
                <option value="cancelado">Cancelado</option>
                <option value="finalizado">Finalizado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="/backend/agendamento/listar" class="btn btn-secondary">Voltar</a>
    </form>
</div>
