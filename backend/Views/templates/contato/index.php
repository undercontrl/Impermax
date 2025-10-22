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

                        // Define as cores conforme o status
                        switch ($status) {
                            case 'novo':
                                $badgeClass = 'bg-primary'; // azul
                                break;
                            case 'respondido':
                                $badgeClass = 'bg-success'; // verde
                                break;
                            case 'pendente':
                                $badgeClass = 'bg-warning text-dark'; // amarelo
                                break;
                            default:
                                $badgeClass = 'bg-secondary'; // cinza padrão
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
                            <a href="/backend/contato/editar/<?= $contato['id_contato'] ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="/backend/contato/excluir/<?= $contato['id_contato'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir este contato?');">Excluir</a>
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
