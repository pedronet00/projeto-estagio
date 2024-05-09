<?php session_start(); ?>
<?php if($_SESSION['nivelUsuario'] != 1 && $_SESSION['nivelUsuario'] != 2 && $_SESSION['nivelUsuario'] != 3){ header('Location: /config/403.php'); }    ?>


<?php
    // Inclui o arquivo de layout padrão
    include '../../config/template-adm.php';
?>

<!-- TinyMCE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/tinymce.min.js"></script>


<style>
    form {
        width: 80%;
        margin: auto;
    }

    label {
        font-family: Niramit;
    }
</style>

<h1>Criar Tipo de Post</h1>

<form id="formTipoPost" method="POST">
    <div class="mb-3">
        <label for="tipoPost" class="form-label">Tipo do Post:</label>
        <input type="text" class="form-control" name="tipoPost" id="tipoPost" placeholder="Escreva aqui o Tipo de Post">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>

<script>
    $(document).ready(function() {
        // Captura o envio do formulário via AJAX
        $('#formTipoPost').submit(function(event) {
            event.preventDefault(); // Evita o envio padrão do formulário

            var formData = $(this).serialize(); // Serializa os dados do formulário

            $.ajax({
                type: 'POST',
                url: '../../api/tipo-post/tipo-post.php',
                data: formData,
                success: function(response) {
                    $("#tipoPost").val('');
                    Swal.fire({
                        title: "Sucesso!",
                        text: "Tipo de Post inserido com sucesso!",
                        icon: "success"
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Exibe detalhes do erro no console
                    Swal.fire({
                        title: "Erro!",
                        text: "Erro ao cadastrar Tipo de Post.",
                        icon: "error"
                    });
                }
            });
        });
    });
</script>

