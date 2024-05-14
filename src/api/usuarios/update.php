<?php 

    // Obter o caminho absoluto para o arquivo conn.php
    $connPath = __DIR__ . '/../../../config/conn.php';

    // Incluir o arquivo conn.php usando o caminho absoluto
    include_once($connPath); ?>

<?php 

    $idUsuario = $_POST['idUsuario'];
    $nomeUsuario = $_POST['nomeUsuario'];
    $emailUsuario = $_POST['emailUsuario'];
    $dataNascimentoUsuario = $_POST['dataNascimentoUsuario'];
    $nivelUsuario = $_POST['nivelUsuario'];
    
    if(strlen($nomeUsuario) <= 2){
        throw new Exception("O nome do usuário deve ter mais do que 2 caracteres!");
    }

    if($dataNascimentoUsuario > date('Y-m-d')){
        throw new Exception("A data de nascimento não pode ser maior do que a de hoje!");
    }

    if(!preg_match('/^[a-zA-Z\s]+$/', $nomeUsuario)) {
        throw new Exception("O nome do usuário não pode conter caracteres especiais!");
    }

    if (!filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("O e-mail fornecido não é válido!");
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dataNascimentoUsuario)) {
        throw new Exception("Formato inválido para a data de nascimento. Use o formato YYYY-MM-DD.");
    }

    $niveisValidos = [1, 2, 3, 4, 5];
    if (!in_array($nivelUsuario, $niveisValidos)) {
        throw new Exception("Nível de usuário inválido!");
    }

    function atualizarUsuario($conexao, $idUsuario, $nomeUsuario, $emailUsuario, $dataNascimentoUsuario, $nivelUsuario){

        try {
                if($nivelUsuario == 2){ // É pastor
                    $sql = "UPDATE pastor SET 
                    nomePastor = :nomeUsuario, 
                    emailPastor = :emailUsuario,
                    nivelUsuario =:nivelUsuario,
                    dataNascimentoPastor = :dataNascimentoUsuario, 
                    usuarioAtivo = :usuarioAtivo
                    WHERE idPastor = :idUsuario";

                    $stmt = $conexao->prepare($sql);
            
                    $usuarioAtivo = true;
                    $stmt->bindParam(':idUsuario', $idUsuario);
                    $stmt->bindParam(':nomeUsuario', $nomeUsuario);
                    $stmt->bindParam(':emailUsuario', $emailUsuario);
                    $stmt->bindParam(':nivelUsuario', $nivelUsuario);
                    $stmt->bindParam(':dataNascimentoUsuario', $dataNascimentoUsuario);
                    $stmt->bindParam(':usuarioAtivo', $usuarioAtivo);
                } else{
                    $sql = "UPDATE usuario SET 
                    nomeUsuario = :nomeUsuario, 
                    emailUsuario = :emailUsuario,
                    nivelUsuario =:nivelUsuario,
                    dataNascimentoUsuario = :dataNascimentoUsuario, 
                    usuarioAtivo = :usuarioAtivo
                    WHERE idUsuario = :idUsuario";

                    $stmt = $conexao->prepare($sql);
            
                    $usuarioAtivo = true;
                    $stmt->bindParam(':idUsuario', $idUsuario);
                    $stmt->bindParam(':nomeUsuario', $nomeUsuario);
                    $stmt->bindParam(':emailUsuario', $emailUsuario);
                    $stmt->bindParam(':nivelUsuario', $nivelUsuario);
                    $stmt->bindParam(':dataNascimentoUsuario', $dataNascimentoUsuario);
                    $stmt->bindParam(':usuarioAtivo', $usuarioAtivo);
                }

                    $stmt->execute();
            
                    echo "Usuário alterado com sucesso!";
                    
                
        } catch(PDOException $e) {
            echo "Erro ao alterar registro: " . $e->getMessage();
        }
    }

    atualizarUsuario($conexao, $idUsuario, $nomeUsuario, $emailUsuario, $dataNascimentoUsuario, $nivelUsuario);

?>