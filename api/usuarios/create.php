<?php require('../../config/conn.php'); ?>

<?php 

    $nomeUsuario = $_POST['nomeUsuario'];
    $emailUsuario = $_POST['emailUsuario'];
    $senhaUsuario = password_hash($_POST['senhaUsuario'], PASSWORD_DEFAULT);
    $dataNascimentoUsuario = $_POST['dataNascimentoUsuario'];
    $nivelUsuario = $_POST['nivelUsuario'];
    $fotoPerfilUsuario = '';

    function inserirUsuario($conexao, $nomeUsuario, $emailUsuario, $senhaUsuario, $dataNascimentoUsuario, $nivelUsuario){

        try {

            $diretorio = '../../src/img/imagens-blog/';
            if (isset($_FILES['fotoPerfilUsuario'])) {


                // Nome original do arquivo enviado
                $nomeArquivo = $_FILES['fotoPerfilUsuario']['name'];
                // Caminho temporário do arquivo no servidor
                $caminhoTemporario = $_FILES['fotoPerfilUsuario']['tmp_name'];

                // Verifica se é uma imagem
                $extensoesPermitidas = array('jpg', 'jpeg', 'png');
                $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
                if (!in_array($extensao, $extensoesPermitidas)) {
                    throw new Exception("Apenas arquivos de imagem são permitidos (jpg, jpeg, png)!");
                }

                // Move o arquivo do local temporário para o diretório de imagens
                if (move_uploaded_file($caminhoTemporario, $diretorio . $nomeArquivo)) {
                    // Arquivo movido com sucesso, agora você pode salvar o caminho no banco de dados
                    $imgUsuario = $diretorio . $nomeArquivo;
                }
            } else{
                die("nenhuma imagem veio do POST");
            }

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
            
                    $stmt->execute();
            
                    echo "Usuário inserido com sucesso!";
                
        } catch(PDOException $e) {
            echo "Erro ao inserir registro: " . $e->getMessage();
        }
    }

    inserirUsuario($conexao, $nomeUsuario, $emailUsuario, $senhaUsuario, $dataNascimentoUsuario, $nivelUsuario);

?>