<h3>Excluir Avaliação</h3>

<p>Tem certeza que deseja excluir esta avaliação?</p>

<form action="/backend/avaliacao/deletar/<?= $id_avaliacao; ?>" method="POST">
    <input type="hidden" name="id_avaliacao" value="<?= $id_avaliacao; ?>">
    <button type="submit" class="btn btn-danger">Excluir</button>
    <a href="/backend/avaliacao/listar" class="btn btn-secondary">Cancelar</a>
</form>
