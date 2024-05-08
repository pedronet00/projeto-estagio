<?php
    // Inclui o arquivo de layout padrão
    include '../../config/template-adm.php';

    require_once('../../api/post/read.php'); 

    $stmt = retornarTodosPosts($conexao);
?>


<table class="table table-striped" style="width: 80%; margin: auto; margin-top: 2%;">
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
      <td><a href="/src/posts/post.php?idPost=<?php echo $posts['idPost']; ?>" target="_blank" style="text-decoration: none; color: black;"><?php echo $posts['tituloPost']; ?></a></td>
      <td><?php echo $posts['nomeUsuario']; ?></td>
      <td><?php echo $posts['dataPost']; ?></td>
      <td>
          <button type="button" class="btn btn-link btn-sm btn-rounded">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button type="button" name="excluirPost" data-idPost="<?php echo $posts['idPost']; ?>" class="btn btn-link btn-sm btn-rounded">
            <i class="fa-solid fa-trash" style="color: #fa000c;"></i>
          </button>
        </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<script>
$(document).ready(function() {
    $('button[name="excluirPost"]').click(function() {

        var idPost = $(this).data('idpost');


        Swal.fire({
            title: "Tem certeza que quer excluir esse post?",
            text: "Essa ação não é reversível.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim, excluir"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '../../api/post/delete.php',
                    data: { idPost: idPost },
                    success: function(response) {
                        Swal.fire({
                            title: "Excluído!",
                            text: "Post foi excluído com sucesso.",
                            icon: "success"
                        });
                        setTimeout(function() {  location.reload(); }, 1500);
                    },
                    error: function(xhr, status, error) {
                        alert("Erro ao excluir post: " + error);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelado!",
                    text: "Ação de exclusão cancelada.",
                    icon: "info"
                });
            }
        });
    });
});

</script>