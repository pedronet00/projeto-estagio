<?php 

    require('../../../config/conn.php');

    function retornarPostPorId($conexao, $id){

        $query = "SELECT * FROM post WHERE idPost = :idPost";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':idPost', $id);
        $stmt->execute();

        return $stmt;
    }


?>