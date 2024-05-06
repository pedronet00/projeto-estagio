<?php
// Configurações do banco de dados
$servidor = "localhost"; // ou o endereço do seu servidor MySQL
$banco = "estagio";
$usuario = "root";
$senha = "010403";

try {
    // Cria uma nova conexão PDO
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    
    // Configura o modo de erros para exceções
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
