<?php
session_start();
// Destruir todas as variáveis de sessão
$_SESSION = array();

// Se desejar encerrar a sessão, apagar também o cookie de sessão.
// Nota: Isto destruirá a sessão, e não apenas os dados da sessão!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir a sessão
session_destroy();

// Redirecionar de volta para a página de login
header("Location: login.php");
exit();
?>