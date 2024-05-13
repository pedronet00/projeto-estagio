<?php 

    // Obter o caminho absoluto para o arquivo conn.php
    $connPath = __DIR__ . '/../../../config/conn.php';

    // Incluir o arquivo conn.php usando o caminho absoluto
    include_once($connPath); ?>


<?php 

    function retornarTodosUsuarios($conexao){
        $query = "SELECT usuario.*, nivelusuario.idnivelUsuario, nivelusuario.nivelUsuario as nomeNivelUsuario 
        FROM usuario 
        LEFT JOIN nivelusuario ON usuario.nivelUsuario = nivelusuario.idnivelUsuario 
        ORDER BY usuario.nomeUsuario ASC;";
        $stmt = $conexao->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function retornarTodosPastores($conexao){
        $query = "SELECT pastor.*, nivelusuario.idnivelUsuario, nivelusuario.nivelUsuario as nomeNivelUsuario 
        FROM pastor 
        LEFT JOIN nivelusuario ON pastor.nivelUsuario = nivelusuario.idnivelUsuario 
        ORDER BY pastor.nomePastor ASC;";
        $stmt = $conexao->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function retornarUsuarioPorId($conexao, $idUsuario){
        $query = "SELECT usuario.*, nivelusuario.idnivelUsuario, nivelusuario.nivelUsuario AS nomeNivelUsuario 
        FROM usuario 
        LEFT JOIN nivelusuario ON usuario.nivelUsuario = nivelusuario.idnivelUsuario
        WHERE idUsuario = :idUsuario 
        ORDER BY usuario.nomeUsuario ASC;";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(":idUsuario", $idUsuario);
        $stmt->execute();

        return $stmt;
    }



?>