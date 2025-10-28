<?php
    $acao = ($servico['status_servico'] === 'Ativo') ? 'Inativar' : 'Ativar';
    $mensagem = ($servico['status_servico'] === 'Ativo') 
        ? 'Você tem certeza que deseja inativar o serviço?' 
        : 'Você tem certeza que deseja ativar o serviço?';
?>
<div class="container mt-4">
    <div class="alert alert-danger">
        <h4>Confirmar <?php echo $acao; ?></h4>
        <p><?php echo $mensagem; ?></p>
        <strong><?php echo htmlspecialchars($servico['nome_servico']); ?></strong>
        <br><em>Valor: R$ <?php echo number_format($servico['valor_base_servico'], 2, ',', '.'); ?></em>
    </div>

    <form action="/backend/servico/deletar/<?php echo $servico['id_servico']; ?>" method="post" style="display: inline;">
        <input type="hidden" name="id_servico" value="<?php echo $servico['id_servico']; ?>">
        <p>
            <button type="submit" class="btn btn-danger">Sim, <?php echo $acao; ?> Serviço</button>
            <a href="/backend/servico/listar" class="btn btn-secondary">Cancelar</a>
        </p>
    </form>
</div>