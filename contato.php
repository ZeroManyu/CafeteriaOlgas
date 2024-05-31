<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Olgas</title>
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

        .contact {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        .contact h1 {
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

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #f04e31; /* Cor laranja */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .success-message {
            color: #008000; /* Cor verde */
            text-align: center;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
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
            <button id="loginBtn">Login</button>
        </nav>
    </header>
    <main>
        <section class="contact">
            <h1>Entre em Contato</h1>
            <?php
            // Verificar se o formulário foi submetido
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Verificar se os campos do formulário foram preenchidos
                if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])) {
                    // Enviar email, salvar no banco de dados, etc.

                    // Exibir mensagem de sucesso
                    echo "<p class='success-message'>Sua mensagem foi enviada com sucesso!</p>";
                } else {
                    // Exibir mensagem de erro se algum campo estiver vazio
                    echo "<p class='error-message'>Por favor, preencha todos os campos do formulário.</p>";
                }
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="contact-form">
                <div class="form-group">
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Mensagem:</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit">Enviar Mensagem</button>
            </form>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>
