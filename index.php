<?php 
session_start(); 

if($_COOKIE["login"] || $_SESSION["login"]){
    $login = true;
} else {
    $login = false;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Central de Aviso</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <script src="/js/jquery-3.6.0.min.js"></script>
    </head>
    <body> 
        <?php require_once("navBar.php");
        require_once("controle.php");        
        if(!$login){
            require_once("loginModal.php");
        }
        ?>   
        <script src="/js/bootstrap.bundle.min.js"></script>
    </body>
</html>