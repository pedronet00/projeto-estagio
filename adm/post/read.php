<?php
    // Inclui o arquivo de layout padrão
    include '../../config/template-adm.php';

    require_once('../../api/post/read.php'); 

    $stmt = retornarTodosPosts($conexao);
?>


<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Título do Post</th>
      <th scope="col">Autor do Post</th>
      <th scope="col">Data do Post</th>
      <th scope="col">Ação</th>
    </tr>
  </thead>
  <tbody>
    <?php while($posts = $stmt->fetch(PDO::FETCH_ASSOC)){?>
    <tr>
      <th scope="row"><?php echo $posts['idPost']; ?></th>
      <td><?php echo $posts['tituloPost']; ?></td>
      <td><?php echo $posts['autorPost']; ?></td>
      <td><?php echo $posts['dataPost']; ?></td>
      <td>
          <button type="button" class="btn btn-link btn-sm btn-rounded">
            Editar
          </button>
          <button type="button" name="excluirUsuario" data-idUsuario="<?php echo $usuarios['idUsuario']; ?>" class="btn btn-link btn-sm btn-rounded">
            Excluir
          </button>
        </td>
    </tr>
    <?php } ?>
  </tbody>
</table>