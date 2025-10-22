<div class="container mt-5 text-center">
    <h3 class="mb-4 text-danger">Excluir Contato</h3>
    <p>Tem certeza que deseja excluir este contato?</p>

    <form action="/backend/contato/deletar/<?= htmlspecialchars($id_contato) ?>" method="post">
        <input type="hidden" name="id_contato" value="<?= htmlspecialchars($id_contato) ?>">
        <button type="submit" class="btn btn-danger">Sim, excluir</button>
        <a href="/backend/contato/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
