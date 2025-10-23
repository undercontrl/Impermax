<?php
// Caminhos onde o footer não deve aparecer
$rotasPublicas = ['/backend/login', '/backend/register', '/backend/authenticar'];

// Pega o caminho atual sem query string
$currentPath = strtok($_SERVER['REQUEST_URI'], '?');

// Se for login/register/authenticar → não renderiza o footer
if (in_array($currentPath, $rotasPublicas)) {
    return;
}
?>

<footer class="text-center mt-4 pt-3 border-top text-secondary" style="font-size: .9rem;">
    &copy; <?= date('Y') ?> Impermax | Painel Administrativo
</footer>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
