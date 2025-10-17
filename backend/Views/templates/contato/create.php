<h3>Novo Contato</h3>

<form action="/backend/contato/salvar" method="POST">
    <label for="nome_contato">Nome:</label>
    <input type="text" name="nome_contato" id="nome_contato" required>
    <br>

    <label for="telefone_contato">Telefone:</label>
    <input type="text" name="telefone_contato" id="telefone_contato">
    <br>

    <label for="email_contato">E-mail:</label>
    <input type="email" name="email_contato" id="email_contato" required>
    <br>

    <label for="assunto_contato">Assunto:</label>
    <textarea name="assunto_contato" id="assunto_contato" required></textarea>
    <br>

    <label for="data_envio">Data de Envio:</label>
    <input type="datetime-local" name="data_envio" id="data_envio" value="<?= date('Y-m-d\TH:i'); ?>">
    <br>

    <button type="submit" class="btn btn-primary">Enviar</button>
</form>
