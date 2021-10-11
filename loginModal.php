<script>
    $(function() {
        $("#modalLogin").modal("show");
    })
</script>
<div class="modal fade" id="modalLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLoginLabel">Login</h5>
            </div>
            <div class="modal-body">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" placeholder="Nome">
                    <label for="username">Nome do Usuário</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="senha" placeholder="Senha">
                    <label for="senha">Senha</label>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entrar</button>
        </div>
    </div>
</div>
</div>