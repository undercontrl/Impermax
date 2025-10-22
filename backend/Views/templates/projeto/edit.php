<div class="container mt-4">
    <h2>Editar Projeto</h2>
    <form action="/backend/projeto/atualizar/<?php echo $projeto['id_projeto']; ?>" method="post" enctype="multipart/form-data">
        
        <!-- FOTO ANTES -->
        <div class="mb-3">
            <label class="form-label">Foto Antes Atual:</label><br>
            <img src="/backend/upload/<?php echo htmlspecialchars($projeto['foto_antes_projeto']); ?>" width="150" class="mb-2">
            <input type="hidden" name="foto_antes_atual" value="<?php echo htmlspecialchars($projeto['foto_antes_projeto']); ?>">
            <input type="file" class="form-control" name="foto_antes" accept="image/*">
        </div>

        <!-- FOTO DEPOIS -->
        <div class="mb-3">
            <label class="form-label">Foto Depois Atual:</label><br>
            <img src="/backend/upload/<?php echo htmlspecialchars($projeto['foto_depois_projeto']); ?>" width="150" class="mb-2">
            <input type="hidden" name="foto_depois_atual" value="<?php echo htmlspecialchars($projeto['foto_depois_projeto']); ?>">
            <input type="file" class="form-control" name="foto_depois" accept="image/*">
        </div>

        <!-- DESCRIÇÃO -->
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao_projeto" rows="4" required><?php echo htmlspecialchars($projeto['descricao_projeto']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="/backend/projeto/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>