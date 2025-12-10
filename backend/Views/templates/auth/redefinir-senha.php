<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Redefinir Senha | Impermax</title>

  <!-- Bootstrap + Ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>


    <!-- tem que arrumar o footer aqui -->

  <style>
    :root {
      --cor-primaria: #5f7396;
      --cor-terciaria: #1487df;
      --cor-branco: #ffffff;
      --cinza: #a7a7a7;
    }
    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
      background: linear-gradient(135deg, var(--cor-primaria), var(--cor-terciaria));
    }
    .reset-card {
      width: 420px;
      max-width: 92vw;
      background: var(--cor-branco);
      border-radius: 20px;
      box-shadow: 0 12px 28px rgba(0,0,0,.18);
      padding: 2.2rem 2rem;
      animation: fadeIn .5s ease;
      text-align: center;
    }
    .reset-card img {
      width: 150px;
      margin-bottom: 1rem;
      filter: none;
    }
    .reset-card h3 {
      color: var(--cor-primaria);
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    .reset-card .subtitle {
      color: var(--cinza);
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
    }
    .input-group-text {
      background: transparent;
      border-right: 0;
      color: var(--cor-primaria);
    }
    .form-control {
      border-left: 0;
      border-radius: 12px !important;
      padding: .8rem 1rem;
    }
    .form-control:focus {
      border-color: var(--cor-terciaria);
      box-shadow: 0 0 0 .2rem rgba(20,135,223,.2);
    }
    .btn-reset {
      width: 100%;
      background: var(--cor-primaria);
      color: #fff;
      border: 0;
      border-radius: 12px;
      padding: .85rem;
      font-weight: 600;
      transition: transform .2s ease, background .2s ease;
      margin-top: .25rem;
    }
    .btn-reset:hover { 
      background: var(--cor-terciaria); 
      transform: translateY(-2px); 
    }
    .password-strength {
      margin-top: 0.5rem;
      text-align: left;
    }
    .strength-bar {
      height: 4px;
      border-radius: 2px;
      background: #e2e8f0;
      margin-top: 0.5rem;
      overflow: hidden;
    }
    .strength-bar-fill {
      height: 100%;
      transition: all 0.3s ease;
      width: 0%;
    }
    .strength-text {
      font-size: 0.8rem;
      margin-top: 0.25rem;
      font-weight: 500;
    }
    .password-requirements {
      text-align: left;
      margin-top: 0.75rem;
      padding: 0.75rem;
      background: #f8fafc;
      border-radius: 8px;
      font-size: 0.8rem;
    }
    .requirement {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: var(--cinza);
      margin-bottom: 0.25rem;
    }
    .requirement.met {
      color: #22c55e;
    }
    .requirement i {
      font-size: 0.75rem;
    }
    .helper {
      font-size: .88rem; 
      color: var(--cinza);
    }
    .footer-reset {
      position: fixed;
      bottom: 15px;
      text-align: center;
      width: 100%;
      color: #fff;
      font-size: 0.85rem;
      opacity: 0.8;
    }
    .footer-note {
      margin-top: 1rem; 
      font-size: .9rem;
    }
    .footer-note a {
      color: var(--cor-primaria); 
      text-decoration: none;
    }
    .footer-note a:hover { 
      text-decoration: underline; 
      color: var(--cor-terciaria); 
    }
    .is-invalid + .invalid-feedback { 
      display: block; 
    }
    .alert {
      border-radius: 12px;
      margin-bottom: 1.5rem;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-8px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="reset-card">
    <img src="/assets/icons/impermax-LOGO.svg" alt="Impermax" />
    <h3>Redefinir Senha</h3>
    <p class="subtitle">Crie uma nova senha segura para sua conta</p>

    <?php
      // Mensagens flash
      if (class_exists('App\\Impermax\\Core\\Flash')) {
          $mensagem = App\Impermax\Core\Flash::get();
          if (!empty($mensagem)) {
              $tipo = ($mensagem['type'] ?? 'error') === 'success' ? 'success' : 'danger';
              $texto = $mensagem['message'] ?? '';
              echo "<div class='alert alert-$tipo text-start' role='alert'>
                      <i class='bi bi-" . ($tipo === 'success' ? 'check-circle' : 'exclamation-triangle') . "-fill me-2'></i>
                      $texto
                    </div>";
          }
      }
    ?>

    <form action="/backend/processar-redefinir-senha" method="POST" novalidate id="formReset">
      <!-- Token Hidden -->
      <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>" />

      <!-- Nova Senha -->
      <div class="mb-3 text-start">
        <label for="nova_senha" class="form-label">Nova Senha</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input
            type="password"
            id="nova_senha"
            name="nova_senha"
            class="form-control"
            placeholder="Crie uma senha forte"
            minlength="6"
            required
          />
          <button class="input-group-text" type="button" id="togglePass1" title="Mostrar/ocultar senha">
            <i class="bi bi-eye"></i>
          </button>
        </div>
        <div class="invalid-feedback">A senha deve ter no mínimo 6 caracteres.</div>
        
        <!-- Força da Senha -->
        <div class="password-strength">
          <div class="strength-bar">
            <div class="strength-bar-fill" id="strengthBar"></div>
          </div>
          <div class="strength-text" id="strengthText"></div>
        </div>

        <!-- Requisitos da Senha -->
        <div class="password-requirements">
          <div class="requirement" id="req-length">
            <i class="bi bi-circle"></i>
            <span>Mínimo 6 caracteres</span>
          </div>
          <div class="requirement" id="req-number">
            <i class="bi bi-circle"></i>
            <span>Pelo menos 1 número</span>
          </div>
          <div class="requirement" id="req-letter">
            <i class="bi bi-circle"></i>
            <span>Letras maiúsculas e minúsculas</span>
          </div>
        </div>
      </div>

      <!-- Confirmar Nova Senha -->
      <div class="mb-3 text-start">
        <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input
            type="password"
            id="confirmar_senha"
            name="confirmar_senha"
            class="form-control"
            placeholder="Repita a nova senha"
            minlength="6"
            required
          />
          <button class="input-group-text" type="button" id="togglePass2" title="Mostrar/ocultar senha">
            <i class="bi bi-eye"></i>
          </button>
        </div>
        <div class="invalid-feedback">As senhas precisam coincidir.</div>
      </div>

      <button class="btn-reset" type="submit">
        <i class="bi bi-shield-check me-2"></i>Redefinir Senha
      </button>
      
      <div class="footer-note helper">
        Lembrou sua senha? <a href="/backend/login">Voltar ao login</a>.
      </div>
    </form>
  </div>
  
  <div class="footer-reset">© 2025 Impermax | Painel Administrativo</div>

  <script>
    // Toggle visualizar senha
    function togglePassword(inputId, btnId) {
      const input = document.getElementById(inputId);
      const btn = document.getElementById(btnId);
      const icon = btn.querySelector('i');
      btn.addEventListener('click', () => {
        const isPass = input.type === 'password';
        input.type = isPass ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
      });
    }
    togglePassword('nova_senha', 'togglePass1');
    togglePassword('confirmar_senha', 'togglePass2');

    // Validador de força da senha
    const novaSenha = document.getElementById('nova_senha');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    const reqLength = document.getElementById('req-length');
    const reqNumber = document.getElementById('req-number');
    const reqLetter = document.getElementById('req-letter');

    novaSenha.addEventListener('input', function() {
      const senha = this.value;
      let strength = 0;
      
      // Verificar requisitos
      const hasLength = senha.length >= 6;
      const hasNumber = /\d/.test(senha);
      const hasLower = /[a-z]/.test(senha);
      const hasUpper = /[A-Z]/.test(senha);
      
      // Atualizar indicadores visuais
      updateRequirement(reqLength, hasLength);
      updateRequirement(reqNumber, hasNumber);
      updateRequirement(reqLetter, hasLower && hasUpper);
      
      // Calcular força
      if (hasLength) strength += 25;
      if (hasNumber) strength += 25;
      if (hasLower) strength += 25;
      if (hasUpper) strength += 25;
      
      // Atualizar barra
      strengthBar.style.width = strength + '%';
      
      if (strength === 0) {
        strengthBar.style.background = '#e2e8f0';
        strengthText.textContent = '';
      } else if (strength <= 25) {
        strengthBar.style.background = '#ef4444';
        strengthText.textContent = 'Fraca';
        strengthText.style.color = '#ef4444';
      } else if (strength <= 50) {
        strengthBar.style.background = '#f59e0b';
        strengthText.textContent = 'Regular';
        strengthText.style.color = '#f59e0b';
      } else if (strength <= 75) {
        strengthBar.style.background = '#3b82f6';
        strengthText.textContent = 'Boa';
        strengthText.style.color = '#3b82f6';
      } else {
        strengthBar.style.background = '#22c55e';
        strengthText.textContent = 'Excelente';
        strengthText.style.color = '#22c55e';
      }
    });

    function updateRequirement(element, isMet) {
      const icon = element.querySelector('i');
      if (isMet) {
        element.classList.add('met');
        icon.classList.remove('bi-circle');
        icon.classList.add('bi-check-circle-fill');
      } else {
        element.classList.remove('met');
        icon.classList.remove('bi-check-circle-fill');
        icon.classList.add('bi-circle');
      }
    }

    // Validação do formulário
    const form = document.getElementById('formReset');
    form.addEventListener('submit', function (e) {
      // Valida HTML5
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }

      const s1 = document.getElementById('nova_senha');
      const s2 = document.getElementById('confirmar_senha');

      // Verificar se senhas coincidem
      if (s1.value !== s2.value) {
        e.preventDefault();
        e.stopPropagation();
        s2.classList.add('is-invalid');
        s2.setCustomValidity('As senhas não coincidem');
      } else {
        s2.classList.remove('is-invalid');
        s2.setCustomValidity('');
      }

      // Verificar força mínima (opcional - pode remover se preferir)
      const senha = s1.value;
      const hasMinRequirements = senha.length >= 6 && /\d/.test(senha);
      
      if (!hasMinRequirements) {
        e.preventDefault();
        e.stopPropagation();
        s1.classList.add('is-invalid');
        alert('Sua senha deve ter no mínimo 6 caracteres e conter pelo menos 1 número.');
      }

      form.classList.add('was-validated');
    });

    // Verificar se há token na URL
    window.addEventListener('DOMContentLoaded', function() {
      const urlParams = new URLSearchParams(window.location.search);
      const token = urlParams.get('token');
      
      if (!token) {
        document.querySelector('.reset-card').innerHTML = `
          <img src="/assets/icons/impermax-LOGO.svg" alt="Impermax" />
          <h3>Link Inválido</h3>
          <div class="alert alert-danger text-start">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            O link de redefinição é inválido ou expirou.
          </div>
          <a href="/backend/esqueci-senha" class="btn-reset">
            <i class="bi bi-arrow-left me-2"></i>Solicitar Novo Link
          </a>
        `;
      }
    });
  </script>
</body>
</html>