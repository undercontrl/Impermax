<div class="container mt-4">
    <div class="alert alert-danger">
        <h4>Confirmação de Exclusão</h4>
        <p>Tem certeza que deseja excluir o serviço:</p>
        <strong><?php echo htmlspecialchars($servico['nome_servico']); ?></strong>
        <br><em>Valor: R$ <?php echo number_format($servico['valor_base_servico'], 2, ',', '.'); ?></em>
    </div>

    <form action="/backend/servico/deletar/<?php echo $servico['id_servico']; ?>" method="post" style="display: inline;">
        <button type="submit" class="btn btn-danger">Sim, Excluir</button>
    </form>
    <a href="/backend/servico/listar" class="btn btn-secondary">Cancelar</a>
</div>