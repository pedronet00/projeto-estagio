<?php 

    // Obter o caminho absoluto para o arquivo conn.php
    $connPath = __DIR__ . '/../../../config/conn.php';

    // Incluir o arquivo conn.php usando o caminho absoluto
    include_once($connPath);

    function listarTodosTiposPost($conexao){

        $sql = "SELECT * FROM tipopost";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

?>
