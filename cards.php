<?php
require_once("api/aviso.php");
?>
<div class="container p-3">
    <div class="row">
        
    <?php 
    
    if(isset($_REQUEST['p'])){
        $p = $_REQUEST['p'];
    } else {
        $p = '0';
    }
    
    if(isset($_REQUEST['ref'])){
        $ref = $_REQUEST['ref'];
        $pequisa = ['p' => $p, 'ref' => $ref];
    } else {
        $pequisa = ['p' => $p];
    }


    echo listarAvisos($pequisa) ?>


</div>