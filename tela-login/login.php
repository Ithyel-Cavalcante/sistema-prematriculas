<?php
include('../conn.php');
//impedir que o usuario coloque pontos no cpf
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro</title>
</head>
<body>
    <form action="acoes_login.php" method="post">
        <div class="">

            <div class="">
                <label>Email:</label>
                <input class="" name="email_usuario" type="email" maxlength="50" required>
            </div>

            <div class="">
                <label>Senha:</label>
                <input class="" name="senha_usuario" type="password" maxlength="50" required>
            </div>
        </div>

        <div class="flex items-center justify-center gap-6 mt-6">
            <button type="submit" name="login_usuario" class="">entrar</button> 
        </div>
    </form>
    <a href="cadastro.php">Cadastrar</a>
</body>
</html>