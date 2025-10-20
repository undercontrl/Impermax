<div class="container mt-4">
    <h2>Editar Contato</h2>
    <form action="/backend/contato/atualizar/<?= htmlspecialchars($contato['id_contato']) ?>" method="post" class="mt-3">
        
        <input type="hidden" name="id_contato" value="<?= htmlspecialchars($contato['id_contato']) ?>">

        <div class="mb-3">
            <label for="nome_contato" class="form-label">Nome:</label>
            <input type="text" id="nome_contato" name="nome_contato" class="form-control" 
                   value="<?= htmlspecialchars($contato['nome_contato']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="telefone_contato" class="form-label">Telefone:</label>
            <input type="text" id="telefone_contato" name="telefone_contato" class="form-control"
                   value="<?= htmlspecialchars($contato['telefone_contato']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email_contato" class="form-label">Email:</label>
            <input type="email" id="email_contato" name="email_contato" class="form-control"
                   value="<?= htmlspecialchars($contato['email_contato']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="assunto_contato" class="form-label">Assunto:</label>
            <textarea id="assunto_contato" name="assunto_contato" class="form-control" rows="3" required><?= htmlspecialchars($contato['assunto_contato']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="status_contato" class="form-label">Status:</label>
            <select id="status_contato" name="status_contato" class="form-select" required>
                <?php
                $status = ["pendente", "respondido", "resolvido"];
                foreach ($status as $st):
                ?>
                    <option value="<?= $st ?>" <?= ($st == $contato['status_contato']) ? 'selected' : '' ?>>
                        <?= ucfirst($st) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="data_envio" class="form-label">Data de Envio:</label>
            <input type="datetime-local" id="data_envio" name="data_envio" class="form-control"
                   value="<?= date('Y-m-d\TH:i', strtotime($contato['data_envio'])) ?>">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="/backend/contato/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
