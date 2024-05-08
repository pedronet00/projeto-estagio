<?php require('../../config/conn.php'); ?>


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





?>