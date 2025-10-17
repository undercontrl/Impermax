<h2>Cadastrar Novo Projeto</h2>

<form action="/backend/projeto/salvar" method="POST" enctype="multipart/form-data">

    <div>
        <label for="foto_antes_projeto">Foto Antes:</label><br>
        <input type="file" name="foto_antes_projeto" id="foto_antes_projeto" required>
        <small>Selecione a imagem do projeto antes da execução.</small>
    </div>

    <div style="margin-top: 15px;">
        <label for="foto_depois_projeto">Foto Depois:</label><br>
        <input type="file" name="foto_depois_projeto" id="foto_depois_projeto" required>
        <small>Selecione a imagem do projeto após a execução.</small>
    </div>

    <div style="margin-top: 15px;">
        <label for="descricao_projeto">Descrição:</label><br>
        <textarea name="descricao_projeto" id="descricao_projeto" rows="4" cols="50" placeholder="Descreva brevemente o projeto..." required></textarea>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-success">Cadastrar Projeto</button>
        <a href="/backend/projeto/listar" class="btn btn-secondary">Voltar</a>
    </div>
</form>