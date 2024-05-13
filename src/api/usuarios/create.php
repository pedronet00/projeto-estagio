<?php 

    // Obter o caminho absoluto para o arquivo conn.php
    $connPath = __DIR__ . '/../../../config/conn.php';

    // Incluir o arquivo conn.php usando o caminho absoluto
    include_once($connPath); ?>

<?php 

    $nomeUsuario = $_POST['nomeUsuario'];
    $emailUsuario = $_POST['emailUsuario'];
    $senhaUsuario = password_hash($_POST['senhaUsuario'], PASSWORD_DEFAULT);
    $dataNascimentoUsuario = $_POST['dataNascimentoUsuario'];
    $nivelUsuario = $_POST['nivelUsuario'];
    $fotoPerfilUsuario = '';
    
    // Verifica se o e-mail já existe na tabela usuario
    $stmt_verificar_email = $conexao->prepare("SELECT COUNT(*) FROM usuario WHERE emailUsuario = :emailUsuario");
    $stmt_verificar_email->bindParam(':emailUsuario', $emailUsuario);
    $stmt_verificar_email->execute();
    $num_linhas = $stmt_verificar_email->fetchColumn();

    if ($num_linhas > 0) {
        throw new Exception("Este e-mail já está cadastrado. Por favor, use outro e-mail.");
    }

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

    if (strlen($_POST['senhaUsuario']) < 8) {
        throw new Exception("A senha deve ter pelo menos 8 caracteres!");
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dataNascimentoUsuario)) {
        throw new Exception("Formato inválido para a data de nascimento. Use o formato YYYY-MM-DD.");
    }

    $niveisValidos = [1, 2, 3, 4, 5];
    if (!in_array($nivelUsuario, $niveisValidos)) {
        throw new Exception("Nível de usuário inválido!");
    }

    function inserirUsuario($conexao, $nomeUsuario, $emailUsuario, $senhaUsuario, $dataNascimentoUsuario, $nivelUsuario){

        try {

            $diretorio = '../../public/assets/img/imagens-usuarios/';
            if (isset($_FILES['fotoPerfilUsuario'])) {

                $nomeArquivo = $_FILES['fotoPerfilUsuario']['name'];
                $caminhoTemporario = $_FILES['fotoPerfilUsuario']['tmp_name'];
                $extensoesPermitidas = array('jpg', 'jpeg', 'png');
                $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

                if (!in_array($extensao, $extensoesPermitidas)) {
                    throw new Exception("Apenas arquivos de imagem são permitidos (jpg, jpeg, png)!");
                }

                if (move_uploaded_file($caminhoTemporario, $diretorio . $nomeArquivo)) {
                    $imgUsuario = $diretorio . $nomeArquivo;
                }
            } else{
                die("nenhuma imagem veio do POST");
            }

                if($nivelUsuario == 2){ // É pastor
                    $sql = "INSERT INTO pastor(nomePastor, emailPastor, senhaPastor, nivelUsuario, imgPastor, dataNascimentoPastor, usuarioAtivo) VALUES (:nomeUsuario, :emailUsuario, :senhaUsuario, :nivelUsuario, :imgUsuario, :dataNascimentoUsuario, :usuarioAtivo)";

                    $stmt = $conexao->prepare($sql);
            
                    $usuarioAtivo = true;
                    $stmt->bindParam(':nomeUsuario', $nomeUsuario);
                    $stmt->bindParam(':emailUsuario', $emailUsuario);
                    $stmt->bindParam(':senhaUsuario', $senhaUsuario);
                    $stmt->bindParam(':nivelUsuario', $nivelUsuario);
                    $stmt->bindParam(':imgUsuario', $imgUsuario);
                    $stmt->bindParam(':dataNascimentoUsuario', $dataNascimentoUsuario);
                    $stmt->bindParam(':usuarioAtivo', $usuarioAtivo);
                } else{
                    $sql = "INSERT INTO usuario(nomeUsuario, emailUsuario, senhaUsuario, nivelUsuario, imgUsuario, dataNascimentoUsuario, usuarioAtivo) VALUES (:nomeUsuario, :emailUsuario, :senhaUsuario, :nivelUsuario, :imgUsuario, :dataNascimentoUsuario, :usuarioAtivo)";

                    $stmt = $conexao->prepare($sql);
            
                    $usuarioAtivo = true;
                    $stmt->bindParam(':nomeUsuario', $nomeUsuario);
                    $stmt->bindParam(':emailUsuario', $emailUsuario);
                    $stmt->bindParam(':senhaUsuario', $senhaUsuario);
                    $stmt->bindParam(':nivelUsuario', $nivelUsuario);
                    $stmt->bindParam(':imgUsuario', $imgUsuario);
                    $stmt->bindParam(':dataNascimentoUsuario', $dataNascimentoUsuario);
                    $stmt->bindParam(':usuarioAtivo', $usuarioAtivo);
                }

                    $stmt->execute();
            
                    echo "Usuário inserido com sucesso!";
                    
                
        } catch(PDOException $e) {
            echo "Erro ao inserir registro: " . $e->getMessage();
        }
    }

    inserirUsuario($conexao, $nomeUsuario, $emailUsuario, $senhaUsuario, $dataNascimentoUsuario, $nivelUsuario);

?>