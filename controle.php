<?php
$m = $_REQUEST['m'];
    
    switch($m){
        case '0' : require_once("cards.php");
        break;
        case '1' : require_once("avisoFRM.php");
        break;
        default : require_once("cards.php");
        break;
    }
?>