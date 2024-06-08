<?php 

    // Obter o caminho absoluto para o arquivo conn.php
    $connPath = __DIR__ . '/../../../config/conn.php';

    // Incluir o arquivo conn.php usando o caminho absoluto
    include_once($connPath); ?>


<?php 

function retornarTodosUsuarios($conexao) {
    try {
        // Consulta SQL para buscar os nomes de usuários e pastores
        $sql = "
            SELECT 
                u.idUsuario,
                u.nomeUsuario AS nome,
                u.emailUsuario,
                u.senhaUsuario,
                u.dataNascimentoUsuario,
                u.nivelUsuario,
                n.idnivelUsuario,
                n.nivelUsuario AS nomeNivelUsuario,
                u.imgUsuario,
                u.usuarioAtivo
            FROM 
                usuario u
            LEFT JOIN 
                nivelusuario n ON u.nivelUsuario = n.idnivelUsuario
            
            UNION
            
            SELECT 
                p.idPastor AS idUsuario,
                p.nomePastor AS nome,
                p.emailPastor AS emailUsuario,
                p.senhaPastor AS senhaUsuario,
                p.dataNascimentoPastor AS dataNascimentoUsuario,
                p.nivelUsuario,
                n.idnivelUsuario,
                n.nivelUsuario AS nomeNivelUsuario,
                p.imgPastor AS imgUsuario,
                p.usuarioAtivo
            FROM 
                pastor p
            LEFT JOIN 
                nivelusuario n ON p.nivelUsuario = n.idnivelUsuario
            
            ORDER BY 
                nome ASC;
        ";

        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        
        return $stmt;
    } catch(PDOException $e) {
        echo "Erro ao buscar dados: " . $e->getMessage();
    }
}


    function retornarTodosPastores($conexao){
        $query = "SELECT pastor.*, nivelusuario.idnivelUsuario, nivelusuario.nivelUsuario as nomeNivelUsuario 
        FROM pastor 
        LEFT JOIN nivelusuario ON pastor.nivelUsuario = nivelusuario.idnivelUsuario 
        ORDER BY pastor.nomePastor ASC;";
        $stmt = $conexao->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function retornarUsuarioPorId($conexao, $idUsuario){
        $query = "SELECT usuario.*, nivelusuario.idnivelUsuario, nivelusuario.nivelUsuario AS nomeNivelUsuario 
        FROM usuario 
        LEFT JOIN nivelusuario ON usuario.nivelUsuario = nivelusuario.idnivelUsuario
        WHERE idUsuario = :idUsuario 
        ORDER BY usuario.nomeUsuario ASC;";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(":idUsuario", $idUsuario);
        $stmt->execute();

        return $stmt;
    }

    function retornarPastorPorId($conexao, $idUsuario){
        $query = "SELECT pastor.*, nivelusuario.idnivelUsuario, nivelusuario.nivelUsuario AS nomeNivelUsuario 
        FROM pastor 
        LEFT JOIN nivelusuario ON pastor.nivelUsuario = nivelusuario.idnivelUsuario
        WHERE idPastor = :idUsuario 
        ORDER BY pastor.nomePastor ASC;";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(":idUsuario", $idUsuario);
        $stmt->execute();

        return $stmt;
    }



?>