<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
                    <h4 >Novo Serviço para o Site</h4>
                <div class="card-body">
                    <form action="/backend/servico-site/salvar" method="POST" enctype="multipart/form-data">
                        <!-- NOME -->
                        <div class="mb-3">
                            <label for="nome_servico" class="form-label">Nome do Serviço *</label>
                            <input type="text" 
                                   name="nome_servico" 
                                   id="nome_servico" 
                                   class="form-control" 
                                   required 
                                   minlength="3" 
                                   maxlength="255"
                                   placeholder="Ex: Impermeabilização de Laje">
                        </div>

                        <!-- DESCRIÇÃO -->
                        <div class="mb-3">
                            <label for="descricao_servico" class="form-label">Descrição *</label>
                            <textarea name="descricao_servico" 
                                      id="descricao_servico" 
                                      class="form-control" 
                                      rows="5" 
                                      required 
                                      minlength="10" 
                                      maxlength="1000"
                                      placeholder="Descreva o serviço em detalhes..."></textarea>
                        </div>

                        <!-- FOTO -->
                        <div class="mb-3">
                            <label for="foto_servico" class="form-label">Foto do Serviço * (JPG, PNG, WEBP - máx 5MB)</label>
                            <input type="file" 
                                   name="foto_servico" 
                                   id="foto_servico" 
                                   class="form-control" 
                                   accept="image/jpeg,image/png,image/webp" 
                                   required>
                            <div class="form-text">
                                Tamanho ideal: 300x318px
                            </div>
                        </div>

                        <!-- BOTÕES -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                Criar Serviço
                            </button>
                            <a href="/backend/servico-site/listar" class="btn btn-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            
        </div>
    </div>
</div>

<!-- JS: Preview da foto (opcional) -->
<script>
document.getElementById('foto_servico').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.getElementById('preview-foto');
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'preview-foto';
                preview.className = 'img-thumbnail mt-2';
                preview.style.maxHeight = '200px';
                e.target.parentElement.appendChild(preview);
            }
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>