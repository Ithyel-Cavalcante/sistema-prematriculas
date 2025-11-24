<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['nome_usuario'])){
    die("Acesso recusado, logue para acessar. <p><a href=\"../tela-login/login.php\">Entrar</a></p>");
}
?>