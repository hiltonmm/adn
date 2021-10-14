<?php
if(!$_COOKIE["privilegio"]){
    echo "<h1> ACESSO NEGADO </h1>";
    exit;
}
require_once("api/aviso.php");
$action = '1'; //$_REQUEST['a'];
$avisoNum;
$avisoAno;

switch ($action) {
    case '1':
        numeraAviso();
        break;
    default:
        numeraAviso();
        break;
}

function numeraAviso()
{
    global $avisoNum, $avisoAno;
    $aviso = verificarProximoAviso();
    if (is_array($aviso)) {
        $avisoNum = $aviso["num"];
        $avisoAno = $aviso['ano'];
    }
}

?>
<link href="/Trumbowyg/ui/trumbowyg.min.css" rel="stylesheet">
<link href="/Trumbowyg/plugins/table/ui/trumbowyg.table.min.css" rel="stylesheet">
<link rel="stylesheet" href="/Trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css">
<script src="/Trumbowyg/trumbowyg.min.js"></script>
<script src="/Trumbowyg/plugins/table/trumbowyg.table.min.js"></script>
<script src="/Trumbowyg/plugins/colors/trumbowyg.colors.min.js"></script>
<script>
    $(document).ready(function() {
        $('#fullText').trumbowyg({
            btns: [
                ['viewHTML'],
                ['undo', 'redo'], // Only supported in Blink browsers
                ['formatting'],
                ['strong', 'em', 'del'],
                ['foreColor', 'backColor'],
                ['table'],
                ['superscript', 'subscript'],
                ['link'],
                ['insertImage'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat']
            ]
        });

        $("#titulo").keyup(function() {
            let max = $(this).attr('maxlength')
            let cont = $(this).val().length;
            let rest = max - cont;
            $(".tituloCount").html(rest);
        })
        $("#descricao").keyup(function() {
            let max = $(this).attr('maxlength')
            let cont = $(this).val().length;
            let rest = max - cont;
            $(".descCount").html(rest);
        })
        $(".btn-salvar").click(function() {
            let btn = $(this);
            let aviso = $("#aviso");
            let action = $("#action");
            let titulo = $("#titulo");
            let descricao = $("#descricao");
            let fullText = $("#fullText");
            let erro = false;
            let erroMsg = $("#erroMsg");
            let msg = '';
            let fixar = $("#fixar");

            if (titulo.val() === '') {
                erro = true;
                titulo.addClass('is-invalid');
                msg += "<p>Você precisa prencher o campo titulo.<p>";
            }

            if (descricao.val() === '') {
                erro = true;
                descricao.addClass('is-invalid');
                msg += "<p>Você precisa prencher o campo Breve Descrição.</p>";
            }

            if (fullText.val() === '') {
                erro = true;
                fullText.addClass('is-invalid');
                msg += "<p>Você precisa redigir o aviso no campo abaixo.</p>";
            }

            if (erro) {
                erroMsg.removeClass("d-none");
                erroMsg.html(msg);
            } else {
                titulo.removeClass('is-invalid');
                descricao.removeClass('is-invalid');
                fullText.removeClass('is-invalid');
                erroMsg.addClass("d-none");
                btn.prop('disabled', true);

                dados = new FormData();
                dados.set('titulo', titulo.val());
                dados.set('descricao', descricao.val());
                dados.set('fullText', fullText.val());
                dados.set('aviso', aviso.val());
                dados.set('action', action.val());
                dados.set('fix', fixar.is(':checked'));

                $.ajax({
                    type: 'POST',
                    url: "/api/aviso.php",
                    data: dados,
                    processData: false,
                    contentType: false,
                    success: function(returnval) {
                        r = JSON.parse(returnval);
                        if (!r.retorno) {
                            btn.removeAttr('disabled');
                            erroMsg.removeClass('d-none');
                            erroMsg.html(r.msg)
                        } else {
                            alertModal("Novo Aviso salvo com sucesso.", "Aviso", '/');
                        }
                    }
                })
            }


        })
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h4> Novo Aviso </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="aviso" placeholder="" value="<?= $avisoNum . '/' . $avisoAno ?>" readonly>
                <input type="hidden" id="action" value="1">
                <label for="aviso">Aviso nº</label>
            </div>
        </div>
        <div class="col-10">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" maxlength="30" id="titulo" placeholder="">
                <label for="titulo">Titulo do Aviso - Maximo de 30 Caracteres. Restam <span class="tituloCount">30</span> caracteres</label>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" maxlength="150" id="descricao" rows="3" style="height: 90px;" placeholder=""></textarea>
                        <label for="descricao">Breve Descrição - Maximo de 150 Caracteres. Restam <span class="descCount">150</span> caracteres</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-1 mb-3 d-flex justify-content-center align-items-center">

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="fixar">
                        <label class="form-check-label" for="fixar">FIXAR</label>
                    </div>
                </div>

                <div class="col-2 mb-3 d-flex justify-content-center align-items-center">
                    <button class="btn btn-primary btn-salvar">Salvar</button>
                </div>
                <div class="col-9">
                    <div class="alert alert-danger d-none" id="erroMsg"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <textarea placeholder="DIGITE O AVISO COMPLETO AQUI" id="fullText"></textarea>
                </div>
            </div>
        </div>