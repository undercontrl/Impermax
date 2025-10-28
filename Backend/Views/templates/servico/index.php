<div class="container mt-4">
    <h2>Serviços Internos</h2>

    <!-- Abas -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" href="/backend/servico/listar">Serviços Internos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/backend/servico-site/listar">Site</a>
        </li>
    </ul>

    <!-- BUSCA COM SUGESTÕES -->
    <div class="position-relative mb-3">
        <input 
            type="text" 
            id="busca-servico" 
            class="form-control form-control-lg" 
            placeholder="Digite para buscar serviços..." 
            autocomplete="off"
            value="<?= htmlspecialchars($termo ?? '') ?>">
        
        <!-- Dropdown de sugestões -->
        <div id="sugestoes" class="dropdown-menu w-100 mt-1" style="display:none;">
            <!-- Preenchido via JS -->
        </div>
    </div>

     <div class="d-flex justify-content-end">
        <a href="/backend/servico/criar" class="btn btn-success mb-3">+ Novo</a>
    </div>

    <!-- TABELA -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Valor (R$)</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($servicos as $s): ?>
            <tr>
                <td><?= $s['id_servico'] ?></td>
                <td><?= htmlspecialchars($s['nome_servico']) ?></td>
                <td><?= htmlspecialchars(substr($s['descricao_servico'], 0, 60)) ?>...</td>
                <td>R$ <?= number_format($s['valor_base_servico'], 2, ',', '.') ?></td>
                <td>
                    <a href="/backend/servico/editar/<?= $s['id_servico'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="/backend/servico/excluir/<?= $s['id_servico'] ?>" class="btn btn-sm btn-danger">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- PAGINAÇÃO FUNCIONAL -->
    <?php if ($paginacao && $paginacao['total_paginas'] > 1): ?>
    <nav aria-label="Paginação">
        <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= $paginacao['total_paginas']; $i++): ?>
            <li class="page-item <?= $i == $paginacao['pagina_atual'] ? 'active' : '' ?>">
                <a class="page-link" href="/backend/servico/listar/<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<!-- JS DE AUTOCOMPLETE (Google-like) -->
<script>
let debounceTimer;
document.getElementById('busca-servico').addEventListener('input', function(e) {
    clearTimeout(debounceTimer);
    const termo = e.target.value.trim();
    const dropdown = document.getElementById('sugestoes');
    
    if (termo.length < 2) {
        dropdown.style.display = 'none';
        return;
    }

    debounceTimer = setTimeout(() => {
        fetch(`/backend/servico/sugestoes?termo=${encodeURIComponent(termo)}`)
            .then(r => r.json())
            .then(data => {
                dropdown.innerHTML = '';
                if (data.length === 0) {
                    dropdown.innerHTML = '<a class="dropdown-item text-muted">Nenhum resultado</a>';
                } else {
                    data.forEach(s => {
                        const item = document.createElement('a');
                        item.className = 'dropdown-item';
                        item.href = '#';
                        item.textContent = `${s.id_servico} - ${s.nome_servico}`;
                        item.onclick = (ev) => {
                            ev.preventDefault();
                            document.getElementById('busca-servico').value = s.nome_servico;
                            dropdown.style.display = 'none';
                            window.location.href = `/backend/servico/listar/1?termo=${encodeURIComponent(s.nome_servico)}`;
                        };
                        dropdown.appendChild(item);
                    });
                }
                dropdown.style.display = 'block';
            });
    }, 300);
});

// Fecha ao clicar fora
document.addEventListener('click', (e) => {
    if (!e.target.closest('#busca-servico') && !e.target.closest('#sugestoes')) {
        document.getElementById('sugestoes').style.display = 'none';
    }
});
</script>