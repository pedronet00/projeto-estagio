<?php 
    require('../../config/conn.php');

    if(!isset($_POST['idPost'])){
        throw new Exception("Id do post não foi recebido na requisição");
    }

    $idPost = $_POST['idPost'];


    function excluirPost($conexao, $idPost) {
            
        $sql = "DELETE FROM post WHERE idPost = :idPost";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':idPost', $idPost);
        $stmt->execute();
    }
    

    excluirPost($conexao, $idPost);
?>
