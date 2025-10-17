<h2>Editar Projeto</h2>

<form action="/backend/projeto/atualizar" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_projeto" value="<?= htmlspecialchars($projeto['id_projeto']) ?>">

    <div>
        <label>Foto Antes:</label><br>
        <img src="/backend/upload/<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>" width="120">
        <input type="hidden" name="foto_antes_atual" value="<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>">
        <input type="file" name="foto_antes_projeto">
    </div>

    <div>
        <label>Foto Depois:</label><br>
        <img src="/backend/upload/<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>" width="120">
        <input type="hidden" name="foto_depois_atual" value="<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>">
        <input type="file" name="foto_depois_projeto">
    </div>

    <div>
        <label>Descrição:</label><br>
        <textarea name="descricao_projeto" rows="4" cols="50"><?= htmlspecialchars($projeto['descricao_projeto']) ?></textarea>
    </div>

    <button type="submit">Salvar Alterações</button>
</form>

<a href="/backend/projeto/listar">Voltar</a>
