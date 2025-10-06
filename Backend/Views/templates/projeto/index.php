<a href="/backend/projeto/criar">Cadastrar Projetos</a>

<div>Lista de Projetos</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Foto Antes</th>
            <th scope="col">Foto Depois</th>
            <th scope="col">Descrição</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($Projetos as $projeto): ?>
        <tr>
            <th scope="row"><?= htmlspecialchars($projeto['id_projeto']) ?></th>
            <td><?= htmlspecialchars($projeto['foto_antes_projeto']) ?></td>
            <td><?= htmlspecialchars($projeto['foto_depois_projeto']) ?></td>
            <td><?= htmlspecialchars($projeto['descricao_projeto']) ?></td>
            <td>
                <a href="/backend/projeto/editar?id=<?= htmlspecialchars($projeto['id_projeto']) ?>" class="btn btn-primary btn-sm">Editar</a>
                <a href="/backend/projeto/excluir?id=<?= htmlspecialchars($projeto['id_projeto']) ?>"  class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este projeto?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>






