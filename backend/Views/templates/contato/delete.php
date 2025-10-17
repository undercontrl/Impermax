<h3>Excluir Contato</h3>

<p>Tem certeza que deseja excluir este contato?</p>

<form action="/backend/contato/deletar/<?= $id_contato; ?>" method="POST">
    <input type="hidden" name="id_contato" value="<?= $id_contato; ?>">
    <button type="submit" class="btn btn-danger">Excluir</button>
    <a href="/backend/contato/listar" class="btn btn-secondary">Cancelar</a>
</form>
