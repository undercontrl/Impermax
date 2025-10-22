<div class="container mt-4">
    <h2>Editar Endereço</h2>
    <form action="/backend/endereco/atualizar/<?= htmlspecialchars($endereco['id_endereco']) ?>" method="POST" id="formEnderecoEdit">
        <input type="hidden" name="id_endereco" value="<?= htmlspecialchars($endereco['id_endereco']) ?>">

        <div class="mb-3">
            <label for="id_usuario" class="form-label">Usuário</label>
            <select name="id_usuario" id="id_usuario" class="form-select" required>
                <option value="">Selecione...</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['id_usuario'] ?>"
                        <?= ($usuario['id_usuario'] == $endereco['id_usuario']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($usuario['nome_usuario']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="cep_endereco" class="form-label">CEP</label>
            <input type="text" name="cep_endereco" id="cep_endereco"
                   value="<?= htmlspecialchars($endereco['cep_endereco']) ?>"
                   class="form-control" maxlength="9" placeholder="00000-000" required>
            <small class="text-muted">Altere o CEP para atualizar automaticamente o endereço.</small>
        </div>

        <div class="mb-3">
            <label for="logadouro_endereco" class="form-label">Logradouro</label>
            <input type="text" name="logadouro_endereco" id="logadouro_endereco"
                   value="<?= htmlspecialchars($endereco['logadouro_endereco']) ?>"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="numero_endereco" class="form-label">Número</label>
            <input type="text" name="numero_endereco" id="numero_endereco"
                   value="<?= htmlspecialchars($endereco['numero_endereco']) ?>"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="complemento_endereco" class="form-label">Complemento</label>
            <input type="text" name="complemento_endereco" id="complemento_endereco"
                   value="<?= htmlspecialchars($endereco['complemento_endereco']) ?>"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label for="bairro_endereco" class="form-label">Bairro</label>
            <input type="text" name="bairro_endereco" id="bairro_endereco"
                   value="<?= htmlspecialchars($endereco['bairro_endereco']) ?>"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="cidade_endereco" class="form-label">Cidade</label>
            <input type="text" name="cidade_endereco" id="cidade_endereco"
                   value="<?= htmlspecialchars($endereco['cidade_endereco']) ?>"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="uf_endereco" class="form-label">UF</label>
            <input type="text" name="uf_endereco" id="uf_endereco"
                   value="<?= htmlspecialchars($endereco['uf_endereco']) ?>"
                   maxlength="2" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="/backend/endereco/listar" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<script>
// 🧠 Função que limpa os campos de endereço
function limpaFormularioCEP() {
    document.getElementById('logadouro_endereco').value = "";
    document.getElementById('bairro_endereco').value = "";
    document.getElementById('cidade_endereco').value = "";
    document.getElementById('uf_endereco').value = "";
}

// 🔍 Busca automática de endereço pelo CEP (ViaCEP)
document.getElementById('cep_endereco').addEventListener('blur', function() {
    const cep = this.value.replace(/\D/g, '');

    if (cep !== "") {
        const validaCEP = /^[0-9]{8}$/;

        if (validaCEP.test(cep)) {
            // Indicando carregamento
            document.getElementById('logadouro_endereco').value = "Carregando...";
            document.getElementById('bairro_endereco').value = "Carregando...";
            document.getElementById('cidade_endereco').value = "Carregando...";
            document.getElementById('uf_endereco').value = "";

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('logadouro_endereco').value = data.logradouro || "";
                        document.getElementById('bairro_endereco').value = data.bairro || "";
                        document.getElementById('cidade_endereco').value = data.localidade || "";
                        document.getElementById('uf_endereco').value = data.uf || "";
                    } else {
                        limpaFormularioCEP();
                        alert("CEP não encontrado.");
                    }
                })
                .catch(() => {
                    limpaFormularioCEP();
                    alert("Erro ao consultar o CEP.");
                });
        } else {
            limpaFormularioCEP();
            alert("Formato de CEP inválido.");
        }
    } else {
        limpaFormularioCEP();
    }
});
</script>
