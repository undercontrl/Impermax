<style>
.d-flex.gap-1 {
    gap: 0.25rem;
}
.btn-sm {
    font-size: 0.775rem;
    padding: 0.25rem 0.5rem;
    white-space: nowrap;
}
.btn-sm i {
    margin-right: 0.25rem;
    font-size: 0.85rem;
}
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Contatos</h2>
        <a href="/backend/contato/criar" class="btn btn-success">Novo Contato</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Assunto</th>
                <th>Status</th>
                <th>Data de Envio</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($contatos)): ?>
                <?php foreach ($contatos as $contato): ?>
                    <?php
                        $status = strtolower(trim($contato['status_contato'] ?? ''));
                        switch ($status) {
                            case 'novo':
                                $badgeClass = 'bg-primary';
                                break;
                            case 'respondido':
                                $badgeClass = 'bg-success';
                                break;
                            case 'pendente':
                                $badgeClass = 'bg-warning text-dark';
                                break;
                            default:
                                $badgeClass = 'bg-secondary';
                        }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($contato['id_contato']) ?></td>
                        <td><?= htmlspecialchars($contato['nome_contato']) ?></td>
                        <td><?= htmlspecialchars($contato['telefone_contato']) ?></td>
                        <td><?= htmlspecialchars($contato['email_contato']) ?></td>
                        <td><?= htmlspecialchars($contato['assunto_contato']) ?></td>
                        <td>
                            <span class="badge rounded-pill <?= $badgeClass ?>"
                                  style="padding: 4px 8px; font-size: .78rem; border-radius: 6px; font-weight: 500; letter-spacing:.3px;">
                                <?= htmlspecialchars($contato['status_contato']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($contato['data_envio']))) ?></td>
                       <td>
    <div class="d-flex gap-1 flex-wrap">
        <!-- EDITAR -->
        <a href="/backend/contato/editar/<?= $contato['id_contato'] ?>" 
           class="btn btn-primary btn-sm" title="Editar">
            <i class="fas fa-edit"></i> Editar
        </a>

        <!-- CONVERTER -->
        <form action="/backend/contato/converter/<?= $contato['id_contato'] ?>" 
              method="POST" style="display:inline;"
              onsubmit="return confirm('Converter em cliente?')">
            <button type="submit" class="btn btn-success btn-sm" title="Converter em Cliente">
                <i class="fas fa-user-plus"></i> Cliente
            </button>
        </form>

        <!-- EXCLUIR -->
        <a href="/backend/contato/excluir/<?= $contato['id_contato'] ?>" 
           class="btn btn-danger btn-sm" title="Excluir"
           onclick="return confirm('Tem certeza que deseja excluir?')">
            <i class="fas fa-trash"></i> Excluir
        </a>
    </div>
</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Nenhum contato encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

