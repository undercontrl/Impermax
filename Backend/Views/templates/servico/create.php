<div>Sou o create</div>
<form action="/backend/servico/salvar" method="post">
<label for="Nome">Nome</label>
<input type="text" name="nome_servico" id="nome_servico" require>
<br>
<label for="Descricao">Descrição</label>
<input type="text" name="descricao_servico" id="descricao_servico" require>
<br>
<label for="Valor">Valor do servico</label>
<input type="decimal" name="valor_base_servico" id="valor_base_servico" require>
<br>
<label for="Foto">Foto do Serviço</label>
<input type="text" name="foto_servico" id="foto_servico" require>
<br>
<button type="submit">Salvar</button>
</form>
