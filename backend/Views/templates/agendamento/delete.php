<div class="container mt-5 text-center">
    <h3 class="mb-4 text-danger">Excluir Agendamento</h3>
    <p>Tem certeza que deseja excluir este agendamento?</p>

    <form action="/backend/agendamento/deletar/<?= htmlspecialchars($id_agendamento) ?>" method="post">
        <input type="hidden" name="id_agendamento" value="<?= htmlspecialchars($id_agendamento) ?>">
        <button type="submit" class="btn btn-danger">Sim, excluir</button>
        <a href="/backend/agendamento/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
