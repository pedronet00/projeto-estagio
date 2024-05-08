<?php require('../config/template.php'); ?>

<section class="">
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-3 fw-bold ls-tight">
            Bem vindo a <br />
            <span class="text-primary">PIBPP!</span>
          </h1>
          <p style="color: hsl(217, 10%, 50.8%);"><i>
            38 Porque estou certo de que, nem a morte, nem a vida, nem os anjos, nem os principados, nem os poderes, nem o presente, nem o porvir, 
            <br/><br/>
            39 Nem a altura, nem a profundidade, nem alguma outra criatura nos poderá separar do aamor de Deus, que está em Cristo Jesus, nosso Senhor.
            <br/><br/>
            Romanos 8:38-39 </i>
        </p>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card">
            <div class="card-body py-5 px-md-5">
              <form id="formLogin" method="POST">

                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="form3Example3">Endereço de e-mail</label>
                  <input type="email" name="email" id="form3Example3" class="form-control" />
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="form3Example4">Senha</label>
                  <input type="password" name="senha" id="form3Example4" class="form-control" />
                </div>

                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
                  Entrar
                </button>

                <div class="text-center">
                  <p>or sign up with:</p>
                  <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-facebook-f"></i>
                  </button>

                  <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-google"></i>
                  </button>

                  <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-twitter"></i>
                  </button>

                  <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                    <i class="fab fa-github"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    $(document).ready(function() {
        // Captura o envio do formulário via AJAX
        $('#formLogin').submit(function(event) {
            event.preventDefault(); // Evita o envio padrão do formulário

            var formData = $(this).serialize(); // Serializa os dados do formulário

            $.ajax({
                type: 'POST',
                url: '../api/login/login.php',
                data: formData,
                
            });
        });
    });
</script>