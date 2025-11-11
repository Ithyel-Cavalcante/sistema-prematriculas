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
                <label>CPF</label>
                <input class="" name="cpf_usuario" type="number" maxlength="50" required>
            </div>

            <div class="">
                <label>Senha:</label>
                <input class="" name="senha_usuario" type="text" maxlength="50" required>
            </div>
        </div>

        <div class="flex items-center justify-center gap-6 mt-6">
            <button type="submit" name="login_usuario" class="">entrar</button> 
        </div>
    </form>
    <a href="cadastro.php">Cadastrar</a>
</body>
</html>