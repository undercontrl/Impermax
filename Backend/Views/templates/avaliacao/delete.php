<div class="container mt-5 text-center">
    <h3 class="mb-4 text-danger">Excluir Avaliação</h3>
    <p>Tem certeza que deseja excluir esta avaliação?</p>

    <form action="/backend/avaliacao/deletar/<?= htmlspecialchars($id_avaliacao) ?>" method="post">
        <input type="hidden" name="id_avaliacao" value="<?= htmlspecialchars($id_avaliacao) ?>">
        <button type="submit" class="btn btn-danger">Sim, excluir</button>
        <a href="/backend/avaliacao/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
