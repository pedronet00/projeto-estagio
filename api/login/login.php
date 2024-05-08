<?php
require('../../config/conn.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

function validaLogin($conexao, $email, $senha){
    $email = htmlspecialchars($email);
    $senha = htmlspecialchars($senha);

    $sql = "SELECT * FROM usuario WHERE emailUsuario = ? AND senhaUsuario = ? LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $row = $result->fetch_assoc();

        session_start();

        $_SESSION['nome'] = $row['nomeUsuario'];
        $_SESSION['email'] = $email;

        header("Location: index.php"); // Redirecionar para a página inicial
        exit();
    } else {
        throw new Exception("Usuário não encontrado!");
    }
}

try {
    validaLogin($conn, $email, $senha);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>
