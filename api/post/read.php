<?php 

    require_once('../../config/conn.php');


    function retornarTodosPostsPorData($conexao){
        $query = "SELECT * FROM post ORDER BY dataPost DESC";
        $stmt = $conexao->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function retornarTodosPosts($conexao){
        $query = "SELECT * FROM post LEFT JOIN usuario ON post.autorPost = usuario.idUsuario";
        $stmt = $conexao->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function retornarPostPorId($conexao, $id){

        $query = "SELECT * FROM post LEFT JOIN tipopost ON post.tipoPost = tipopost.id_tipoPost  WHERE idPost = :idPost";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':idPost', $id);
        $stmt->execute();

        return $stmt;
    }



?>