<?php 

    session_start();

    include '../../../../api/exceptions/exceptions.php'; 

    if($_SESSION['nivelUsuario'] != 1 && $_SESSION['nivelUsuario'] != 2 && $_SESSION['nivelUsuario'] != 3){ notAllowed(); }    

    $title = "Criar Post";
    include '../../../components/header-adm.php';
    include '../../../../api/tipo-post/read.php';

    $stmt = listarTodosTiposPost($conexao);
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/tinymce.min.js"></script>

<style>
    form{
        width: 80%;
        margin: auto;
    }

    label{
        font-family: Niramit;
    }

    textarea{
        resize: none;
    }
</style>

<h1>Criar post</h1>
    <form id="formPost" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Título do Post:</label>
            <input type="text" class="form-control" name="tituloPost" id="exampleFormControlInput1" placeholder="Título do Post">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Subtítulo do Post:</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="subtituloPost" rows="3" placeholder="Subtítulo do Post"></textarea>
        </div>

        <div class="row">
            <div class="col">
                <label for="imagem-fundo" class="form-label">Imagem de fundo:</label>
                <input type="file" class="form-control" name="imagemPost" id="imagem-fundo">
            </div>
            <div class="col">
                <label for="imagem-fundo" class="form-label">Tipo de Post:</label>
                <select class="form-select" name="tipoPost" aria-label="Default select example">
                    <option selected>Selecione o Tipo de Post:</option>
                    <?php while($tipoPost = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
                    <option value="<?php echo $tipoPost['id_tipoPost']; ?>"><?php echo $tipoPost['nome_tipoPost']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <br/>

        <div class="mb-3">
            <label for="default" class="form-label">Texto do Post:</label>
            <textarea class="form-control" name="textoPost" id="default"></textarea>
            <div id="output"></div>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

    <script>
        $(document).ready(function() {
            
            $('#formPost').submit(function(event) {
                event.preventDefault(); 

                var formData = new FormData(this);

                console.log(formData);

                $.ajax({
                    type: 'POST',
                    url: '/src/api/post/create.php',
                    data: formData,
                    processData: false,  
                    contentType: false,  
                    success: function(response){
                        Swal.fire({
                            title: "Sucesso!",
                            text: "Post inserido com sucesso!",
                            icon: "success"
                        });
                        setTimeout(function() { 
                            window.location.href = "read.php"; // Redirecionamento correto
                        }, 1500);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // Exibe detalhes do erro no console
                        Swal.fire({
                            title: "Erro!",
                            text: "Erro ao cadastrar Post.",
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            tinymce.init({
            selector: 'textarea#default',
            height: 600,
            plugins:[
                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                'searchreplace', 'wordcount', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media', 
                'table', 'emoticons', 'template', 'codesample'
            ],
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify |' + 
            'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
            'forecolor backcolor emoticons',
            menu: {
                favs: {title: 'Menu', items: 'code visualaid | searchreplace | emoticons'}
            },
            menubar: 'favs file edit view insert format tools table',
            content_style: 'body{font-family:Helvetica,Arial,sans-serif; font-size:16px}'
        });

        $('#submit').click(function(){
            var content = tinymce.activeEditor.getContent();
            $('#output').html(content);
        });
        });
    </script>