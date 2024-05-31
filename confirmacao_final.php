<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação Final - Olgas</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f3f3;
        }

        header {
            background-color: #f04e31; /* Alterado para laranja */
            color: #fff;
            padding: 10px 0;
        }

        nav ul {
            list-style: none;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        .login-btn {
            float: right;
            margin-right: 20px;
        }

        .logout-button, .login-button {
            padding: 5px 10px;
            border: none;
            background-color: #fff; /* Alterado para branco */
            color: #f04e31; /* Alterado para laranja */
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
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
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
            header {
                padding: 10px;
            }

            nav ul li {
                display: block;
                margin: 10px 0;
            }

            .login-btn {
                float: none;
                margin-right: 0;
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
            <h1>Confirmação Final</h1>
            <h2>Resumo do Pedido:</h2>
            <?php
            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                echo "<p>Por favor, faça o <a href='login.php'>login</a> para visualizar a confirmação do pedido.</p>";
                exit;
            }

            $total = $_POST['total'];
            $deliveryMethod = $_POST['deliveryMethod'];
            $paymentMethod = $_POST['paymentMethod'];
            $id_cliente = $_SESSION['id_cliente'];

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "olgas";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Erro de conexão: " . $conn->connect_error);
            }

            // Inserir o pedido na tabela 'pedidos'
            $data_pedido = date('Y-m-d H:i:s');
            $sql_pedido = "INSERT INTO pedidos (id_cliente, data_pedido, status_pedido, forma_pagamento) VALUES ($id_cliente, '$data_pedido', 'Recebido', '$paymentMethod')";
            
            if ($conn->query($sql_pedido) === TRUE) {
                $id_pedido = $conn->insert_id;

                // Inserir itens do pedido na tabela 'itens_pedido'
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'quantity') === 0 && $value > 0) {
                        $id_produto = str_replace('quantity', '', $key);
                        $sql_produto = "SELECT preco FROM produtos WHERE id_produto = $id_produto";
                        $result = $conn->query($sql_produto);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $preco_unitario = $row["preco"];
                            $sql_item_pedido = "INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES ($id_pedido, $id_produto, $value, $preco_unitario)";
                            $conn->query($sql_item_pedido);
                        }
                    }
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
                            echo "<li>" . $row["nome_produto"] . ": " . $value . " x R$ " . number_format($row["preco"], 2) . " = R$ " . number_format($subtotal, 2) . "</li>";
                        }
                    }
                }
                echo "</ul>";

                if($deliveryMethod === 'entrega') {
                    echo "<p>Taxa de Entrega: R$ 10,00</p>";
                }

                echo "<p><strong>Total a Pagar: R$ " . number_format($total, 2) . "</strong></p>";

                echo "<h2>Local de Recebimento:</h2>";
                if($deliveryMethod === 'loja') {
                    echo "<p>O pedido será retirado na loja.</p>";
                } elseif($deliveryMethod === 'entrega') {
                    $sql = "SELECT endereco FROM clientes WHERE id_cliente = $id_cliente";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<p>Endereço de Entrega: " . $row["endereco"] . "</p>";
                    } else {
                        echo "Nenhum endereço encontrado.";
                    }
                }

                echo "<h2>Método de Pagamento:</h2>";
                if($paymentMethod === 'pix') {
                    echo "<p>Pagamento via Pix</p>";
                } elseif($paymentMethod === 'entrega') {
                    echo "<p>Pagamento na Entrega</p>";
                }

                echo "<p>Obrigado por fazer seu pedido!</p>";
                echo "<p>Você receberá em breve um email de confirmação com os detalhes do seu pedido.</p>";
            } else {
                echo "Erro ao registrar o pedido: " . $conn->error;
            }

            $conn->close();
            ?>
            <p><a href="index.php">Voltar para a página inicial</a></p>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>
