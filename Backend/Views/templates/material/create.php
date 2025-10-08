<div>Sou o create</div>
<form action="/backend/material/salvar" method="post">
<label for="Nome">Nome</label>
<input type="text" name="nome_material" id="nome_material" require>
<br>
<label for="Quantidade">Quantidade de material</label>
<input type="number" name="qtd_material" id="qtd_material" require>
<br>
<label for="Descricao">Descrição</label>
<input type="text" name="descricao_material" id="descricao_material" require>
<br>
<?php
// Verifica se $servicos é um array de serviços
if (is_array($servicos) && !empty($servicos) && isset($servicos[0]['id_servico']) && isset($servicos[0]['nome_servico'])) {
    // $servicos está correto
} else {
    echo "<div style='color:red'>Erro: variável \$servicos não está formatada corretamente.</div>";
}
?>
<div>
    <label for="id_servico">Selecione o Serviço</label>
    <select name="id_servico" id="id_servico" required>
        <option value="">Selecione...</option>
        <?php foreach ($servicos as $servico): ?>
            <option value="<?= htmlspecialchars($servico['id_servico']) ?>">
                <?= htmlspecialchars($servico['nome_servico']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<button type="submit">Salvar</button>
</form>
