<div class="container mt-4">
    <h2>Editar Item de Agendamento</h2>

    <form action="/backend/item_agendamento/atualizar/<?=
        htmlspecialchars($item_agendamento['id_item_agendamento'])
    ?>" method="POST">

        <!-- Agendamento -->
        <div class="mb-3">
            <label for="id_agendamento" class="form-label">Agendamento:</label>
            <select id="id_agendamento" name="id_agendamento" class="form-select" required>
                <option value="">Selecione um agendamento</option>
                <?php foreach ($agendamentos as $ag): ?>
                    <option value="<?= htmlspecialchars($ag['id_agendamento']) ?>"
                        <?= ($ag['id_agendamento'] == $item_agendamento['id_agendamento']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars("Agendamento #" . $ag['id_agendamento'] . " - Cliente: " . $ag['nome_cliente']) ?>
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
                    <option 
                        value="<?= htmlspecialchars($servico['id_servico']) ?>"
                        data-valor="<?= htmlspecialchars($servico['valor_base_servico']) ?>"
                        <?= ($servico['id_servico'] == $item_agendamento['id_servico']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($servico['nome_servico']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Valor do Serviço -->
        <div class="mb-3">
            <label for="valor_servico" class="form-label">Valor do Serviço (R$):</label>
            <input type="number" step="0.01" id="valor_servico" name="valor_servico"
                   class="form-control" value="<?= htmlspecialchars($item_agendamento['valor_servico']) ?>" required>
        </div>

        <!-- Quantidade Solicitada -->
        <div class="mb-3">
            <label for="qtde_solicitada" class="form-label">Quantidade Solicitada:</label>
            <input type="number" id="qtde_solicitada" name="qtde_solicitada"
                   class="form-control" min="1"
                   value="<?= htmlspecialchars($item_agendamento['qtde_solicitada']) ?>" required>
        </div>

        <!-- Total -->
        <div class="mb-3">
            <label for="total_item" class="form-label">Total (R$):</label>
            <input type="number" step="0.01" id="total_item" name="total_item"
                   class="form-control" value="<?= htmlspecialchars($item_agendamento['total_item']) ?>" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="/backend/item_agendamento/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
const servicoSelect = document.getElementById('id_servico');
const valorServicoInput = document.getElementById('valor_servico');
const qtdeInput = document.getElementById('qtde_solicitada');
const totalInput = document.getElementById('total_item');

// Atualiza o total em tempo real
function atualizarTotal() {
    const valor = parseFloat(valorServicoInput.value) || 0;
    const qtd = parseFloat(qtdeInput.value) || 0;
    totalInput.value = (valor * qtd).toFixed(2);
}

// Atualiza o valor do serviço ao selecionar um item
servicoSelect.addEventListener('change', function() {
    const valor = this.selectedOptions[0].getAttribute('data-valor');
    valorServicoInput.value = valor;
    atualizarTotal();
});

qtdeInput.addEventListener('input', atualizarTotal);
</script>
