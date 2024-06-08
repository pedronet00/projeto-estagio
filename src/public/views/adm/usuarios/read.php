<?php 
  session_start(); 
  include '../../../../api/exceptions/exceptions.php';  
  if($_SESSION['nivelUsuario'] != 1){ notAllowed(); }    
  $title = "Listando Usuários"; 
  include '../../../components/header-adm.php'; 
  include '../../../../api/usuarios/read.php'; 
  $stmt = retornarTodosUsuarios($conexao); 
  $usuarioAtivo = ""; 
?>

<div class="pre" style="display: flex; justify-content: space-between; padding: 1%;">
  <div style="display: block; width: 50%;">
    <input type="text" class="form-control" id="myInput" placeholder="Insira o nome ou e-mail do usuário" aria-describedby="emailHelp">
    <div style="display: flex; margin-top: 2%;">
      <select class="form-select" id="statusFilter" aria-label="Default select example">
        <option selected>Status</option>
        <option value="Ativo">Ativo</option>
        <option value="Inativo">Inativo</option>
      </select>
      <select class="form-select" id="tipoUsuarioFilter" aria-label="Default select example">
        <option selected>Tipo de Usuário</option>
        <option value="Administrador">Administrador</option>
        <option value="Líder">Líder</option>
        <option value="Pastor">Pastor</option>
        <option value="Comum">Comum</option>
      </select>
    </div>
  </div>
  <button type="button" style="height: 50px;" class="btn btn-primary">
    <a href="/src/public/views/adm/usuarios/create.php" style="color: white; text-decoration: none;">
      <i class="fa-solid fa-plus"></i>&nbsp;Novo usuário
    </a>
  </button>
</div>

<table class="table align-middle mb-0 bg-white" id="myTable">
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
      <tr data-step="1" data-intro="Bem-vindo ao nosso site! Aqui está o menu principal.">
        <td class="nome-usuario">
          <div class="d-flex align-items-center">
            <img
                src="<?php echo $imgUsuario; ?>"
                alt=""
                style="width: 110px; height: 110px; object-fit: cover;"
                class="rounded-circle"
                />
            <div class="ms-3">
              <p class="fw-bold mb-1"><?php echo $usuarios['nome']; ?></p>
              <p class="text-muted mb-0"><?php echo $usuarios['emailUsuario']; ?></p>
            </div>
          </div>
        </td>
        <td class="status-usuario">
          <span data-step="3" data-intro="Aqui, você pode ver se um usuário está ativo ou não."><?php echo $usuarioAtivo; ?></span>
        </td>
        <td class="tipo-usuario"><?php echo $usuarios['nomeNivelUsuario']; ?></td>
        <?php if($usuarios['usuarioAtivo'] == 0){ ?>
          <td>
          <button type="button" name="editarUsuario" data-idUsuario="<?php echo $usuarios['idUsuario']; ?>"  class="btn btn-link btn-sm btn-rounded" data-step="1" data-intro="Aqui, você pode editar um usuário.">
          <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button type="button" name="reativarUsuario" data-idUsuario="<?php echo $usuarios['idUsuario']; ?>"  class="btn btn-link btn-sm btn-rounded">
          <i class="fa-solid fa-check" style="color: green;"></i>
          </button>
        </td>
        <?php } else{ ?>
        <td>
          <button type="button" name="editarUsuario" data-idUsuario="<?php echo $usuarios['idUsuario']; ?>"  class="btn btn-link btn-sm btn-rounded" data-step="1" data-intro="Aqui, você pode editar um usuário.">
          <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button type="button" name="excluirUsuario" data-idUsuario="<?php echo $usuarios['idUsuario']; ?>" class="btn btn-link btn-sm btn-rounded" data-step="2" data-intro="Aqui, você pode desativar um usuário.">
          <i class="fa-solid fa-trash" style="color: #fa000c;"></i>
          </button>
        </td>
        <?php } ?>
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

      $('button[name="editarUsuario"]').click(function() {
          var idUsuario = $(this).data('idusuario');
          console.log("Id do usuario: " + idUsuario);
          window.location.href = "create.php?idUsuario=" + idUsuario; 
      });

      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).find(".nome-usuario").text().toLowerCase().indexOf(value) > -1)
        });
      });

      $("#statusFilter, #tipoUsuarioFilter").on("change", function() {
        filterTable();
      });

      $("#searchButton").on("click", function() {
        filterTable();
      });

      function filterTable() {
        var statusValue = $("#statusFilter").val().toLowerCase();
        var tipoUsuarioValue = $("#tipoUsuarioFilter").val().toLowerCase();
        $("#myTable tr").filter(function() {
          var statusText = $(this).find(".status-usuario span").text().toLowerCase();
          var tipoUsuarioText = $(this).find(".tipo-usuario").text().toLowerCase();
          var statusMatch = (statusValue === "status") || (statusText === statusValue);
          var tipoUsuarioMatch = (tipoUsuarioValue === "tipo de usuário") || (tipoUsuarioText === tipoUsuarioValue);
          $(this).toggle(statusMatch && tipoUsuarioMatch);
        });
      }
  });
</script>

<script>
  document.getElementById('start-tour').onclick = function() {
    introJs().start();
  };
</script>

<?php include '../../../components/footer.php'; ?>
