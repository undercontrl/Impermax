<div>Sou o create</div>
<form action="/backend/material/salvar" method="post">
<label for="Nome">Nome</label>
<input type="text" name="nome_material" id="nome_material" require>
<br>
<label for="Quantidade">Quantidade de material</label>
<input type="number" name="qtd_material" id="qtd_material" require>
<br>

<label for="Descricao">Descrição</label>
<input type="text" name="descricao_material" id="descricao_material" require>
<br>
<label for="id_servico">Para qual serviço</label>
<input type="text" name="id_servico" id="id_servico" require>
<br>
<button type="submit">Salvar</button>
</form>



<!-- tenho que relacionar o formulario com o nome dos serviços-->