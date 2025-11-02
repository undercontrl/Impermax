<?php
/**
 * SCRIPT DE DIAGNÓSTICO - Upload de Serviços
 * 
 * Coloque este arquivo na raiz do projeto e acesse via navegador
 * para verificar todas as configurações e testar o upload
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Diagnóstico de Upload - Serviços</h1>";
echo "<hr>";

// ==================== 1. CONFIGURAÇÕES PHP ====================
echo "<h2>1. Configurações PHP</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Configuração</th><th>Valor</th><th>Status</th></tr>";

$configs = [
    'file_uploads' => ini_get('file_uploads'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'max_file_uploads' => ini_get('max_file_uploads'),
    'upload_tmp_dir' => ini_get('upload_tmp_dir') ?: sys_get_temp_dir(),
    'memory_limit' => ini_get('memory_limit')
];

foreach ($configs as $key => $value) {
    $status = '✅';
    if ($key === 'file_uploads' && !$value) $status = '❌';
    echo "<tr><td><strong>$key</strong></td><td>$value</td><td>$status</td></tr>";
}
echo "</table><br>";

// ==================== 2. EXTENSÕES PHP ====================
echo "<h2>2. Extensões PHP</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Extensão</th><th>Status</th></tr>";

$extensoes = [
    'gd' => extension_loaded('gd'),
    'fileinfo' => extension_loaded('fileinfo'),
    'exif' => extension_loaded('exif')
];

foreach ($extensoes as $ext => $loaded) {
    $status = $loaded ? '✅ Carregada' : '❌ Não carregada';
    echo "<tr><td><strong>$ext</strong></td><td>$status</td></tr>";
}
echo "</table><br>";

// ==================== 3. FUNÇÕES DISPONÍVEIS ====================
echo "<h2>3. Funções Disponíveis</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Função</th><th>Status</th></tr>";

$funcoes = [
    'getimagesize' => function_exists('getimagesize'),
    'mime_content_type' => function_exists('mime_content_type'),
    'finfo_open' => function_exists('finfo_open'),
    'imagecreatefromjpeg' => function_exists('imagecreatefromjpeg'),
    'imagecreatefrompng' => function_exists('imagecreatefrompng')
];

foreach ($funcoes as $func => $exists) {
    $status = $exists ? '✅ Disponível' : '❌ Não disponível';
    echo "<tr><td><strong>$func</strong></td><td>$status</td></tr>";
}
echo "</table><br>";

// ==================== 4. ESTRUTURA DE PASTAS ====================
echo "<h2>4. Estrutura de Pastas</h2>";

$documentRoot = $_SERVER['DOCUMENT_ROOT'];
echo "<p><strong>DOCUMENT_ROOT:</strong> $documentRoot</p>";

$pastas = [
    'upload' => $documentRoot . '/upload',
    'upload/servicos' => $documentRoot . '/upload/servicos',
    'upload/projeto' => $documentRoot . '/upload/projeto'
];

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Pasta</th><th>Existe?</th><th>Gravável?</th><th>Caminho Completo</th></tr>";

foreach ($pastas as $nome => $caminho) {
    $existe = is_dir($caminho) ? '✅ Sim' : '❌ Não';
    $gravavel = is_writable($caminho) ? '✅ Sim' : '❌ Não';
    echo "<tr><td><strong>$nome</strong></td><td>$existe</td><td>$gravavel</td><td><code>$caminho</code></td></tr>";
}
echo "</table><br>";

// ==================== 5. TESTE DE ESCRITA ====================
echo "<h2>5. Teste de Escrita</h2>";

$testeDir = $documentRoot . '/upload/servicos';
if (!is_dir($testeDir)) {
    echo "<p style='color:red'>❌ Pasta /upload/servicos não existe!</p>";
    echo "<p><strong>Solução:</strong> Crie a pasta manualmente:</p>";
    echo "<pre>mkdir -p " . $testeDir . "</pre>";
} else {
    $testFile = $testeDir . '/test-' . time() . '.txt';
    if (@file_put_contents($testFile, 'Teste de escrita - ' . date('Y-m-d H:i:s'))) {
        echo "<p style='color:green'>✅ <strong>Escrita OK!</strong> Arquivo de teste criado com sucesso.</p>";
        echo "<p>Arquivo criado: <code>$testFile</code></p>";
        
        // Deletar arquivo de teste
        if (@unlink($testFile)) {
            echo "<p style='color:green'>✅ Exclusão OK! Arquivo de teste removido.</p>";
        }
    } else {
        echo "<p style='color:red'>❌ <strong>Erro de escrita!</strong> Não foi possível criar arquivo.</p>";
        echo "<p><strong>Solução (Windows):</strong></p>";
        echo "<pre>icacls \"$testeDir\" /grant Everyone:(OI)(CI)F</pre>";
        echo "<p><strong>Solução (Linux):</strong></p>";
        echo "<pre>chmod 755 $testeDir</pre>";
    }
}

echo "<br>";

// ==================== 6. VERIFICAR FILEMANAGER ====================
echo "<h2>6. Verificar FileManager</h2>";

$fileManagerPath = $documentRoot . '/Impermax/Backend/Core/FileManager.php';
if (file_exists($fileManagerPath)) {
    echo "<p style='color:green'>✅ FileManager encontrado em: <code>$fileManagerPath</code></p>";
} else {
    echo "<p style='color:red'>❌ FileManager NÃO encontrado!</p>";
    echo "<p>Procure em: <code>App/Impermax/Core/FileManager.php</code></p>";
}

echo "<br>";

// ==================== 7. LISTAR ARQUIVOS EXISTENTES ====================
echo "<h2>7. Arquivos na Pasta de Upload</h2>";

$uploadDir = $documentRoot . '/upload/servicos';
if (is_dir($uploadDir)) {
    $arquivos = scandir($uploadDir);
    $arquivos = array_diff($arquivos, ['.', '..']);
    
    if (count($arquivos) > 0) {
        echo "<p>Encontrados <strong>" . count($arquivos) . "</strong> arquivo(s):</p>";
        echo "<ul>";
        foreach ($arquivos as $arquivo) {
            $caminho = $uploadDir . '/' . $arquivo;
            $tamanho = filesize($caminho);
            $tamanhoMB = round($tamanho / 1024 / 1024, 2);
            echo "<li><strong>$arquivo</strong> - $tamanhoMB MB</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color:orange'>⚠️ Nenhum arquivo encontrado na pasta.</p>";
    }
} else {
    echo "<p style='color:red'>❌ Pasta não existe!</p>";
}

echo "<br>";

// ==================== 8. TESTE DE UPLOAD ====================
echo "<h2>8. Teste de Upload</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['teste_foto'])) {
    echo "<div style='background:#f0f0f0; padding:20px; border:2px solid #333; margin:20px 0;'>";
    echo "<h3>📊 Resultado do Upload</h3>";
    
    $file = $_FILES['teste_foto'];
    
    echo "<h4>Informações do Arquivo:</h4>";
    echo "<pre>";
    print_r($file);
    echo "</pre>";
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        echo "<p style='color:green'>✅ <strong>Upload sem erros!</strong></p>";
        
        // Testar getimagesize
        $imageInfo = @getimagesize($file['tmp_name']);
        if ($imageInfo) {
            echo "<h4>Informações da Imagem:</h4>";
            echo "<ul>";
            echo "<li><strong>Largura:</strong> {$imageInfo[0]}px</li>";
            echo "<li><strong>Altura:</strong> {$imageInfo[1]}px</li>";
            echo "<li><strong>Tipo:</strong> {$imageInfo[2]}</li>";
            echo "<li><strong>MIME:</strong> {$imageInfo['mime']}</li>";
            echo "</ul>";
            
            // Tentar salvar o arquivo
            $nomeArquivo = 'teste-' . time() . '-' . basename($file['name']);
            $caminhoDestino = $documentRoot . '/upload/servicos/' . $nomeArquivo;
            
            if (move_uploaded_file($file['tmp_name'], $caminhoDestino)) {
                echo "<p style='color:green; font-size:18px;'>✅ <strong>SUCESSO!</strong> Arquivo salvo em:</p>";
                echo "<p><code>$caminhoDestino</code></p>";
                echo "<p><strong>URL:</strong> <a href='/upload/servicos/$nomeArquivo' target='_blank'>/upload/servicos/$nomeArquivo</a></p>";
                echo "<img src='/upload/servicos/$nomeArquivo' style='max-width:300px; border:2px solid green;'>";
            } else {
                echo "<p style='color:red'>❌ <strong>ERRO ao mover arquivo!</strong></p>";
                echo "<p>De: <code>{$file['tmp_name']}</code></p>";
                echo "<p>Para: <code>$caminhoDestino</code></p>";
            }
        } else {
            echo "<p style='color:red'>❌ Arquivo não é uma imagem válida!</p>";
        }
    } else {
        $erros = [
            UPLOAD_ERR_INI_SIZE => 'Arquivo maior que upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'Arquivo maior que MAX_FILE_SIZE do form',
            UPLOAD_ERR_PARTIAL => 'Upload parcial',
            UPLOAD_ERR_NO_FILE => 'Nenhum arquivo enviado',
            UPLOAD_ERR_NO_TMP_DIR => 'Pasta temp ausente',
            UPLOAD_ERR_CANT_WRITE => 'Falha ao escrever',
            UPLOAD_ERR_EXTENSION => 'Bloqueado por extensão'
        ];
        
        $mensagem = $erros[$file['error']] ?? 'Erro desconhecido';
        echo "<p style='color:red'>❌ <strong>Erro no upload:</strong> $mensagem (código: {$file['error']})</p>";
    }
    
    echo "</div>";
}

?>

<h3>🧪 Formulário de Teste</h3>
<form method="POST" enctype="multipart/form-data" style="background:#f9f9f9; padding:20px; border:2px solid #007bff;">
    <p><strong>Selecione uma imagem para testar o upload:</strong></p>
    <input type="file" name="teste_foto" accept="image/*" required style="padding:10px; font-size:16px;">
    <br><br>
    <button type="submit" style="background:#007bff; color:white; padding:10px 30px; border:none; border-radius:5px; font-size:16px; cursor:pointer;">
        📤 Testar Upload
    </button>
</form>

<hr>
<h3>📝 Resumo</h3>
<p>Se todos os itens acima estiverem com ✅, o upload deve funcionar.</p>
<p><strong>Problemas comuns:</strong></p>
<ul>
    <li>❌ Pasta não existe → Criar manualmente</li>
    <li>❌ Sem permissão de escrita → Ajustar permissões</li>
    <li>❌ file_uploads = Off → Habilitar no php.ini</li>
    <li>❌ upload_max_filesize muito pequeno → Aumentar no php.ini</li>
</ul>

<p style="margin-top:40px; color:#666; font-size:12px;">
    <strong>Versão PHP:</strong> <?= PHP_VERSION ?><br>
    <strong>Sistema:</strong> <?= PHP_OS ?><br>
    <strong>Data/Hora:</strong> <?= date('Y-m-d H:i:s') ?>
</p>