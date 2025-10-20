<h2>Editar Projeto</h2>
<form action="/backend/projeto/atualizar/<?php echo htmlspecialchars($projeto['id_projeto']); ?>" 
      method="post" 
      enctype="multipart/form-data">

    <!-- FOTO ANTES -->
    <label>Foto Antes (atual):</label><br>
    <img src="/backend/upload/<?php echo htmlspecialchars($projeto['foto_antes_projeto']); ?>" width="150"><br>
    <input type="hidden" name="foto_antes_atual" value="<?php echo htmlspecialchars($projeto['foto_antes_projeto']); ?>">
    <label>Nova Foto Antes:</label>
    <input type="file" name="foto_antes" accept="image/*">
    <br><br>

    <!-- FOTO DEPOIS -->
    <label>Foto Depois (atual):</label><br>
    <img src="/backend/upload/<?php echo htmlspecialchars($projeto['foto_depois_projeto']); ?>" width="150"><br>
    <input type="hidden" name="foto_depois_atual" value="<?php echo htmlspecialchars($projeto['foto_depois_projeto']); ?>">
    <label>Nova Foto Depois:</label>
    <input type="file" name="foto_depois" accept="image/*">
    <br><br>

    <!-- DESCRIÇÃO -->
    <label>Descrição:</label><br>
    <textarea name="descricao_projeto" rows="5" cols="50" required><?php echo htmlspecialchars($projeto['descricao_projeto']); ?></textarea>
    <br><br>

    <button type="submit">Salvar Alterações</button>
</form>