<div>Sou o create</div>
<form action="/backend/usuario/salvar" method="post">
<label for="Nome">Nome</label>
<input type="text" name="nome_usuario" id="nome_usuario" require>
<br>
<label for="Email">Email</label>
<input type="email" name="email_usuario" id="email_usuario" require>
<br>
<label for="Senha">Senha</label>
<input type="password" name="senha_usuario" id="senha_usuario" require>
<br>
<label for="Tipo">Tipo</label>
<select name="tipo_usuario" id="tipo_usuario" require>
    <option value="admin">Admin</option>
    <option value="user">User</option>
</select>
<br>
<button type="submit">Salvar</button>
</form>
