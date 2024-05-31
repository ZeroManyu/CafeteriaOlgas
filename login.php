<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Olgas</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f3f3;
        }

        header {
            background-color: #f04e31; /* Cor laranja */
            color: #fff;
            padding: 10px 0;
        }

        nav ul {
            list-style: none;
            padding: 0;
            text-align: center;
            margin: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        .login-form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        .login-form h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }

        .create-account, .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .create-account a, .forgot-password a {
            color: #007BFF;
            text-decoration: none;
        }

        .create-account a:hover, .forgot-password a:hover {
            text-decoration: underline;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #f04e31; /* Cor laranja */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="cardapio.php">Cardápio</a></li>
                <li><a href="sobre_nos.php">Sobre Nós</a></li>
                <li><a href="contato.php">Contato</a></li>
                <li><a href="order_history.php">Histórico de Pedidos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="login-form">
            <h1>Login</h1>
            <?php
            // Verifica se há uma mensagem de erro na URL
            if(isset($_GET['error']) && $_GET['error'] == 'login_failed') {
                echo '<p class="error-message">Usuário ou senha inválidos. Por favor, tente novamente.</p>';
            }
            ?>
            <form action="login_process.php" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <button type="submit">Entrar</button>
            </form>
            <div class="create-account">
                <p>Não tem uma conta? <a href="register.php">Criar Conta</a></p>
            </div>
            <div class="forgot-password">
                <p>Esqueceu sua senha? <a href="forgot_password.php">Clique aqui</a></p>
            </div>
        </section>
    </main>
</body>
</html>
