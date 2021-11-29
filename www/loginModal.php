<script>
    $(function() {
        $("#modalLogin").modal("show");

        $('.btn-enviar').click(function() {
            let user = $("#username");
            let pass = $("#password");
            let erroMsg = $("#erroMsg");
            let erro = false;

            if (user.val() === "") {
                erro = true;
                user.addClass('is-invalid');
                erroMsg.removeClass('d-none');
                erroMsg.html("Informe o nome de usuário, o mesmo utilizado no windows.")

            }

            if (pass.val() === "") {
                erro = true;
                pass.addClass('is-invalid');
                erroMsg.removeClass('d-none');
                erroMsg.html("Informe a sua senha, a mesma utilizada no windows.")
            }

            if (!erro) {
                $(this).prop('disabled', true);
                user.removeClass('is-invalid');
                pass.removeClass('is-invalid');
                user.addClass('is-valid');
                pass.addClass('is-valid');

                dados = new FormData();
                dados.set('userName', user.val());
                dados.set('password', pass.val());

                $.ajax({
                    type: 'POST',
                    url: "/api/login.php",
                    data: dados,
                    processData: false,
                    contentType: false,
                    success: function(returnval) {
                        r = JSON.parse(returnval);
                        if (r.cod != '3') {
                            $('.btn-enviar').removeAttr('disabled');
                            erroMsg.removeClass('d-none');
                            erroMsg.html(r.msg)
                        } else {
                            document.location.reload(true);
                        }
                    }
                })
            }
        })
    })
</script>
<div class="modal fade" id="modalLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLoginLabel">Login</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" role="alert" id="erroMsg">      
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" placeholder="">
                    <label for="username">Nome do Usuário</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" placeholder="">
                    <label for="password">Senha</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-enviar">Entrar</button>
            </div>
        </div>
    </div>
</div>