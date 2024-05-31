<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];

   
    echo "Obrigado pelo seu feedback, $nome!<br>";
    echo "Nós entraremos em contato com você em breve no endereço de email: $email.<br>";
    echo "Sua mensagem: $mensagem<br>";
}
?>
