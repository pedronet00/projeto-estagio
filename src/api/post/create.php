<?php 

    // Obter o caminho absoluto para o arquivo conn.php
    $connPath = __DIR__ . '/../../../config/conn.php';

    // Incluir o arquivo conn.php usando o caminho absoluto
    include_once($connPath);
    

        function inserirBanco($conexao, $tituloPost, $subtituloPost, $tipoPost, $textoPost, $data) {

            $tituloPost = $_POST['tituloPost'];
            $subtituloPost = $_POST['subtituloPost'];
            $tipoPost = $_POST['tipoPost'];
            $textoPost = $_POST['textoPost'];
            $data = date('Y-m-d H:i:s');
            $imgPost = '';

            if (isset($_POST['textoPost']) && !empty($_POST['textoPost'])) {
                $textoPost = $_POST['textoPost'];
            } else {
                $textoPost = '';
            }
            
            try {
                if (empty($tipoPost)) {
                    throw new Exception("O campo Tipo do Post não pode estar vazio!");
                }
            
                try {

                    $diretorio = '../../public/assets/img/imagens-blog/';
                    if (isset($_FILES['imagemPost'])) {


                        // Nome original do arquivo enviado
                        $nomeArquivo = $_FILES['imagemPost']['name'];
                        // Caminho temporário do arquivo no servidor
                        $caminhoTemporario = $_FILES['imagemPost']['tmp_name'];

                        // Verifica se é uma imagem
                        $extensoesPermitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');
                        $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
                        if (!in_array($extensao, $extensoesPermitidas)) {
                            throw new Exception("Apenas arquivos de imagem são permitidos (jpg, jpeg, png, gif)!");
                        }

                        // Move o arquivo do local temporário para o diretório de imagens
                        if (move_uploaded_file($caminhoTemporario, $diretorio . $nomeArquivo)) {
                            // Arquivo movido com sucesso, agora você pode salvar o caminho no banco de dados
                            $imgPost = $diretorio . $nomeArquivo;
                        }
                    } else{
                        die("nenhuma imagem veio do POST");
                    }

                            $sql = "INSERT INTO post(tituloPost, subtituloPost, autorPost, dataPost, textoPost, imgPost, tipoPost) VALUES (:tituloPost, :subtituloPost, :autorPost, :dataPost, :textoPost, :imgPost, :tipoPost)";

                            $stmt = $conexao->prepare($sql);
                    
                            // Adicionei o parâmetro $autorPost como exemplo, você precisa ajustar conforme necessário
                            $autorPost = 1; // Exemplo de ID do autor
                            $stmt->bindParam(':tituloPost', $tituloPost);
                            $stmt->bindParam(':subtituloPost', $subtituloPost);
                            $stmt->bindParam(':autorPost', $autorPost);
                            $stmt->bindParam(':dataPost', $data);
                            $stmt->bindParam(':textoPost', $textoPost);
                            $stmt->bindParam(':imgPost', $imgPost);
                            $stmt->bindParam(':tipoPost', $tipoPost);
                    
                            $stmt->execute();
                    
                            echo "Inserido com sucesso!";
                        
                } catch(PDOException $e) {
                    echo "Erro ao inserir registro: " . $e->getMessage();
                }
            } catch(Exception $e) {
                echo "Erro: " . $e->getMessage();
            }
        }

        inserirBanco($conexao, $tituloPost, $subtituloPost, $tipoPost, $textoPost, $data);

    
?>
