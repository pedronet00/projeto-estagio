<?php 

  session_start(); 
  
  include '../../../../api/exceptions/exceptions.php'; 
  if($_SESSION['nivelUsuario'] != 1){ notAllowed(); }    


  if(isset($_GET['idUsuario'])){
    $title = "Editando usuário";
  } else{
    $title = "Criando Usuário";
  }
  
  include '../../../components/header-adm.php';
  include '../../../../api/tipo-usuario/read.php';
  include '../../../../api/usuarios/read.php';

  $stmt = retornarTodosTiposUsuario($conexao);

?>


<?php 
  
  if(isset($_GET['idUsuario'])){

    $title = "Editar Usuário";
    $idUsuario = $_GET['idUsuario'];

      if(isset($_GET['ehPastor'])){
        $stmtUsuario = retornarPastorPorId($conexao, $idUsuario);
        $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
        echo "testeee";
      } else{
        
        $stmtUsuario = retornarUsuarioPorId($conexao, $idUsuario);
        $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
      }
    
  }

?>


<form class="row g-3" method="POST" enctype="multipart/form-data" style="width: 100%;margin: auto;" id="formPost">
  <div class="col-9">
    <label for="inputAddress2" class="form-label">Nome do usuário</label>
    <input type="text" class="form-control" name="nomeUsuario" <?php if(isset($_GET['idUsuario'])){ if(isset($_GET['ehPastor'])){ echo "value='".$usuario['nomePastor']."'"; } else{ echo "value='".$usuario['nomeUsuario']."'";}}?> id="inputAddress2" placeholder="Nome do usuário">
  </div>
  <div class="col-9">
    <label for="exampleInputEmail1" class="form-label">Endereço de e-mail</label>
    <input type="email" class="form-control" name="emailUsuario" <?php if(isset($_GET['idUsuario'])){ if(isset($_GET['ehPastor'])){ echo "value='".$usuario['emailPastor']."'"; } else{ echo "value='".$usuario['emailUsuario']."'";}}?>  id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="col-9">
    <label for="exampleInputPassword1" class="form-label">Senha</label>
    <input type="password" class="form-control" <?php if(isset($_GET['idUsuario'])){ echo "disabled"; }?>  name="senhaUsuario" id="exampleInputPassword1">
  </div>
  <div class="col-md-5">
    <label for="inputCity" class="form-label">Data de Nascimento</label>
    <input type="date" class="form-control" <?php if(isset($_GET['idUsuario'])){ if(isset($_GET['ehPastor'])){ echo "value='".$usuario['dataNascimentoPastor']."'"; } else{ echo "value='".$usuario['dataNascimentoUsuario']."'";}}?>  name="dataNascimentoUsuario" id="inputCity">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">Tipo de Usuário</label>
    <select id="inputState" class="form-select" name="nivelUsuario">
      <option selected>Escolha o tipo de usuário:</option>
      <?php while($tipoUsuario = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
        <option value="<?php echo $tipoUsuario['idnivelUsuario']; ?>" <?php if(isset($_GET['idUsuario'])){ if($usuario['nivelUsuario'] == $tipoUsuario['idnivelUsuario']){ echo "selected"; } }?> ><?php echo $tipoUsuario['nivelUsuario']; ?></option>
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

        // Verifica se a URL contém o parâmetro 'idUsuario'
        var urlParams = new URLSearchParams(window.location.search);
        var actionUrl = urlParams.has('idUsuario') ? '/src/api/usuarios/update.php' : '/src/api/usuarios/create.php';

        if (urlParams.has('idUsuario')) {
            // Adiciona o idUsuario ao formData
            formData.append('idUsuario', urlParams.get('idUsuario'));

            // Remove o campo de imagem do formData
            formData.delete('fotoPerfilUsuario');
        }

        // Logando o conteúdo do formData
        console.log("Dados do formulário:");
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            type: 'POST',
            url: actionUrl,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: "Sucesso!",
                    text: "Usuário " + (urlParams.has('idUsuario') ? "editado" : "criado") + " com sucesso!",
                    icon: "success"
                }).then(function() {
                    window.location.reload();
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); 
                Swal.fire({
                    title: "Erro!",
                    text: "Erro ao " + (urlParams.has('idUsuario') ? "editar" : "criar") + " usuário.",
                    icon: "error"
                });
            }
        });
    });
});
</script>
