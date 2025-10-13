<div>Sou o create</div>
<form action="/backend/projeto/salvar" method="post" enctype="multipart/form-data">
<label for="Foto_antes">Foto Antes</label>
<input type="file" name="foto_antes_projeto" id="foto_antes_projeto" require>
<br>
<label for="Foto_depois">Foto Depois</label>
<input type="file" name="foto_depois_projeto" id="foto_depois_projeto" require>
<br>
<label for="Descricao">Descrição</label>
<input type="text" name="descricao_projeto" id="descricao_projeto" require>
<br>
<button type="submit">Salvar</button>
</form>
