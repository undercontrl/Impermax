<div class="container mt-4">
    <div class="alert alert-danger">
        <h4>Confirmação de Exclusão</h4>
        <p>Tem certeza que deseja excluir este orçamento?</p>
        <div class="card">
            <div class="card-body">
                <h6><?= htmlspecialchars($orcamento['cliente_nome']) ?></h6>
                <p><strong>Descrição:</strong> <?= htmlspecialchars($orcamento['descricao_orcamento']) ?></p>
                <p><strong>Valor:</strong> R$ <?= number_format($orcamento['valor_orcamento'], 2, ',', '.') ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($orcamento['status_orcamento']) ?></p>
            </div>
        </div>
    </div>

    <form action="/backend/orcamento/deletar/<?= $orcamento['id_orcamento'] ?>" method="POST">
        <button type="submit" class="btn btn-danger">Sim, Excluir</button>
    </form>
    <a href="/backend/orcamento/listar" class="btn btn-secondary">Cancelar</a>
</div>