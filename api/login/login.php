<?php
require('../../config/conn.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

function validaLogin($conexao, $email, $senha){
    // Evite injeção de SQL
    $email = htmlspecialchars($email);

    $sql = "SELECT * FROM usuario WHERE emailUsuario = :email LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
       
        if (password_verify($senha, $result['senhaUsuario'])) {
            
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['nomeUsuario'] = $result['nomeUsuario']; 
            header("Location: ../../index.php"); 
            exit();
        } else {
            throw new Exception("Senha incorreta!");
        }
    } else {
        throw new Exception("Usuário não encontrado!");
    }
}

try {
    validaLogin($conexao, $email, $senha);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>
