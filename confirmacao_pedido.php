<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Pedido - Olgas</title>
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

        nav {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        .login-btn {
            margin-left: auto;
        }

        .logout-button, .login-button {
            padding: 5px 10px;
            border: none;
            background-color: #f04e31;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }

        main {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .confirmation {
            text-align: center;
            padding: 20px;
        }

        .confirmation h1, .confirmation h2 {
            margin-bottom: 20px;
        }

        .confirmation ul {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .confirmation ul li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .confirmation p {
            margin-bottom: 20px;
        }

        .confirmation button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f04e31;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .confirmation button:hover {
            background-color: #d03e28;
        }

        @media screen and (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }

            .login-btn {
                margin-left: 0;
                margin-top: 10px;
            }

            main {
                padding: 10px;
            }

            .confirmation ul li {
                padding: 5px;
            }
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
            <div class="login-btn">
                <?php
                session_start();
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                    echo '<a href="logout.php"><button class="logout-button">Sair</button></a>';
                } else {
                    echo '<a href="login.php"><button class="login-button">Login</button></a>';
                }
                ?>
            </div>
        </nav>
    </header>
    <main>
        <section class="confirmation">
            <h1>Confirmação de Pedido</h1>
            <h2>Produtos Selecionados:</h2>
            <?php
            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                echo "<p>Por favor, faça o <a href='login.php'>login</a> para confirmar seu pedido.</p>";
                exit;
            }

            $total = 0;
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "olgas";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Erro de conexão: " . $conn->connect_error);
            }

            echo "<ul>";
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'quantity') === 0 && $value > 0) {
                    $id_produto = str_replace('quantity', '', $key);
                    $sql = "SELECT nome_produto, preco FROM produtos WHERE id_produto = $id_produto";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $subtotal = $row["preco"] * $value;
                        $total += $subtotal;
                        echo "<li>" . $row["nome_produto"] . ": " . $value . " x R$ " . number_format($row["preco"], 2) . " = R$ " . number_format($subtotal, 2) . "</li>";
                    }
                }
            }
            echo "</ul>";

            if(isset($_POST['deliveryMethod']) && $_POST['deliveryMethod'] === 'entrega') {
                $total += 10.00;
                echo "<p>Taxa de Entrega: R$ 10,00</p>";
            }

            echo "<p><strong>Total a Pagar: R$ " . number_format($total, 2) . "</strong></p>";
            ?>
            <h2>Local de Recebimento:</h2>
            <?php
            if(isset($_POST['deliveryMethod'])) {
                if($_POST['deliveryMethod'] === 'loja') {
                    echo "<p>O pedido será retirado na loja.</p>";
                } elseif($_POST['deliveryMethod'] === 'entrega') {
                    if(isset($_SESSION['id_cliente'])) {
                        $id_cliente = $_SESSION['id_cliente'];
                        $sql = "SELECT endereco FROM clientes WHERE id_cliente = $id_cliente";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo "<p>Endereço de Entrega: " . $row["endereco"] . "</p>";
                        } else {
                            echo "Nenhum endereço encontrado.";
                        }
                    } else {
                        echo "Nenhum cliente conectado.";
                    }
                }
            }
            ?>
            <h2>Método de Pagamento:</h2>
            <form action="confirmacao_final.php" method="post">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <input type="hidden" name="deliveryMethod" value="<?php echo $_POST['deliveryMethod']; ?>">
                <?php foreach ($_POST as $key => $value) {
                    if (strpos($key, 'quantity') === 0) {
                        echo '<input type="hidden" name="'. $key .'" value="'. $value .'">';
                    }
                } ?>
                <label>
                    <input type="radio" name="paymentMethod" value="pix" required> Pix
                </label>
                <label>
                    <input type="radio" name="paymentMethod" value="entrega" required> Pagamento na Entrega
                </label>
                <button type="submit">Confirmar Pedido</button>
            </form>
        </section>
    </main>
</body>
</html>
