<div class="container mt-4">
    <div class="alert alert-danger">
        <h4>Confirmar Exclusão</h4>
        <p>
            Você tem certeza que deseja <strong>excluir permanentemente</strong> o serviço?
        </p>
        <p>
            <strong><?= htmlspecialchars($servico['nome_servico']) ?></strong><br>
            <em>Valor: R$ <?= number_format($servico['valor_base_servico'], 2, ',', '.') ?></em>
        </p>
        <p class="text-muted small">
            Esta ação é irreversível. O serviço será removido do sistema.
        </p>
    </div>

    <form action="/backend/servico/deletar/<?= $servico['id_servico'] ?>" method="POST" style="display: inline;">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger">
            Sim, Excluir Serviço
        </button>
        <a href="/backend/servico/listar" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>