<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Esqueci Minha Senha | Impermax</title>

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
    .forgot-card {
      width: 420px;
      max-width: 92vw;
      background: var(--cor-branco);
      border-radius: 20px;
      box-shadow: 0 12px 28px rgba(0,0,0,.18);
      padding: 2.2rem 2rem;
      animation: fadeIn .5s ease;
      text-align: center;
    }
    .forgot-card img {
      width: 150px;
      margin-bottom: 1rem;
      filter: none;
    }
    .forgot-card h3 {
      color: var(--cor-primaria);
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    .forgot-card .subtitle {
      color: var(--cinza);
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
      line-height: 1.5;
    }
    .info-box {
      background: #f0f9ff;
      border-left: 4px solid var(--cor-terciaria);
      padding: 1rem;
      border-radius: 8px;
      text-align: left;
      margin-bottom: 1.5rem;
      font-size: 0.85rem;
      color: #1e40af;
    }
    .info-box i {
      margin-right: 0.5rem;
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
    .btn-forgot {
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
    .btn-forgot:hover { 
      background: var(--cor-terciaria); 
      transform: translateY(-2px); 
    }
    .btn-forgot:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }
    .helper {
      font-size: .88rem; 
      color: var(--cinza);
    }
    .footer-forgot {
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
    .success-message {
      display: none;
      background: #dcfce7;
      border: 1px solid #22c55e;
      border-radius: 12px;
      padding: 1.5rem;
      text-align: center;
      color: #166534;
      animation: fadeIn 0.5s ease;
    }
    .success-message i {
      font-size: 3rem;
      color: #22c55e;
      display: block;
      margin-bottom: 1rem;
    }
    .success-message h4 {
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: #166534;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-8px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="forgot-card">
    <img src="/assets/icons/impermax-LOGO.svg" alt="Impermax" />
    <h3>Esqueceu sua senha?</h3>
    <p class="subtitle">Não se preocupe! Digite seu e-mail e enviaremos um link para redefinir sua senha.</p>

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

    <!-- Formulário -->
    <div id="formContainer">
      <div class="info-box">
        <i class="bi bi-info-circle-fill"></i>
        <strong>Como funciona:</strong> Você receberá um e-mail com um link seguro para criar uma nova senha. O link expira em 1 hora.
      </div>

      <form action="/backend/processar-esqueci-senha" method="POST" novalidate id="formForgot">
        <!-- E-mail -->
        <div class="mb-3 text-start">
          <label for="email_usuario" class="form-label">E-mail cadastrado</label>
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

        <button class="btn-forgot" type="submit" id="btnSubmit">
          <i class="bi bi-send me-2"></i>Enviar Link de Redefinição
        </button>
        
        <div class="footer-note helper">
          Lembrou sua senha? <a href="/backend/login">Voltar ao login</a>.
        </div>
      </form>
    </div>

    <!-- Mensagem de Sucesso (oculta inicialmente) -->
    <div id="successMessage" class="success-message">
      <i class="bi bi-check-circle-fill"></i>
      <h4>E-mail Enviado!</h4>
      <p>Verifique sua caixa de entrada e siga as instruções para redefinir sua senha.</p>
      <small class="helper d-block mt-3">Não recebeu? Verifique a pasta de spam ou <a href="#" onclick="location.reload()">tente novamente</a>.</small>
    </div>
  </div>
  
  <div class="footer-forgot">© 2025 Impermax | Painel Administrativo</div>

  <script>
    const form = document.getElementById('formForgot');
    const btnSubmit = document.getElementById('btnSubmit');
    const formContainer = document.getElementById('formContainer');
    const successMessage = document.getElementById('successMessage');

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      // Validação HTML5
      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
      }

      // Desabilitar botão
      btnSubmit.disabled = true;
      btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

      // Enviar formulário via AJAX (opcional)
      // Se preferir envio normal, remova o e.preventDefault() e este código
      const formData = new FormData(form);

      fetch(form.action, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Mostrar mensagem de sucesso
          formContainer.style.display = 'none';
          successMessage.style.display = 'block';
        } else {
          // Mostrar erro
          alert(data.message || 'Erro ao processar solicitação. Tente novamente.');
          btnSubmit.disabled = false;
          btnSubmit.innerHTML = '<i class="bi bi-send me-2"></i>Enviar Link de Redefinição';
        }
      })
      .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao processar solicitação. Tente novamente.');
        btnSubmit.disabled = false;
        btnSubmit.innerHTML = '<i class="bi bi-send me-2"></i>Enviar Link de Redefinição';
      });
    });
  </script>
</body>
</html>