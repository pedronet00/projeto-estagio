<?php
    // Inclui o arquivo de layout padrão
    include '../../config/template-adm.php';
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
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
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
            // Captura o envio do formulário via AJAX
            $('#formPost').submit(function(event) {
                event.preventDefault(); // Evita o envio padrão do formulário

                var formData = new FormData(this); // Cria um objeto FormData com os dados do formulário

                console.log(formData);

                $.ajax({
                    type: 'POST',
                    url: '../../api/post/create.php',
                    data: formData,
                    processData: false,  // Não processar os dados (já estão em FormData)
                    contentType: false,  // Não configurar o tipo de conteúdo (será definido automaticamente)
                    success: function(response){
                        Swal.fire({
                            title: "Sucesso!",
                            text: "Post inserido com sucesso!",
                            icon: "success"
                        });
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