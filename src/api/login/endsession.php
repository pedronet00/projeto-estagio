<?php
// Iniciar a sessão se não estiver iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Encerrar a sessão
session_unset(); // Limpar todas as variáveis de sessão
session_destroy(); // Destruir a sessão

// Redirecionar para a página de login após encerrar a sessão
header("Location: /index.php");
exit();
?>
