<?php session_start(); ?>
<?php if($_SESSION['nivelUsuario'] != 1){ header('Location: /config/403.php'); }    ?>


<?php include '../../../components/header-adm.php'; ?>
<?php include '../../../../api/usuarios/read.php'; ?>

<?php

  $stmt = retornarTodosUsuarios($conexao); 
  $usuarioAtivo = ""; 

?>

<table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>Nome</th>
      <th>Status</th>
      <th>Tipo de Usuário</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php while($usuarios = $stmt->fetch(PDO::FETCH_ASSOC)){?>

      <?php $imgUsuario = "../../". $usuarios['imgUsuario']; ?>

      <?php $usuarioAtivo = ($usuarios['usuarioAtivo'] == 1) ? "Ativo" : "Inativo"; ?>
      <tr>
        <td>
          <div class="d-flex align-items-center">
            <img
                src="<?php echo $imgUsuario; ?>"
                alt=""
                style="width: 110px; height: 110px; object-fit: cover;"
                class="rounded-circle"
                />
            <div class="ms-3">
              <p class="fw-bold mb-1"><?php echo $usuarios['nomeUsuario']; ?></p>
              <p class="text-muted mb-0"><?php echo $usuarios['emailUsuario']; ?></p>
            </div>
          </div>
        </td>
        <td>
          <span class=""><?php echo $usuarioAtivo; ?></span>
        </td>
        <td><?php echo $usuarios['nomeNivelUsuario']; ?></td>
        <td>
          <button type="button" name="editarUsuario" class="btn btn-link btn-sm btn-rounded">
          <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button type="button" name="excluirUsuario" data-idUsuario="<?php echo $usuarios['idUsuario']; ?>" class="btn btn-link btn-sm btn-rounded">
          <i class="fa-solid fa-trash" style="color: #fa000c;"></i>
          </button>
        </td>
      </tr>
    <?php } ?>
    
  </tbody>
</table>

<script>
  $(document).ready(function() {
      $('button[name="excluirUsuario"]').click(function() {

          var idUsuario = $(this).data('idusuario');

          console.log("Id do usuario: " + idUsuario);

          Swal.fire({
              title: "Tem certeza que quer desativar esse usuário?",
              text: "Essa ação é reversível.",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Sim, desativar"
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      type: 'POST',
                      url: '../../api/usuarios/delete.php',
                      data: { idUsuario: idUsuario },
                      success: function(response) {
                          Swal.fire({
                              title: "Desativado!",
                              text: "Usuário foi desativado com sucesso.",
                              icon: "success"
                          });
                          setTimeout(function() {  location.reload(); }, 1500);
                      },
                      error: function(xhr, status, error) {
                          alert("Erro ao desativar usuário: " + error);
                      }
                  });
              } else if (result.dismiss === Swal.DismissReason.cancel) {
                  Swal.fire({
                      title: "Cancelado!",
                      text: "Ação de desativação cancelada.",
                      icon: "info"
                  });
              }
          });
      });
  });


  $(document).ready(function() {
      $('button[name="editarUsuario"]').click(function() {

          var idUsuario = $(this).data('idusuario');

          console.log("Id do usuario: " + idUsuario);

          Swal.fire({
              title: "Editar Usuário",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Salvar",
              width: 600,
              html: `
              <div style="margin: auto;">
                <form class="row g-3" method="POST" enctype="multipart/form-data" style="width: 100%; margin: auto;" id="formPost">
                  <div class="col-9">
                    <label for="inputAddress2" class="form-label">Nome do usuário</label>
                    <input type="text" class="form-control" name="nomeUsuario" id="inputAddress2" placeholder="Nome do usuário">
                  </div>
                  <div class="col-9">
                    <label for="exampleInputEmail1" class="form-label">Endereço de e-mail</label>
                    <input type="email" class="form-control" name="emailUsuario" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="col-9">
                    <label for="exampleInputPassword1" class="form-label">Senha</label>
                    <input type="password" class="form-control" name="senhaUsuario" id="exampleInputPassword1">
                  </div>
                  <div class="col-md-5">
                    <label for="inputCity" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" name="dataNascimentoUsuario" id="inputCity">
                  </div>
                  <div class="col-md-4">
                    <label for="inputState" class="form-label">Tipo de Usuário</label>
                    <select id="inputState" class="form-select" name="nivelUsuario">
                      <option selected>Escolha o tipo de usuário:</option>
                      
                    </select>
                  </div>
                  <div class="col-9">
                    <label class="form-label" for="inputGroupFile01">Foto de perfil</label>
                    <input type="file" class="form-control" name="fotoPerfilUsuario" id="inputGroupFile01">
                  </div>
                </form>
              </div>
              `,
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      type: 'POST',
                      url: '/src/api/usuarios/delete.php',
                      data: { idUsuario: idUsuario },
                      success: function(response) {
                          Swal.fire({
                              title: "Desativado!",
                              text: "Usuário foi desativado com sucesso.",
                              icon: "success"
                          });
                          setTimeout(function() {  location.reload(); }, 1500);
                      },
                      error: function(xhr, status, error) {
                          alert("Erro ao desativar usuário: " + error);
                      }
                  });
              } else if (result.dismiss === Swal.DismissReason.cancel) {
                  Swal.fire({
                      title: "Cancelado!",
                      text: "Ação de desativação cancelada.",
                      icon: "info"
                  });
              }
          });
      });
  });

</script>
