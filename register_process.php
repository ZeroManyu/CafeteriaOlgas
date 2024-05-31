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

// Obter os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$endereco = $_POST['endereco'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];

// Verificar se as senhas coincidem
if ($senha !== $confirmar_senha) {
    header("Location: register.php?error=registration_failed");
    exit();
}

// Verificar se o email já está registrado
$sql = "SELECT id_cliente FROM clientes WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Email já registrado
    header("Location: register.php?error=registration_failed");
    exit();
}

// Inserir o novo cliente no banco de dados
$sql = "INSERT INTO clientes (nome, endereco, telefone, email, senha) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$hashed_password = password_hash($senha, PASSWORD_DEFAULT); // Criptografar a senha
$stmt->bind_param("sssss", $nome, $endereco, $telefone, $email, $hashed_password);

if ($stmt->execute()) {
    // Registro bem-sucedido
    $_SESSION['loggedin'] = true;
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;
    header("Location: index.php");
} else {
    // Falha no registro
    header("Location: register.php?error=registration_failed");
}

$stmt->close();
$conn->close();
?>
