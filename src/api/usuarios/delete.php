<?php 

    // Obter o caminho absoluto para o arquivo conn.php
    $connPath = __DIR__ . '/../../../config/conn.php';

    // Incluir o arquivo conn.php usando o caminho absoluto
    include_once($connPath);

    if(!isset($_POST['idUsuario'])){
        throw new Exception("Id do usuário não foi recebido na requisição");
    }

    $id = "";

    if(isset($_POST['idUsuario'])){
        $id = $_POST['idUsuario'];
    } elseif(isset($_POST['idPastor'])){
        $id = $_POST['idPastor'];
    }
    $nivelUsuario = $_POST['nivelUsuario'];

    function excluirUsuario($conexao, $id, $nivelUsuario) {
        if ($nivelUsuario == 2) {
            $sql = "UPDATE pastor SET usuarioAtivo = 0 WHERE idPastor = :idUsuario";
        } else {
            $sql = "UPDATE usuario SET usuarioAtivo = 0 WHERE idUsuario = :idUsuario";
        }
    
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':idUsuario', $id);
        $stmt->execute();
    }
    

    excluirUsuario($conexao, $id, $nivelUsuario);
?>
