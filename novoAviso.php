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

    });
</script>

<div class="container">
    <div class="row">
        <div class="col">
            <h4> Novo Aviso </h4>
            <textarea id="fullText">Next, use our Get Started docs to setup Tiny!</textarea>
        </div>
    </div>
</div>