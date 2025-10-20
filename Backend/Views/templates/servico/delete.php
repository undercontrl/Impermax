<h2>Excluir Serviço</h2>
<p>Tem certeza que deseja excluir o serviço <strong><?php echo htmlspecialchars($servico['nome_servico']); ?></strong>?</p>

<form action="/backend/servico/deletar/<?php echo htmlspecialchars($servico['id_servico']); ?>" method="post">
    <button type="submit">Sim, excluir</button>
    <a href="/backend/servico/listar">Cancelar</a>
</form>