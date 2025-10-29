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

<!-- AQUI TERMINA O CONTEÚDO DAS SUAS PÁGINAS -->

<footer class="dashboard-footer">
    <div class="footer-content">
        <div class="footer-left">
            <p class="footer-text">
                &copy; <?= date('Y') ?> <strong>Impermax</strong> - Todos os direitos reservados
            </p>
        </div>
        <div class="footer-right">
            <a href="https://docs.impermax.com" target="_blank" class="footer-link">Documentação</a>
            <span class="footer-divider">•</span>
            <a href="/backend/suporte" class="footer-link">Suporte</a>
            <span class="footer-divider">•</span>
            <a href="/backend/termos" class="footer-link">Termos de Uso</a>
        </div>
    </div>
</footer>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle menu mobile
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }

    // Fecha sidebar ao clicar fora (mobile)
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const menuBtn = document.querySelector('.mobile-menu-btn');
        
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
</script>

<style>
    /* ==================== FOOTER ==================== */
    .dashboard-footer {
        background: white;
        border-top: 1px solid #e2e8f0;
        padding: 1.5rem 0;
        margin-top: 3rem;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .footer-text {
        margin: 0;
        color: #64748b;
        font-size: 0.875rem;
    }

    .footer-text strong {
        color: var(--cor-primaria);
        font-weight: 600;
    }

    .footer-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .footer-link {
        color: #64748b;
        text-decoration: none;
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .footer-link:hover {
        color: var(--cor-acento);
    }

    .footer-divider {
        color: #cbd5e1;
    }

    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
            text-align: center;
        }
        
        .footer-right {
            width: 100%;
            justify-content: center;
        }
    }
</style>

</body>
</html>