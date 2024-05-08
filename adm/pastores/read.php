<?php include '../../config/template-adm.php'; ?>
<?php include '../../api/usuarios/read.php'; ?>

<?php $stmt = retornarTodosPastores($conexao); ?>


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
    <?php while($pastores = $stmt->fetch(PDO::FETCH_ASSOC)){?>

      <?php $pastores['usuarioAtivo'] = (1 ? "Ativo" : "Inativo"); ?>
      <tr>
        <td>
          <div class="d-flex align-items-center">
            <img
                src="<?php echo $pastores['imgPastor']; ?>"
                alt=""
                style="width: 110px; height: 110px;"
                class="rounded-circle"
                />
            <div class="ms-3">
              <p class="fw-bold mb-1"><?php echo $pastores['nomePastor']; ?></p>
              <p class="text-muted mb-0"><?php echo $pastores['emailPastor']; ?></p>
            </div>
          </div>
        </td>
        <td>
          <span class=""><?php echo $pastores['usuarioAtivo']; ?></span>
        </td>
        <td><?php echo $pastores['nomeNivelUsuario']; ?></td>
        <td>
          <button type="button" class="btn btn-link btn-sm btn-rounded">
            Editar
          </button>
          <button type="button" name="excluirUsuario" data-idUsuario="<?php echo $pastores['idUsuario']; ?>" class="btn btn-link btn-sm btn-rounded">
            Excluir
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

</script>
