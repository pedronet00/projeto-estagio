<?php require('../../config/conn.php'); ?>

<?php 

    function listarTodosTiposPost($conexao){

        $sql = "SELECT * FROM tipopost";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

?>