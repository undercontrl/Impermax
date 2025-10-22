<div class="container mt-4">
    <h2>Editar Agendamento</h2>
    <form action="/backend/agendamento/atualizar/<?= htmlspecialchars($agendamento['id_agendamento']) ?>" method="post" class="mt-3">

        <input type="hidden" name="id_agendamento" value="<?= htmlspecialchars($agendamento['id_agendamento']) ?>">

        <div class="mb-3">
            <label for="id_cliente" class="form-label">Cliente:</label>
            <select id="id_cliente" name="id_cliente" class="form-select" required>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= htmlspecialchars($usuario['id_usuario']) ?>"
                        <?= ($usuario['id_usuario'] == $agendamento['id_cliente']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($usuario['nome_usuario']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="data_solicitada" class="form-label">Data Solicitada:</label>
            <input type="date" id="data_solicitada" name="data_solicitada" class="form-control"
                   value="<?= htmlspecialchars($agendamento['data_solicitada']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="total_agendamento" class="form-label">Total (R$):</label>
            <input type="number" id="total_agendamento" name="total_agendamento" class="form-control" step="0.01"
                   value="<?= htmlspecialchars($agendamento['total_agendamento']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="status_agendamento" class="form-label">Status:</label>
            <select id="status_agendamento" name="status_agendamento" class="form-select" required>
                <?php
                    $status = ["pendente", "confirmado", "cancelado", "finalizado"];
                    foreach ($status as $st):
                ?>
                    <option value="<?= $st ?>" <?= ($st == $agendamento['status_agendamento']) ? 'selected' : '' ?>>
                        <?= ucfirst($st) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="/backend/agendamento/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
