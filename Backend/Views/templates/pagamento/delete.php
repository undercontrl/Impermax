<div class="container mt-4">
    <div class="alert alert-danger">
        <h4>Confirmação de Exclusão</h4>
        <p>Tem certeza que deseja excluir este pagamento?</p>
        
        <div class="card">
            <div class="card-body">
                <h6 class="card-title"><?= htmlspecialchars($pagamento['cliente_nome']) ?></h6>
                <p class="card-text">
                    <strong>Total Dev.:</strong> R$ <?= number_format($pagamento['total_devedor'], 2, ',', '.') ?><br>
                    <strong>Valor Pago:</strong> R$ <?= number_format($pagamento['dinheiro'] + $pagamento['debito'] + $pagamento['credito'] + $pagamento['pix'], 2, ',', '.') ?><br>
                    <strong>Status:</strong> <?= htmlspecialchars($pagamento['status_pagamento']) ?><br>
                    <strong>Data:</strong> <?= $pagamento['data_pagamento'] ? date('d/m/Y', strtotime($pagamento['data_pagamento'])) : 'Sem data' ?>
                </p>
            </div>
        </div>
    </div>

    <form action="/backend/pagamento/deletar/<?= $pagamento['id_pagamento'] ?>" method="post" style="display: inline;">
        <button type="submit" class="btn btn-danger">Sim, Excluir</button>
    </form>
    <a href="/backend/pagamento/listar" class="btn btn-secondary">Cancelar</a>
</div>