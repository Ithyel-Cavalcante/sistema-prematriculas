<?php 
session_start();
include '../conn.php';

if (!isset($_SESSION['id_usuario'])) {
     header('Location: ../tela-login/login.php');
    exit;
}

$bairro_usuario = $_SESSION['bairro_usuario'];
$qtd_alunos = $_SESSION['qtd_alunos'] ?? 0;

$stmt_all = $mysqli->prepare("SELECT nome_escola, bairro_escola FROM escolas LIMIT 10");
$stmt_all->execute();
$result_all = $stmt_all->get_result();

$todas_escolas = [];
while ($row_all = $result_all->fetch_assoc()) {
    $todas_escolas[] = $row_all;
}

if (empty($todas_escolas)) {
    // Se não houver escolas, não há porque continuar
    $msg_erro_escolas = "<p style='color: red;'>NENHUMA ESCOLA CADASTRADA NO BANCO DE DADOS! (Verifique a tabela 'escolas')</p>";
} else {
    $msg_erro_escolas = "";
}

$stmt_all->close();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
    <!-- Inclua aqui seu CSS, se houver -->
</head>
<body>

<h2>Cadastro de <?php echo $qtd_alunos; ?> aluno(s)</h2>
<?php echo $msg_erro_escolas; ?>

<form action="../tela-login/acoes_login.php" method="POST">

    <?php
    if ($qtd_alunos > 0) {
    for ($i = 1; $i <= $qtd_alunos; $i++) {

            $escolas_do_bairro = [];
            $stmt_bairro = $mysqli->prepare("SELECT id_escola, nome_escola FROM escolas WHERE bairro_escola = ?");
            $stmt_bairro->bind_param("s", $bairro_usuario);
            $stmt_bairro->execute();
            $result_bairro = $stmt_bairro->get_result();
            
            while ($row_bairro = $result_bairro->fetch_assoc()) {
                $escolas_do_bairro[] = $row_bairro;
            }
            $stmt_bairro->close();
            
     echo "
            <div class='aluno-box' style='border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;'>
                <h3>Aluno $i</h3>

                <input type='text' name='alunos[$i][nome_aluno]' placeholder='Nome do aluno $i' required><br><br>

                <input type='text' name='alunos[$i][cpf_aluno]' placeholder='CPF do aluno $i' maxlength='11' required><br><br>

                <input type='hidden' name='alunos[$i][bairro_usuario]' value='".htmlspecialchars($bairro_usuario)."'>

                <!-- CAMPO CHAVE: Data de Nascimento é usada para o filtro etário! -->
                <label>Data de Nascimento:</label>
                <input type='date' name='alunos[$i][data_nascimento]' required><br><br>

                <label>Escolha a escola (Bairro: ".htmlspecialchars($bairro_usuario)."):</label><br>
                <select name='alunos[$i][escola]' required>
                    <option value=''>Selecione a escola</option>";

                    if (!empty($escolas_do_bairro)) {
                        foreach ($escolas_do_bairro as $esc) {
                        echo "<option value='{$esc['id_escola']}|{$esc['nome_escola']}'>
                                {$esc['nome_escola']}
                            </option>";
                            }
     } else {
    echo "<option value=''>NENHUMA ESCOLA DISPONÍVEL NESTE BAIRRO</option>";
    }

    echo "</select><br><br>
            </div>";
    }
     } else {
     echo "<p>O usuário não indicou a quantidade de alunos para cadastro.</p>";
    }
    ?>

    <button type="submit" name="salvar_alunos">Salvar Alunos</button>
</form>

</body>
</html>