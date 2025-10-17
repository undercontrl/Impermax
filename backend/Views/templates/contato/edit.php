<h3>Editar Contato</h3>

<form action="/backend/contato/atualizar/<?= $contato['id_contato']; ?>" method="POST">
    <input type="hidden" name="id_contato" value="<?= $contato['id_contato']; ?>">

    <label for="nome_contato">Nome:</label>
    <input type="text" name="nome_contato" id="nome_contato"
           value="<?= htmlspecialchars($contato['nome_contato']); ?>" required>
    <br>

    <label for="telefone_contato">Telefone:</label>
    <input type="text" name="telefone_contato" id="telefone_contato"
           value="<?= htmlspecialchars($contato['telefone_contato']); ?>">
    <br>

    <label for="email_contato">E-mail:</label>
    <input type="email" name="email_contato" id="email_contato"
           value="<?= htmlspecialchars($contato['email_contato']); ?>" required>
    <br>

    <label for="assunto_contato">Assunto:</label>
    <textarea name="assunto_contato" id="assunto_contato" required><?= htmlspecialchars($contato['assunto_contato']); ?></textarea>
    <br>

    <label for="status_contato">Status:</label>
    <select name="status_contato" id="status_contato" required>
        <option value="pendente" <?= $contato['status_contato'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
        <option value="respondido" <?= $contato['status_contato'] == 'respondido' ? 'selected' : ''; ?>>Respondido</option>
    </select>
    <br>

    <label for="data_envio">Data de Envio:</label>
    <input type="datetime-local" name="data_envio" id="data_envio"
           value="<?= date('Y-m-d\TH:i', strtotime($contato['data_envio'])); ?>">
    <br>

    <button type="submit" class="btn btn-primary">Atualizar</button>
    <a href="/backend/contato/listar" class="btn btn-secondary">Cancelar</a>
</form>
