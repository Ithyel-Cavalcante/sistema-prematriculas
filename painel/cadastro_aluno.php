<?php
    session_start();

    if(!isset($_SESSION['id_usuario'])){
        header('Location: ../tela-login/login.php');
        exit;
    }

    $qtd_alunos = $_SESSION['qtd_alunos'] ?? 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h2>
    Cadastro de <?php $qtd_alunos; ?> aluno(s)
</h2>
    
</body>
</html>