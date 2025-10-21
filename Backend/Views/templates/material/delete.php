<div class="container mt-4">
    <div class="alert alert-danger">
        <h4>Confirmação de Exclusão</h4>
        <p>Tem certeza que deseja excluir este material?</p>
        <div class="card">
            <div class="card-body">
                <h6><?= htmlspecialchars($material['nome_material']) ?></h6>
                <p><strong>Quantidade:</strong> <?= htmlspecialchars($material['qtd_material']) ?></p>
                <p><strong>Descrição:</strong> <?= htmlspecialchars($material['descricao_material']) ?></p>
                <p><strong>Serviço:</strong> <?= htmlspecialchars($material['nome_servico']) ?></p>
            </div>
        </div>
    </div>

    <form action="/backend/material/deletar/<?= $material['id_material'] ?>" method="POST">
        <button type="submit" class="btn btn-danger">Sim, Excluir</button>
    </form>
    <a href="/backend/material/listar" class="btn btn-secondary">Cancelar</a>
</div>