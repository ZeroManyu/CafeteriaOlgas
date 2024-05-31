<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Pedidos - Olgas</title>
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

        .order-history {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        .order-history h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f04e31; /* Cor laranja */
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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
                <li><a href="logout.php">Sair</a></li> <!-- Botão Sair -->
            </ul>
        </nav>
    </header>
    <main>
        <section class="order-history">
            <h1>Histórico de Pedidos</h1>
            <?php
            // Iniciar sessão
            session_start();

            // Conexão com o banco de dados
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "olgas";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar a conexão
            if ($conn->connect_error) {
                die("Erro de conexão: " . $conn->connect_error);
            }

            // Verificar se o usuário está conectado
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                $userId = $_SESSION['id_cliente'];

                // Consulta SQL para selecionar os pedidos do cliente atual
                $sql = "SELECT p.data_pedido, i.id_produto, i.quantidade, i.preco_unitario FROM pedidos p INNER JOIN itens_pedido i ON p.id_pedido = i.id_pedido WHERE p.id_cliente = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Verificar se há pedidos no histórico
                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Data do Pedido</th><th>Produto</th><th>Quantidade</th><th>Valor Total</th></tr>";
                    while($row = $result->fetch_assoc()) {
                        // Consulta SQL para obter o nome do produto
                        $productSql = "SELECT nome_produto FROM produtos WHERE id_produto = ?";
                        $productStmt = $conn->prepare($productSql);
                        $productStmt->bind_param("i", $row['id_produto']);
                        $productStmt->execute();
                        $productName = $productStmt->get_result()->fetch_assoc()['nome_produto'];

                        // Calcular o valor total do item
                        $totalPrice = $row['quantidade'] * $row['preco_unitario'];

                        // Exibir os detalhes do pedido
                        echo "<tr>";
                        echo "<td>" . $row['data_pedido'] . "</td>";
                        echo "<td>" . $productName . "</td>";
                        echo "<td>" . $row['quantidade'] . "</td>";
                        echo "<td>R$ " . number_format($totalPrice, 2) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Nenhum pedido encontrado.</p>";
                }

                $stmt->close();
            } else {
                // Se o usuário não estiver conectado, redirecionar para a página de login
                header("Location: login.php");
                exit();
            }

            // Fechar a conexão
            $conn->close();
            ?>
        </section>
    </main>
</body>
</html>
