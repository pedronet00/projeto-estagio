<?php
    // Inclui o arquivo de layout padrão
    include '../../config/template-adm.php';

    include '../../api/tipo-usuario/read.php';
    $stmt = retornarTodosTiposUsuario($conexao);
?>



<form class="row g-3" method="POST" enctype="multipart/form-data" style="width: 100%;margin: auto;" id="formPost">
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
      <?php while($tipoUsuario = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
        <option value="<?php echo $tipoUsuario['idnivelUsuario']; ?>"><?php echo $tipoUsuario['nivelUsuario']; ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="col-9">
    <label class="form-label" for="inputGroupFile01">Foto de perfil</label>
    <input type="file" class="form-control" name="fotoPerfilUsuario" id="inputGroupFile01">
  </div>
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Cadastrar</button>
  </div>
</form>

<script>
        $(document).ready(function() {
            $('#formPost').submit(function(event) {
                event.preventDefault(); 

                var formData = new FormData(this); 

                console.log(formData);

                $.ajax({
                    type: 'POST',
                    url: '../../api/usuarios/create.php',
                    data: formData,
                    processData: false,  
                    contentType: false,  
                    success: function(response){
                        Swal.fire({
                            title: "Sucesso!",
                            text: "Usuário inserido com sucesso!",
                            icon: "success"
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); 
                        Swal.fire({
                            title: "Erro!",
                            text: "Erro ao cadastrar usuário.",
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>