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
            background: linear-gradient(135deg, var(--cor-primaria), var(--cor-terciaria));
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Poppins", sans-serif;
            color: #333;
        }

        .login-container {
            background: var(--cor-secundaria);
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 380px;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .login-logo {
            width: 140px;
            margin-bottom: 1rem;
        }

        h3 {
            color: var(--cor-primaria);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #ccc;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--cor-terciaria);
            box-shadow: 0 0 0 0.2rem rgba(20, 135, 223, 0.2);
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

        .input-group-text {
            background: none;
            border: none;
            color: var(--cor-primaria);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="login-container fade-in">
        <img src="/assets/icons/impermax-LOGO.svg" alt="Logo Impermax" class="login-logo">
        <h3>Acesso ao Sistema</h3>

        <form action="/backend/login" method="POST">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" class="form-control" name="email_usuario" placeholder="Email" required>
            </div>

            <div class="mb-4 input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" name="senha_usuario" placeholder="Senha" required>
            </div>

            <button type="submit" class="btn-login">Entrar</button>
        </form>

        <div class="mt-3">
            <a href="/backend/register" class="link-registro">Não tenho conta</a>
        </div>
    </div>
</body>
</html>
<?php
use App\Impermax\Core\Flash;
$mensagem = Flash::get();
if(isset($mensagem)){
    foreach($mensagem as $key => $value){
        if($key == "type"){
            $tipo = $value == "success" ? "alert-success" : "alert-danger";
            echo "<div class='alert $tipo mt-3'>$mensagem[message]</div>";
        }
    }
}
?>
