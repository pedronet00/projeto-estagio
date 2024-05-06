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
            <img class="img_post" src="../../img/spurgeon.webp"/>
            <p style="font-weight: 400; margin-top: 5%;">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vulputate arcu nec viverra posuere.
            <br/> <br/>
            Suspendisse aliquam mollis dolor, vitae varius neque mattis ac. Aenean ut ligula id purus volutpat consectetur ut at nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Phasellus ornare arcu ac sapien vulputate, sit amet hendrerit erat ornare. Nunc nibh lacus, convallis ut fermentum vitae, convallis ut velit. 
            <br/><br/>
            Nunc ac augue sit amet neque euismod mollis in vel dui. Duis tempus ullamcorper quam, sit amet viverra magna consectetur eget. Duis varius congue nunc rutrum convallis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed lacinia blandit justo ut auctor. Mauris dictum diam sem. Cras malesuada accumsan est, eget pellentesque metus luctus vitae. Suspendisse tristique facilisis purus vel suscipit. In bibendum elit in nibh elementum, eget cursus metus convallis. Sed efficitur accumsan libero, vel ultricies turpis.
            <br/><br/>
            Quisque tincidunt ornare lobortis. Nullam et diam consequat, lacinia nisi sit amet, efficitur turpis. Suspendisse sit amet dui placerat, tincidunt justo vel, faucibus orci. Aliquam quis purus ligula. Proin dictum justo non mauris facilisis ultrices. Vivamus vitae libero eu lacus tincidunt molestie. Proin dictum arcu id risus iaculis, quis dapibus augue accumsan.
            <br/><br/>
            Fusce auctor elit in lorem elementum, non cursus dui interdum. Phasellus volutpat dolor et porta ullamcorper. Sed et lectus sit amet dui accumsan laoreet. Duis posuere lectus a massa porta, vitae dictum ipsum auctor. Nunc at porta arcu. Aliquam ultrices sem sed pellentesque pharetra. Donec ante sapien, consectetur et ante et, malesuada accumsan diam. Nullam sed faucibus tellus. Quisque orci eros, porta eget magna eu, sagittis egestas nisi. Nulla et egestas quam. Vivamus iaculis leo nec ex varius faucibus. Donec condimentum pharetra tempus. Phasellus vel risus neque. Proin dapibus dolor sed arcu molestie, at commodo sapien consectetur. Vivamus accumsan felis vel nibh ultricies sollicitudin sit amet id massa.
            <br/><br/>
            Aliquam ligula lorem, sollicitudin finibus mollis a, pretium ut ex. Morbi vel auctor ligula, a venenatis magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam sed ultricies nisl, et venenatis lectus. Etiam a accumsan est. Nam condimentum sodales velit quis elementum. Nulla nec metus efficitur, consequat lacus sed, tempus odio. Fusce ornare luctus ultrices. Etiam semper accumsan dui, a luctus sem faucibus vitae. Duis tortor mi, iaculis a congue ac, pulvinar non elit.
            </p>
        </div>
<?php } ?>
