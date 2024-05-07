<?php 

    require('../../../config/conn.php');


    function retornarTodosPosts($conexao){
        $query = "SELECT * FROM post";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':idPost', $id);
        $stmt->execute();

        return $stmt;
    }

    function retornarPostPorId($conexao, $id){

        $query = "SELECT * FROM post WHERE idPost = :idPost";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':idPost', $id);
        $stmt->execute();

        return $stmt;
    }



?>