<?php
// Iniciar sessão
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Usuário padrão do MySQL no XAMPP
$password = ""; // Senha vazia por padrão no XAMPP
$dbname = "olgas";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verificar se os campos de email e senha foram enviados
if(isset($_POST['email']) && isset($_POST['senha'])) {
    // Prevenir injeção de SQL
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);

    // Consulta SQL para verificar se as credenciais estão corretas
    $sql = "SELECT id_cliente, nome FROM clientes WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login bem-sucedido
        $row = $result->fetch_assoc();

        // Armazenar informações do usuário na sessão
        $_SESSION['loggedin'] = true;
        $_SESSION['id_cliente'] = $row['id_cliente'];
        $_SESSION['nome'] = $row['nome'];

        // Redirecionar para a página principal
        header("Location: index.php");
        exit();
    } else {
        // Login falhou - Redireciona de volta para a página de login com uma mensagem de erro
        header("Location: login.php?error=login_failed");
        exit();
    }
} else {
    // Se os campos de email e senha não foram enviados, redirecione o usuário de volta para a página de login
    header("Location: login.php");
    exit();
}

$conn->close();
?>
