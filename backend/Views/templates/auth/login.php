<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Impermax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --cor-primaria: #5f7396;
            --cor-secundaria: #ffffff;
            --cor-terciaria: #1487df;
            --cinza-claro: #a7a7a7;
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
        .content {
            margin-left: 250px;
            flex-grow: 1;
            padding: 162px 40px;
            background-color: var(--cor-fundo);
        }

        .login-card {
            background: var(--cor-secundaria);
            border-radius: 20px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
            width: 400px;
            padding: 2.5rem;
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }

        .login-card img {
            width: 150px;
            margin-bottom: 1.5rem;
        }

        .login-card h3 {
            color: var(--cor-primaria);
            font-weight: 600;
            margin-bottom: 1.8rem;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #ccc;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--cor-terciaria);
            box-shadow: 0 0 0 0.2rem rgba(20, 135, 223, 0.25);
        }

        .btn-login {
            width: 100%;
            background-color: var(--cor-primaria);
            color: white;
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem;
            transition: all 0.3s ease;
            border: none;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background-color: var(--cor-terciaria);
            transform: translateY(-2px);
        }

        .link-registro {
            color: var(--cor-primaria);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .link-registro:hover {
            text-decoration: underline;
            color: var(--cor-terciaria);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .footer-login {
            position: fixed;
            bottom: 15px;
            text-align: center;
            width: 100%;
            color: #fff;
            font-size: 0.85rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <img src="/assets/icons/impermax-LOGO.svg" alt="Logo Impermax">
        <h3>Acesso ao Sistema</h3>

        <form action="/backend/authenticar" method="POST">
            <div class="mb-3 input-group">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-envelope text-secondary"></i>
                </span>
                <input type="email" class="form-control border-start-0" name="email_usuario" placeholder="Email" required>
            </div>

            <div class="mb-4 input-group">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-lock text-secondary"></i>
                </span>
                <input type="password" class="form-control border-start-0" name="senha_usuario" placeholder="Senha" required>
            </div>

            <button type="submit" class="btn-login">Entrar</button>
        </form>

        <div class="mt-3">
            <a href="/backend/register" class="link-registro">Não tenho conta</a>
        </div>
    </div>

    <div class="footer-login">© 2025 Impermax | Painel Administrativo</div>
</body>
</html>
