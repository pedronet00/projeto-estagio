<?php
    // layout padrão
    include '../../../config/template.php';
    include '../../../api/post/read.php';

?>

<?php 
    $idPost = $_GET['idPost'];

    $stmt = retornarPostPorId($conexao, $idPost);
    
?>

<style>

    .banner{
        width: 100%;
        background-color: #6369E7;
        color: white;
        text-align: center;
        padding: 0.5%;
    }

    .cabecalho{

        text-align: center;
        width: 50%;
        margin: auto;
        margin-top: 5%;
    }

    h1{
        color: #6369E7;
        font-size: 40px;
    }

    .infos{
        display: flex;
        justify-content: space-between;
    }

    .conteudo{
        width: 50%;
        margin: auto;
    }

</style>

<?php while($post = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>

    <?php $img = str_replace('/src/src/', '/src', $post['imgPost']); 
        echo $img;
    ?>

    <!-- Conteúdo específico da página post.php -->
        <section class="banner">
            <h2 style="font-family: Niramit; font-weight: 100; font-size: 65px;">ESTUDO EXPOSITIVO</h2>
        </section>

        <div class="cabecalho">
            <h1><?php echo $post['tituloPost']; ?></h1>
            <br/>
            <p><?php echo $post['subtituloPost']; ?></p>
            <br/>
            <div class="infos">
                <p style="font-size: 12px;">Por Pedro Neto, vice-presidente da Unijovem<br/>Presidente Prudente, 06/05/2024, 12h54</p>
                <img src="/src/img/whatsapp.png" style="width: 55px; height: 30px;"/>
            </div>
        </div>

        <div class="conteudo">
        <img class="img_post" src="<?php echo $img; ?>"/>
            <?php echo $post['textoPost']; ?>
        </div>
<?php } ?>
