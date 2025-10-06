<div>Sou o create</div>
<form action="/backend/pagamento/salvar" method="post">
<label for="Cliente">Cliente</label>
<input type="text" name="id_cliente" id="id_cliente" require>
<br>
<label for="total">Total</label>
<input type="decimal" name="total_devedor" id="total_devedor" require>
<br>
<label for="forma_pagamento">Forma de Pagamento</label>
<select name="id_cliente" id="id_cliente" required>
    <option value="">Selecione o Cliente</option>
    <?php foreach ($clientes as $cliente): ?>
        <option value="<?= htmlspecialchars($cliente['id']) ?>">
            <?= htmlspecialchars($cliente['nome_usuario']) ?>
        </option>
    <?php endforeach; ?>
</select>
<br>
<label for="total_devedor">Total da Dívida</label>
<input type="number" step="0.01" name="total_devedor" id="total_devedor" required>
<br>
<label for="forma_pagamento">Forma de Pagamento</label>
<select name="forma_pagamento" id="forma_pagamento" required>
    <option value="">Selecione</option>
    <option value="dinheiro">Dinheiro</option>
    <option value="debito">Débito</option>
    <option value="credito">Crédito</option>
    <option value="pix">Pix</option>
</select>
<br>
<label for="valor_pago">Valor Pago</label>
<input type="number" step="0.01" name="valor_pago" id="valor_pago" required>
<br>
<label for="status_pagamento">Status do Pagamento</label>
<select name="status_pagamento" id="status_pagamento" required>
    <option value="">Selecione</option>
    <option value="pago">Pago</option>
    <option value="cancelado">Cancelado</option>
    <option value="aberto">Aberto</option>
</select>
<br>
<button type="submit">Salvar</button>
</form>
