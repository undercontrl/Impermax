<div class="container mt-4">
    <h2>Novo Contato</h2>
    <form action="/backend/contato/salvar" method="post" class="mt-3">

        <div class="mb-3">
            <label for="nome_contato" class="form-label">Nome:</label>
            <input type="text" id="nome_contato" name="nome_contato" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telefone_contato" class="form-label">Telefone:</label>
            <input type="text" id="telefone_contato" name="telefone_contato" class="form-control" placeholder="(xx) xxxxx-xxxx" required>
        </div>

        <div class="mb-3">
            <label for="email_contato" class="form-label">Email:</label>
            <input type="email" id="email_contato" name="email_contato" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="assunto_contato" class="form-label">Assunto:</label>
            <textarea id="assunto_contato" name="assunto_contato" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="data_envio" class="form-label">Data de Envio:</label>
            <input type="datetime-local" id="data_envio" name="data_envio" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="/backend/contato/listar" class="btn btn-secondary">Voltar</a>
    </form>
</div>
