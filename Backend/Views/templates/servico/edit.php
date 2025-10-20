<h2>Editar Serviço</h2>
<form action="/backend/servico/atualizar/<?php echo htmlspecialchars($servico['id_servico']); ?>" method="post" enctype="multipart/form-data">
    <label>Nome:</label>
    <input type="text" name="nome_servico" value="<?php echo htmlspecialchars($servico['nome_servico']); ?>" required>
    <br>

    <label>Descrição:</label>
    <input type="text" name="descricao_servico" value="<?php echo htmlspecialchars($servico['descricao_servico']); ?>" required>
    <br>

    <label>Valor Base:</label>
    <input type="number" step="0.01" name="valor_base_servico" value="<?php echo htmlspecialchars($servico['valor_base_servico']); ?>" required>
    <br>

    <label>Foto Atual:</label><br>
    <img src="/backend/upload/<?php echo htmlspecialchars($servico['foto_servico']); ?>" width="150"><br>
    <input type="hidden" name="foto_servico_atual" value="<?php echo htmlspecialchars($servico['foto_servico']); ?>">
    <label>Nova Foto:</label>
    <input type="file" name="foto_servico" accept="image/*">
    <br>

    <label>Status:</label>
    <select name="status_servico">
        <option value="ativo" <?php echo ($servico['status_servico'] === 'ativo') ? 'selected' : ''; ?>>Ativo</option>
        <option value="inativo" <?php echo ($servico['status_servico'] === 'inativo') ? 'selected' : ''; ?>>Inativo</option>
    </select>
    <br>

    <button type="submit">Salvar Alterações</button>
</form>