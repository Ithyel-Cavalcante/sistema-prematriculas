<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro</title>
</head>
<body>
    <form action="acoes_login.php" method="post">
        <div class="grid grid-cols-2 gap-10">
            <div class="">
                <label>Nome:</label>
                <input class="" name="nome_usuario" type="text" maxlength="50" required>
            </div>
            <div class="">
                <label>Bairro:</label>
                <input class="" name="bairro_usuario" type="text" maxlength="50" required>
            </div>
            <div class="">
                <label>Quantidade de alunos:</label>
                <input class="" name="qtd_alunos" type="number" maxlength="50" required>
            </div>
            <div class="">
                <label>CPF:</label>
                <input class="" name="cpf_usuario" type="number" maxlength="50"  placeholder="000.000.000-00" required>
            </div> 

            <div class="">
                <label>Email:</label>
                <input class="" name="email_usuario" type="email" maxlength="50"  placeholder="seuemail@email.com" required>
            </div> 
            
            <div class="">
                <label>Senha:</label>
                <input class="" name="senha_usuario" type="password" maxlength="50" required>
            </div>
        </div>

        <div class="flex items-center justify-center gap-6 mt-6">
            <button type="submit" name="adicionar_usuario" class="">Salvar</button> 
        </div>
    </form>
</body>
</html>