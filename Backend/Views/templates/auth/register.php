<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Criar Conta | Impermax</title>

  <!-- Bootstrap + Ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>

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
    .register-card {
      width: 420px;
      max-width: 92vw;
      background: var(--cor-branco);
      border-radius: 20px;
      box-shadow: 0 12px 28px rgba(0,0,0,.18);
      padding: 2.2rem 2rem;
      animation: fadeIn .5s ease;
      text-align: center;
    }
    .register-card img {
      width: 150px;
      margin-bottom: 1rem;
      filter: none; /* ajuste se sua logo for escura/clara */
    }
    .register-card h3 {
      color: var(--cor-primaria);
      font-weight: 600;
      margin-bottom: 1.2rem;
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
    .btn-register {
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
    .btn-register:hover { background: var(--cor-terciaria); transform: translateY(-2px); }
    .helper {
      font-size: .88rem; color: var(--cinza);
    }
    .password-hint {
      font-size: .8rem; text-align: left; color: var(--cinza);
      margin-top: .25rem;
    }
    .footer-register {
            position: fixed;
            bottom: 15px;
            text-align: center;
            width: 100%;
            color: #fff;
            font-size: 0.85rem;
            opacity: 0.8;
    }
        
    .footer-note {
      margin-top: 1rem; font-size: .9rem;
    }
    .footer-note a {
      color: var(--cor-primaria); text-decoration: none;
    }
    .footer-note a:hover { text-decoration: underline; color: var(--cor-terciaria); }
    .is-invalid + .invalid-feedback { display: block; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-8px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="register-card">
    <img src="/assets/logo/impermax-LOGO.svg" alt="Impermax" />
    <h3>Criar Nova Conta</h3>

    <?php
      // opcional: mensagens flash (se disponíveis)
      if (class_exists('App\\Impermax\\Core\\Flash')) {
          $mensagem = App\Impermax\Core\Flash::get();
          if (!empty($mensagem)) {
              $tipo = ($mensagem['type'] ?? 'error') === 'success' ? 'success' : 'danger';
              $texto = $mensagem['message'] ?? '';
              echo "<div class='alert alert-$tipo text-start' role='alert'>$texto</div>";
          }
      }
    ?>

    <form action="/backend/register" method="POST" novalidate id="formRegister">
      <!-- Nome -->
      <div class="mb-3 text-start">
        <label for="nome_usuario" class="form-label">Nome completo</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input
            type="text"
            id="nome_usuario"
            name="nome_usuario"
            class="form-control"
            placeholder="Ex.: João da Silva"
            required
          />
        </div>
        <div class="invalid-feedback">Informe seu nome.</div>
      </div>

      <!-- Email -->
      <div class="mb-3 text-start">
        <label for="email_usuario" class="form-label">E-mail</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input
            type="email"
            id="email_usuario"
            name="email_usuario"
            class="form-control"
            placeholder="seuemail@empresa.com"
            required
          />
        </div>
        <div class="invalid-feedback">Informe um e-mail válido.</div>
      </div>

      <!-- Senha -->
      <div class="mb-3 text-start">
        <label for="senha_usuario" class="form-label">Senha</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input
            type="password"
            id="senha_usuario"
            name="senha_usuario"
            class="form-control"
            placeholder="Mínimo 6 caracteres"
            minlength="6"
            required
          />
          <button class="input-group-text" type="button" id="togglePass1" title="Mostrar/ocultar senha">
            <i class="bi bi-eye"></i>
          </button>
        </div>
        <div class="password-hint">Use ao menos 6 caracteres. Combine letras e números para mais segurança.</div>
        <div class="invalid-feedback">A senha deve ter no mínimo 6 caracteres.</div>
      </div>

      <!-- Confirmar Senha -->
      <div class="mb-3 text-start">
        <label for="senha_confirm" class="form-label">Confirmar senha</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input
            type="password"
            id="senha_confirm"
            name="senha_confirm"
            class="form-control"
            placeholder="Repita a senha"
            minlength="6"
            required
          />
          <button class="input-group-text" type="button" id="togglePass2" title="Mostrar/ocultar senha">
            <i class="bi bi-eye"></i>
          </button>
        </div>
        <div class="invalid-feedback">As senhas precisam coincidir.</div>
      </div>

      <button class="btn-register" type="submit">Registrar</button>
      <div class="footer-note helper">
        Já tem uma conta? <a href="/backend/login">Faça login</a>.
      </div>
    </form>
  </div>
  <div class="footer-register">© 2025 Impermax | Painel Administrativo</div>
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
    togglePassword('senha_usuario', 'togglePass1');
    togglePassword('senha_confirm', 'togglePass2');

    // Validação simples de formulário + senhas iguais
    const form = document.getElementById('formRegister');
    form.addEventListener('submit', function (e) {
      // valida HTML5
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }

      const s1 = document.getElementById('senha_usuario');
      const s2 = document.getElementById('senha_confirm');

      if (s1.value !== s2.value) {
        e.preventDefault();
        e.stopPropagation();
        s2.classList.add('is-invalid');
      } else {
        s2.classList.remove('is-invalid');
      }

      form.classList.add('was-validated');
    });
  </script>
</body>
</html>