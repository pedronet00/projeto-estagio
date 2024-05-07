<?php require('../../config/conn.php'); ?>

<?php 

    function retornarTodosTiposUsuario($conexao){

        $sql = "SELECT * FROM nivelusuario";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt;
    }





?>