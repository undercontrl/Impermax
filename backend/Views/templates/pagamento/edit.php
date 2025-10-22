<div class="container mt-4">
    <h2>Editar Pagamento</h2>
    <form action="/backend/pagamento/atualizar/<?= $pagamento['id_pagamento'] ?>" method="post">
        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select name="id_cliente" class="form-select" required>
                <?php foreach ($usuarios as $cliente): ?>
                <option value="<?= $cliente['id_usuario'] ?>" 
                    <?= $pagamento['id_cliente'] == $cliente['id_usuario'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cliente['nome_usuario']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Total da Dívida (R$)</label>
            <input type="number" step="0.01" class="form-control" name="total_devedor" 
                   value="<?= htmlspecialchars($pagamento['total_devedor']) ?>" id="total_devedor" required>
        </div>

        <!-- FORMAS DE PAGAMENTO -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Dinheiro (R$)</label>
                <input type="number" step="0.01" class="form-control" name="dinheiro" 
                       value="<?= htmlspecialchars($pagamento['dinheiro']) ?>" id="dinheiro">
            </div>
            <div class="col-md-3">
                <label class="form-label">Débito (R$)</label>
                <input type="number" step="0.01" class="form-control" name="debito" 
                       value="<?= htmlspecialchars($pagamento['debito']) ?>" id="debito">
            </div>
            <div class="col-md-3">
                <label class="form-label">Crédito (R$)</label>
                <input type="number" step="0.01" class="form-control" name="credito" 
                       value="<?= htmlspecialchars($pagamento['credito']) ?>" id="credito">
            </div>
            <div class="col-md-3">
                <label class="form-label">Pix (R$)</label>
                <input type="number" step="0.01" class="form-control" name="pix" 
                       value="<?= htmlspecialchars($pagamento['pix']) ?>" id="pix">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Data Pagamento</label>
            <input type="date" class="form-control" name="data_pagamento" 
                   value="<?= $pagamento['data_pagamento'] ?>" required>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Total Pago (R$)</label>
                <input type="text" class="form-control" id="total_pago" readonly 
                       value="<?= htmlspecialchars($pagamento['total_pago']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status_pagamento" class="form-select" id="status_auto" disabled>
                    <option value="aberto" <?= $pagamento['status_pagamento'] == 'aberto' ? 'selected' : '' ?>>Aberto</option>
                    <option value="pago" <?= $pagamento['status_pagamento'] == 'pago' ? 'selected' : '' ?>>Pago</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="/backend/pagamento/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
function calcularTotais() {
    const dinheiro = parseFloat(document.getElementById('dinheiro').value) || 0;
    const debito = parseFloat(document.getElementById('debito').value) || 0;
    const credito = parseFloat(document.getElementById('credito').value) || 0;
    const pix = parseFloat(document.getElementById('pix').value) || 0;
    
    const totalPago = dinheiro + debito + credito + pix;
    const totalDevedor = parseFloat(document.getElementById('total_devedor').value) || 0;
    
    document.getElementById('total_pago').value = totalPago.toFixed(2);
    document.getElementById('status_auto').value = totalPago >= totalDevedor ? 'pago' : 'aberto';
}

document.querySelectorAll('#dinheiro, #debito, #credito, #pix, #total_devedor').forEach(input => {
    input.addEventListener('input', calcularTotais);
});
</script>