<div>Sou o create</div>
<form action="/backend/pagamento/salvar" method="post">

<div>
    <label for="id_cliente">Selecione o Cliente</label>
    <select name="id_cliente" id="id_cliente" required>
        <option value="">Selecione...</option>
        <?php foreach ($usuarios as $cliente): ?>
            <option value="<?= htmlspecialchars($cliente['id_usuario']) ?>">
                <?= htmlspecialchars($cliente['nome_usuario']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<label for="total_devedor">Total da Dívida</label>
<input type="number" step="0.01" name="total_devedor" id="total_devedor" required>
<br>
<label for="forma_pagamento">Forma de Pagamento</label>
<select name="forma_pagamento" id="forma_pagamento" required>
    <option value="">Selecione</option>
    <option value="dinheiro" name="dinheiro" id="dinheiro">Dinheiro</option>
    <option value="debito"  name="debito" id="debito">Débito</option>
    <option value="credito"  name="credito" id="credito">Crédito</option>
    <option value="pix"  name="pix" id="pix">Pix</option>
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
    <label for="data_pagamento">Data Do Pagamento:</label>
    <input type="date" id="data_pagamento" name="data_pagamento" required>
<br>
<button type="submit">Salvar</button>
</form>


<p style="color:gray; font-size:small;">
    O valor pago será registrado na coluna correspondente à forma de pagamento escolhida. As demais formas receberão 0,00 automaticamente.
</p>