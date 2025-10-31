<div class="container mt-4">
    <h2>Excluir Item de Orçamento</h2>
    <p>Tem certeza que deseja excluir este item?</p>

    <form action="/backend/item_orcamento/deletar/<?= htmlspecialchars($id_item_orcamento) ?>" method="POST">
        <button type="submit" class="btn btn-danger">Sim, excluir</button>
        <a href="/backend/item_orcamento/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
