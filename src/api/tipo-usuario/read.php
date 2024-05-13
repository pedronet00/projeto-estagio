<?php 

    // Obter o caminho absoluto para o arquivo conn.php
    $connPath = __DIR__ . '/../../../config/conn.php';

    // Incluir o arquivo conn.php usando o caminho absoluto
    include_once($connPath);?>

<?php 

    function retornarTodosTiposUsuario($conexao){

        $sql = "SELECT * FROM nivelusuario";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt;
    }





?>