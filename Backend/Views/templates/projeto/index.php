<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Projetos</h2>
        <a href="/backend/projeto/criar" class="btn btn-success">Cadastrar Projetos</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
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
                <th scope="row"><?php echo htmlspecialchars($projeto['id_projeto']); ?></th>
                <td><img src="/backend/upload/<?php echo htmlspecialchars($projeto['foto_antes_projeto']); ?>" alt="Antes" width="100px"></td>
                <td><img src="/backend/upload/<?php echo htmlspecialchars($projeto['foto_depois_projeto']); ?>" alt="Depois" width="100px"></td>
                <td><?php echo htmlspecialchars($projeto['descricao_projeto']); ?></td>
                <td>
                    <a href="/backend/projeto/editar/<?php echo $projeto['id_projeto']; ?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="/backend/projeto/excluir/<?php echo $projeto['id_projeto']; ?>" class="btn btn-danger btn-sm" 
                       onclick="return confirm('Tem certeza que deseja excluir este projeto?');">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
     <?php if ($paginacao && $paginacao['total_paginas'] > 1): ?>
    <nav aria-label="Paginação">
        <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= $paginacao['total_paginas']; $i++): ?>
            <li class="page-item <?= $i == $paginacao['pagina_atual'] ? 'active' : '' ?>">
                <a class="page-link" href="/backend/projeto/listar/<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>