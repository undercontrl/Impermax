<div class="container mt-4">
    <div class="alert alert-danger">
        <h4>Confirmar Inativação</h4>
        <p>Você tem certeza que deseja inativar (excluir) o serviço?</p>
        <strong><?php echo htmlspecialchars($servico['nome_servico']); ?></strong>
        <br><em>Valor: R$ <?php echo number_format($servico['valor_base_servico'], 2, ',', '.'); ?></em>
    </div>

    <form action="/backend/servico/deletar/<?php echo $servico['id_servico']; ?>" method="post" style="display: inline;">
            <p>
                <button type="submit" class="btn btn-danger">Sim, Inativar Serviço</button>
                <a href="/backend/servico/listar" class="btn btn-secondary">Cancelar</a>
            </p>
    </form>
</div>
