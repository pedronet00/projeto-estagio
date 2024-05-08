<?php 
    require('../../config/conn.php');

    if(!isset($_POST['idUsuario'])){
        throw new Exception("Id do usuário não foi recebido na requisição");
    }

    $idUsuario = $_POST['idUsuario'];

    function excluirUsuario($conexao, $idUsuario){
        $sql = "DELETE FROM usuario WHERE idUsuario = :idUsuario";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
    }

    excluirUsuario($conexao, $idUsuario);
?>
