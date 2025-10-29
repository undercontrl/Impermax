<div class="container mt-4">
    <h2>Excluir Endereço</h2>

    <div class="alert alert-warning">
        <strong>Atenção!</strong> Esta ação marcará o endereço como <b>excluído</b> (exclusão lógica).
        Deseja realmente prosseguir?
    </div>

    <form action="/backend/endereco/deletar/<?= htmlspecialchars($id_endereco) ?>" method="POST">
        <input type="hidden" name="id_endereco" value="<?= htmlspecialchars($id_endereco) ?>">

        <div class="mb-3">
            <label class="form-label">ID do Endereço:</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($id_endereco) ?>" disabled>
        </div>

        <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash"></i> Confirmar Exclusão
        </button>
        <a href="/backend/endereco/listar" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>
