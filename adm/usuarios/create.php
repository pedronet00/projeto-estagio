<?php
    // Inclui o arquivo de layout padrão
    include '../../config/template-adm.php';

    include '../../api/tipo-usuario/read.php';
    $stmt = retornarTodosTiposUsuario($conexao);
?>

<form class="row g-3">
  
  <div class="col-9">
    <label for="inputAddress2" class="form-label">Nome do usuário</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-5">
    <label for="inputCity" class="form-label">Data de Nascimento</label>
    <input type="date" class="form-control" id="inputCity">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">Tipo de Usuário</label>
    <select id="inputState" class="form-select">
      <option selected>Escolha o tipo de usuário:</option>
      <?php while($tipoUsuario = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
        <option value="<?php echo $tipoUsuario['idnivelUsuario']; ?>"><?php echo $tipoUsuario['nivelUsuario']; ?></option>
      <?php } ?>
    </select>
  </div>
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Sign in</button>
  </div>
</form>