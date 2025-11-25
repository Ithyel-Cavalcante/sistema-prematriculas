<?php 
session_start();
include '../conn.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../tela-login/login.php');
    exit;
}

$bairro_usuario = $_SESSION['bairro_usuario'];
$qtd_alunos = $_SESSION['qtd_alunos'] ?? 0;

$stmt = $mysqli->prepare("SELECT id_escola, nome_escola, bairro_escola FROM escolas WHERE bairro_escola = ?");
$stmt->bind_param("s", $bairro_usuario);
$stmt->execute();
$result_escolas = $stmt->get_result();
$escolas = [];

$num_escolas = $result_escolas->num_rows;

while ($row = $result_escolas->fetch_assoc()) {
    $escolas[] = $row;
}

$stmt->close();

$stmt_all = $mysqli->prepare("SELECT nome_escola, bairro_escola FROM escolas LIMIT 10");
$stmt_all->execute();
$result_all = $stmt_all->get_result();

$todas_escolas = [];
while ($row_all = $result_all->fetch_assoc()) {
    $todas_escolas[] = $row_all;
}

if (empty($todas_escolas)) {
    echo "<p style='color: red;'>NENHUMA ESCOLA CADASTRADA NO BANCO DE DADOS!</p>";
}

$stmt_all->close();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
</head>
<body>

<h2>Cadastro de <?php echo $qtd_alunos; ?> aluno(s)</h2>

<form action="../tela-login/acoes_login.php" method="POST">

    <?php
    if ($qtd_alunos > 0) {
        for ($i = 1; $i <= $qtd_alunos; $i++) {
            echo "
            <div class='aluno-box'>
                <h3>Aluno $i</h3>

                <input type='text' name='alunos[$i][nome_aluno]' placeholder='Nome do aluno $i' required><br><br>

                <input type='text' name='alunos[$i][cpf_aluno]' placeholder='CPF do aluno $i' maxlength='11' required><br><br>

                <input type='hidden' name='alunos[$i][bairro_usuario]' value='".htmlspecialchars($bairro_usuario)."'>

                <input type='date' name='alunos[$i][data_nascimento]' placeholder='Data de nascimento' required><br><br>

                <label>Escolha a escola:</label><br>
                <select name='alunos[$i][escola]' required>
                    <option value=''>Selecione a escola</option>";
                    
                    if (!empty($escolas)) {
                        foreach ($escolas as $esc) {
                            echo "<option value='{$esc['id_escola']}|{$esc['nome_escola']}'>
                                {$esc['nome_escola']}
                            </option>";
                        }
                    } else {
                        echo "<option value=''>NENHUMA ESCOLA DISPONÍVEL</option>";
                    }

            echo "</select><br><br>
            </div>";
        }
    } else {
        echo "<p>Usuário não possui alunos cadastrados.</p>";
    }
    ?>

    <button type="submit" name="salvar_alunos">Salvar Alunos</button>
</form>

</body>
</html>