<?php 

require('../../config/conn.php');

$tipoPost = $_POST['tipoPost'];
$erros = 0;

try{
    if($tipoPost == ""){
        throw new Exception("O campo Tipo do Post não pode estar vazio!");
    }
    
    if(strlen($tipoPost) < 5){
        throw new Exception("O Tipo do Post deve possuir mais do que 5 caracteres!");
    }

    function inserirBanco($conexao, $tipoPost){
        try{
            $sql = "INSERT INTO tipoPost(nome_tipoPost) VALUES (:tipoPost)";
            $stmt = $conexao->prepare($sql);
    
            $stmt->bindParam(':tipoPost', $tipoPost);
    
            $stmt->execute();
    
            echo "Inserido com sucesso!";
        } catch(PDOException $e){
            echo "Erro ao inserir registro: " . $e->getMessage();
        }
    }
} catch(Exception $e){
    $e->getMessage();
}

inserirBanco($conexao, $tipoPost);

?>
