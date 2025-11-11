<?php

    $server = 'localhost'; 
    $user = 'root';
    $password = '';
    $database = 'prematriculasDB';

    $mysqli = new mysqli($server, $user, $password, $database);

    if($mysqli -> error){
        echo "Erro ao conectar banco de dados!";
    }
?>