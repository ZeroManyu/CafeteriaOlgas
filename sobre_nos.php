<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Olgas</title>
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
            display: flex;
            justify-content: space-between; /* Para alinhar o botão "Sair" à direita */
        }

        nav ul {
            list-style: none;
            padding: 0;
            text-align: center;
            margin: 0; /* Removido o margin para alinhar corretamente com o header */
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        nav ul li button {
            background-color: #f04e31;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        main {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .about {
            text-align: center;
            padding: 20px;
        }

        .about h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .about p {
            margin-bottom: 10px;
            color: #666;
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
                <?php
                // Iniciar sessão
                session_start();

                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                    // O usuário está conectado. Exibir o botão de sair
                    echo '<li style="margin-left: auto;"><a href="logout.php">Sair</a></li>'; /* Alinhado à direita */
                } else {
                    // O usuário não está conectado. Exibir o botão de login
                    echo '<li><button id="loginBtn">Login</button></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        <section class="about">
            <h1>Sobre Nós</h1>
            <p>Site ficticio para o Projeto Integrador Transdisciplinar em Sistemas de Informação II da faculdade cruzeiro do sul cuja cafeteria gourmet tem o nome de "Olgas".</p>
            <p>Aluno: Vinicius Ferraz Franco de Oliveira</p>
            <p>RGM: 32002033</p>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>
