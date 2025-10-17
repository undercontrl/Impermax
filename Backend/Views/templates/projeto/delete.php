<h2>Excluir Projeto</h2>

<p>Tem certeza que deseja excluir o projeto <strong><?= htmlspecialchars($projeto['descricao_projeto']) ?></strong>?</p>

<form action="/backend/projeto/deletar" method="POST">
    <input type="hidden" name="id_projeto" value="<?= htmlspecialchars($projeto['id_projeto']) ?>">
    <button type="submit" class="btn btn-danger">Excluir</button>
    <a href="/backend/projeto/listar" class="btn btn-secondary">Cancelar</a>
</form>