<?php
session_start();
setcookie("login", '', time()-1); 
setcookie("userName", '', time()-1); 
setcookie("privilegio", '', time()-1); 
session_unset();
session_destroy();
header("location: /");
?>