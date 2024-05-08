<?php include '../../config/template-adm.php'; ?>
<?php include '../../api/usuarios/read.php'; ?>

<?php $stmt = retornarTodosUsuarios($conexao); ?>


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

      <?php $usuarios['usuarioAtivo'] = (1 ? "Ativo" : "Inativo"); ?>
      <tr>
        <td>
          <div class="d-flex align-items-center">
            <img
                src="<?php echo $usuarios['imgUsuario']; ?>"
                alt=""
                style="width: 110px; height: 110px;"
                class="rounded-circle"
                />
            <div class="ms-3">
              <p class="fw-bold mb-1"><?php echo $usuarios['nomeUsuario']; ?></p>
              <p class="text-muted mb-0"><?php echo $usuarios['emailUsuario']; ?></p>
            </div>
          </div>
        </td>
        <td>
          <span class=""><?php echo $usuarios['usuarioAtivo']; ?></span>
        </td>
        <td><?php echo $usuarios['nomeNivelUsuario']; ?></td>
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