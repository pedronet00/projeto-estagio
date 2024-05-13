<?php 

    // Obter o caminho absoluto para o arquivo conn.php
    $connPath = __DIR__ . '/../../../config/conn.php';

    // Incluir o arquivo conn.php usando o caminho absoluto
    include_once($connPath);

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
