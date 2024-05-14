<?php 

$title = "Blog PIBPP | Primeira Igreja Batista de Presidente Prudente";
// Template
include '../../../public/components/header.php';

// API
include '../../../api/post/read.php';

include '../../../api/exceptions/exceptions.php';

$stmt = retornarTodosPostsPorData($conexao);

// Verificar se a query retornou algum resultado
if ($stmt->rowCount() > 0) {
?>

<style>
  *{
    font-family: Niramit;
  }
</style>

<?php 
  $firstPost = true; // Variável para controlar o primeiro post

  while ($posts = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $img = $posts['imgPost']; 
      if ($firstPost) {
  ?>

  <div class="card mb-3" style="width: 80%; height: 500px; margin: auto; text-align: center; border: none; margin-top: 2%;">
    <img src="<?php echo $img; ?>" style="height: 75%;" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title" style="font-size: 40px;"><?php echo $posts['tituloPost']; ?></h5>
      <p class="card-text" style="font-size: 18px;"><?php echo $posts['subtituloPost']; ?></p>
      <a href="../src/posts/post.php?idPost=<?php echo $posts['idPost']; ?>" target="_blank" class="btn" style="background-color: #6369E7; border-radius: 0; color: white; font-size: 22px;">Ver Post</a>
    </div>
  </div>

  <?php 
          $firstPost = false;
      } else { 
  ?>

  <div class="card mb-3" style="width: 60%; margin: auto; border: none; margin-top: 5%;">
    <div class="row g-0">
      <div class="col-md-4">
        <img src="<?php echo $img; ?>" style="width: 350px; height: 250px;" class="img-fluid rounded-start" alt="...">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title" style="font-size: 30px; text-align: center;"><?php echo $posts['tituloPost']; ?></h5>
          <br/>
          <p class="card-text"><?php echo $posts['subtituloPost']; ?></p>
          <hr/>
          <a href="../src/posts/post.php?idPost=<?php echo $posts['idPost']; ?>" target="_blank" class="btn" style="font-size: 22px;">Ver Post <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>

  <?php 
      } 
  } 
  } else {
    noContent();
  }
  ?>
