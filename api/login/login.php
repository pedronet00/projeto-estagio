<?php
require('../../config/conn.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

function validaLogin($conexao, $email, $senha){
    // Evite injeção de SQL
    $email = htmlspecialchars($email);

    $sql = "SELECT usuario.*, nivelusuario.idnivelUsuario, nivelusuario.nivelUsuario as nomeNivelUsuario 
    FROM usuario 
    LEFT JOIN nivelusuario ON usuario.nivelUsuario = nivelusuario.idnivelUsuario WHERE emailUsuario = :email LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
       
        if (password_verify($senha, $result['senhaUsuario'])) {
            
            session_start();
            $_SESSION['nomeNivelUsuario'] = $result['nomeNivelUsuario']; 
            $_SESSION['nivelUsuario'] = $result['nivelUsuario']; 
            $_SESSION['email'] = $email;
            $_SESSION['nomeUsuario'] = $result['nomeUsuario']; 
            header("Location: /"); 
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
    // Login bem-sucedido
    $_SESSION['logged_in'] = true; // Define uma variável de sessão para indicar o login
    echo json_encode(array('success' => true));
} catch (Exception $e) {
    // Erro durante o login
    http_response_code(400); // Código de status 400 para erro de cliente
    echo json_encode(array('success' => false, 'message' => $e->getMessage()));
}

?>
