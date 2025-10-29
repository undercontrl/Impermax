<div class="container mt-4">
    <div class="alert alert-danger">
        <h4>Confirmação de Exclusão</h4>
        <p>Tem certeza que deseja excluir o projeto?</p>
        <strong><?php echo htmlspecialchars($projeto['descricao_projeto']); ?></strong>
    </div>

    <form action="/backend/projeto/deletar/<?php echo $projeto['id_projeto']; ?>" method="post" style="display: inline;">
        <button type="submit" class="btn btn-danger">Sim, Excluir</button>
    </form>
    <a href="/backend/projeto/listar" class="btn btn-secondary">Cancelar</a>
</div>