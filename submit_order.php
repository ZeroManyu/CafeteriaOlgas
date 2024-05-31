<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity1 = $_POST['quantity1'];
    $quantity2 = $_POST['quantity2'];
    $quantity3 = $_POST['quantity3'];

    // Processar os dados do pedido
    echo "Pedido recebido:<br>";
    echo "Café Gourmet 1: $quantity1 unidades<br>";
    echo "Café Gourmet 2: $quantity2 unidades<br>";
    echo "Café Gourmet 3: $quantity3 unidades<br>";
}
?>
