<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olgas - Cafeteria Gourmet Delivery</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #ff6347;
            padding: 20px 0;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        .login-button,
        .logout-button,
        .cta-button {
            background-color: #ff6347;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .login-button:hover,
        .logout-button:hover,
        .cta-button:hover {
            background-color: #ff4836;
        }

        .hero {
            background-image: url('images/hero-background.jpg');
            background-size: cover;
            color: #fff;
            padding: 100px 20px;
            text-align: center;
        }

        .features {
            padding: 50px 20px;
            text-align: center;
        }

        .feature {
            margin-bottom: 40px;
        }

        .feature img {
            width: 100%;
            border-radius: 5px;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    // Iniciar sessão
    session_start();

    // Verificar se o usuário está conectado
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
        // O usuário está conectado. Você pode acessar as informações do usuário na sessão, por exemplo:
        $nome_usuario = $_SESSION['nome'];
        // Agora você pode exibir o nome do usuário na página index.php
        $mensagem_boas_vindas = "Olá, $nome_usuario! Bem-vindo de volta!";
        $texto_botao_sair = "Sair";
        // Exibir o botão de logout se o usuário estiver conectado
        $botao_logout = '<a href="logout.php"><button class="logout-button">'.$texto_botao_sair.'</button></a>';
        // Não exibir o botão de login se o usuário estiver conectado
        $botao_login = '';
    } else {
        // O usuário não está conectado, exibir uma mensagem de boas-vindas genérica
        $mensagem_boas_vindas = "Bem-vindo à Olgas - Cafeteria Gourmet Delivery!";
        // Exibir o botão de login se o usuário não estiver conectado
        $botao_login = '<a href="login.php"><button class="login-button">Login</button></a>';
        // Não exibir o botão de logout se o usuário não estiver conectado
        $botao_logout = '';
    }
    ?>

    <header>
        <nav>
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="cardapio.php">Cardápio</a></li>
                <li><a href="sobre_nos.php">Sobre Nós</a></li>
                <li><a href="contato.php">Contato</a></li>
                <li><a href="order_history.php">Histórico de Pedidos</a></li>
            </ul>
            <?php echo $botao_logout; ?>
            <?php echo $botao_login; ?>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1><?php echo $mensagem_boas_vindas; ?></h1>
            <p>Por que escolher a Olgas?</p>
            <a href="cardapio.php" class="cta-button">Ver Cardápio</a>
        </section>
        <section class="features">
            <h2>Nossas Características</h2>
            <div class="feature">
                <img src="images/feature1.jpg" alt="Feature 1">
                <h3>Variedade de Café</h3>
                <p>Oferecemos uma ampla seleção de cafés, desde os tradicionais até os mais exóticos, para agradar a todos os paladares.</p>
            </div>
            <div class="feature">
                <img src="images/feature2.jpg" alt="Feature 2">
                <h3>Ambiente Acolhedor</h3>
                <p>Nosso ambiente foi cuidadosamente projetado para proporcionar conforto e relaxamento aos nossos clientes enquanto desfrutam de seu café.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; Site ficticio para o Projeto Integrador Transdisciplinar em Sistemas de Informação II da faculdade cruzeiro do sul cuja cafeteria gourmet tem o nome de "Olgas".</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
