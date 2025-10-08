<div>Sou o create</div>
<form action="/backend/orcamento/salvar" method="POST">
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
    <div>
        <label for="descricao_orcamento">Descricao:</label>
        <input type="text" id="descricao_orcamento" name="descricao_orcamento" required>
    </div>
    <div>
        <label for="status_orcamento">Status do orcamento:</label>
        <select id="status_orcamento" name="status_orcamento" required>
            <option value="pendente">Aprovado</option>
            <option value="agendada">Aguardando</option>
            <option value="cancelada">Recusado</option>
            <option value="realizada">Em Analise</option>
        </select>
    </div>
        <div>
        <label for="data_orcamento">Data Solicitada:</label>
        <input type="date" id="data_orcamento" name="data_orcamento" required>
    </div>
        <div>
        <label for="valor_orcamento">Valor do orcamento:</label>
        <input type="number" step="0.01" id="valor_orcamento" name="valor_orcamento" required>
    </div>
    <div>
        <label for="total_item_orcamento">Total do orcamento:</label>
        <input type="number" id="total_item_orcamento" name="total_item_orcamento" required>
    </div>
    <button type="submit">Salvar</button>
</form>


<!-- não ta puxando o id do cliente-->
