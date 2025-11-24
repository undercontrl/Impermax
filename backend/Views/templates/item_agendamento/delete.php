<div class="container mt-4">
    <h2>Excluir Item de Agendamento</h2>

    <div class="alert alert-warning mt-3">
        <strong>Atenção!</strong> Esta ação marcará o item de agendamento como <b>excluído</b>.
        Deseja realmente prosseguir?
    </div>

    <form action="/backend/item_agendamento/deletar/<?= htmlspecialchars($id_item_agendamento) ?>" method="POST">
        <input type="hidden" name="id_item_agendamento" value="<?= htmlspecialchars($id_item_agendamento) ?>">

        <div class="mb-3">
            <label class="form-label">ID do Item:</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($id_item_agendamento) ?>" disabled>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="/backend/item_agendamento/listar" class="btn btn-secondary">
                Cancelar
            </a>
            <button type="submit" class="btn btn-danger">
                Confirmar Exclusão
            </button>
        </div>
    </form>
</div>

<script>
    // Confirmação adicional via JS
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!confirm("Tem certeza que deseja excluir este item de agendamento?")) {
            e.preventDefault();
        }
    });
</script>
