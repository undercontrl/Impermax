<div class="container mt-4">
    <h2 class="mb-4">Novo Item de Agendamento</h2>

    <form action="/backend/item_agendamento/salvar" method="POST">

        <!-- Agendamento -->
        <div class="mb-3">
            <label for="id_agendamento" class="form-label">Agendamento:</label>
            <select id="id_agendamento" name="id_agendamento" class="form-select" required>
                <option value="">Selecione um agendamento</option>
                <?php foreach ($agendamentos as $ag): ?>
                    <option value="<?= htmlspecialchars($ag['id_agendamento']) ?>">
                        <?= htmlspecialchars("Agendamento #" . $ag['id_agendamento'] . " - Cliente: " . $ag['id_cliente']) ?>
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
                    <option value="<?= htmlspecialchars($servico['id_servico']) ?>"
                            data-valor="<?= htmlspecialchars($servico['valor_servico']) ?>">
                        <?= htmlspecialchars($servico['nome_servico']) ?> - R$ <?= number_format($servico['valor_servico'], 2, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Valor do Serviço -->
        <div class="mb-3">
            <label for="valor_servico" class="form-label">Valor do Serviço (R$):</label>
            <input type="number" step="0.01" class="form-control" id="valor_servico" name="valor_servico" required readonly>
        </div>

        <!-- Quantidade -->
        <div class="mb-3">
            <label for="qtde_solicitada" class="form-label">Quantidade Solicitada:</label>
            <input type="number" class="form-control" id="qtde_solicitada" name="qtde_solicitada" required min="1" value="1">
        </div>

        <!-- Total -->
        <div class="mb-3">
            <label for="total_item" class="form-label">Total (R$):</label>
            <input type="number" step="0.01" class="form-control" id="total_item" name="total_item" required readonly>
        </div>

        <!-- Responsável -->
        <div class="mb-3">
            <label for="id_responsavel" class="form-label">Responsável:</label>
            <select id="id_responsavel" name="id_responsavel" class="form-select" required>
                <option value="">Selecione o responsável</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= htmlspecialchars($usuario['id_usuario']) ?>">
                        <?= htmlspecialchars($usuario['nome_usuario']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="/backend/item_agendamento/listar" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>

<!-- Script de cálculo automático -->
<script>
    const servicoSelect = document.getElementById('id_servico');
    const valorServicoInput = document.getElementById('valor_servico');
    const qtdeInput = document.getElementById('qtde_solicitada');
    const totalInput = document.getElementById('total_item');

    function atualizarTotal() {
        const valor = parseFloat(valorServicoInput.value) || 0;
        const qtd = parseFloat(qtdeInput.value) || 0;
        totalInput.value = (valor * qtd).toFixed(2);
    }

    servicoSelect.addEventListener('change', function() {
        const valor = this.selectedOptions[0].getAttribute('data-valor');
        valorServicoInput.value = valor;
        atualizarTotal();
    });

    qtdeInput.addEventListener('input', atualizarTotal);
</script>
