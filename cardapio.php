<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio - Olgas</title>
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

        .login-btn {
            float: right;
            margin-top: 10px;
        }

        .login-button,
        .logout-button {
            background-color: #ff6347;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .login-button:hover,
        .logout-button:hover {
            background-color: #ff4836;
        }

        .menu {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

        .menu h1 {
            text-align: center;
            margin-top: 0;
        }

        .menu-item {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 20px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .menu-item:hover {
            transform: translateY(-5px);
        }

        .menu-item img {
            float: left;
            margin-right: 20px;
            max-width: 150px;
            border-radius: 5px;
        }

        .menu-item h2 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .menu-item p {
            margin-bottom: 10px;
        }

        .menu-item label {
            display: block;
            margin-bottom: 5px;
        }

        .menu-item input[type="number"] {
            width: 60px;
        }

        .delivery-method {
            margin-top: 20px;
        }

        .delivery-method input {
            margin-right: 10px;
        }

        .error {
            color: red;
            display: none;
        }

        button[type="submit"] {
            background-color: #ff6347;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #ff4836;
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
                // Iniciar sessão
                session_start();

                // Verificar se o usuário está conectado
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
                    // O usuário está conectado. Você pode exibir o botão de logout
                    echo '<a href="logout.php"><button class="logout-button">Sair</button></a>';
                } else {
                    // O usuário não está conectado. Você pode exibir o botão de login
                    echo '<a href="login.php"><button class="login-button">Login</button></a>';
                }
                ?>
            </div>
        </nav>
    </header>
    <main>
        <section class="menu">
            <h1>Cardápio</h1>
            <form id="orderForm" action="confirmacao_pedido.php" method="post" onsubmit="return validateForm()"> <!-- Adicionando formulário -->
            <?php
            // Conexão com o banco de dados
            $servername = "localhost";
            $username = "root"; // Usuário padrão do MySQL no XAMPP
            $password = ""; // Senha padrão vazia do MySQL no XAMPP
            $dbname = "olgas";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar a conexão
            if ($conn->connect_error) {
                die("Erro de conexão: " . $conn->connect_error);
            }

            // Consulta SQL para selecionar todos os produtos
            $sql = "SELECT id_produto, nome_produto, preco FROM produtos";
            $result = $conn->query($sql);

            // Verificar se há produtos no banco de dados
            if ($result->num_rows > 0) {
                // Loop através dos resultados da consulta
                while($row = $result->fetch_assoc()) {
                    echo '<div class="menu-item">';
                    echo '<img src="images/' . strtolower($row["nome_produto"]) . '.jpg" alt="' . $row["nome_produto"] . '">';
                    echo '<h2>' . $row["nome_produto"] . '</h2>';
                    echo '<p>R$ ' . number_format($row["preco"], 2) . '</p>';
                    echo '<label><input type="checkbox" name="product[]" value="' . $row["id_produto"] . '" onchange="toggleQuantity(this)"> Selecionar</label>';
                    echo '<label for="quantity' . $row["id_produto"] . '">
Quantidade:</label>';
                    echo '<input type="number" id="quantity' . $row["id_produto"] . '" name="quantity' . $row["id_produto"] . '" value="1" min="1">';
                    echo '</div>';
                }
            } else {
                echo "Nenhum produto encontrado.";
            }

            // Fechar a conexão
            $conn->close();
            ?>
            <div class="delivery-method">
                <input type="radio" id="entrega" name="deliveryMethod" value="entrega">
                <label for="entrega">Entrega</label>
                <input type="radio" id="loja" name="deliveryMethod" value="loja">
                <label for="loja">Retirar na Loja</label>
                <p class="error" id="deliveryError">Por favor, selecione uma opção de entrega.</p>
            </div>
            <p class="error" id="productError">Por favor, selecione pelo menos um produto.</p>
            <button type="submit" id="orderBtn">Enviar Pedido</button>
            </form> <!-- Fechando o formulário -->
        </section>
    </main>

    <script>
        function toggleQuantity(checkbox) {
            const quantityInput = checkbox.closest('.menu-item').querySelector('input[type="number"]');
            if (checkbox.checked) {
                quantityInput.style.display = 'inline-block';
            } else {
                quantityInput.style.display = 'none';
                quantityInput.value = 1; // Resetar a quantidade para 1 quando desmarcado
            }
        }

        function validateForm() {
            const deliveryMethod = document.querySelector('input[name="deliveryMethod"]:checked');
            const deliveryError = document.getElementById('deliveryError');
            const productCheckboxes = document.querySelectorAll('input[name="product[]"]:checked');
            const productError = document.getElementById('productError');

            let isValid = true;

            // Verificar se uma opção de método de entrega foi selecionada
            if (!deliveryMethod) {
                deliveryError.style.display = 'block';
                isValid = false;
            } else {
                deliveryError.style.display = 'none';
            }

            // Verificar se pelo menos um produto foi selecionado
            if (productCheckboxes.length === 0) {
                productError.style.display = 'block';
                isValid = false;
            } else {
                productError.style.display = 'none';
            }

            return isValid;
        }

        // Remover inputs não selecionados antes de enviar o formulário
        document.getElementById('orderForm').addEventListener('submit', function(event) {
            const checkboxes = document.querySelectorAll('input[name="product[]"]');
            checkboxes.forEach(function(checkbox) {
                if (!checkbox.checked) {
                    const quantityInput = checkbox.closest('.menu-item').querySelector('input[type="number"]');
                    quantityInput.disabled = true; // Desabilitar inputs não selecionados para não serem enviados
                }
            });
        });
    </script>
</body>
</html>
