<?php

session_start();
include '../protect.php';
include '../conn.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../tela-login/login.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$stmt_user = $mysqli->prepare("SELECT nome_usuario, bairro_usuario, qtd_alunos FROM usuario WHERE id_usuario = ?");
$stmt_user->bind_param("i", $id_usuario);
$stmt_user->execute();
$stmt_user->bind_result($nome_usuario, $bairro_usuario, $qtd_alunos);
$stmt_user->fetch();
$stmt_user->close();

$stmt_alunos = $mysqli->prepare("
    SELECT a.nome_aluno, a.cpf_aluno, a.bairro_aluno, e.nome_escola 
    FROM alunos a 
    INNER JOIN escolas e ON a.id_escola = e.id_escola 
    WHERE a.id_usuario = ?
");
$stmt_alunos->bind_param("i", $id_usuario);
$stmt_alunos->execute();
$result_alunos = $stmt_alunos->get_result();
$total_alunos_cadastrados = $result_alunos->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>
</head>
<body>
    <h1>Painel do Usuário</h1>
    
    <h2>Informações do Usuário</h2>
    <p><strong>Nome:</strong> <?php echo $nome_usuario; ?></p>
    <p><strong>Bairro:</strong> <?php echo $bairro_usuario; ?></p>
    <p><strong>Alunos Permitidos:</strong> <?php echo $qtd_alunos; ?></p>
    <p><strong>Alunos Cadastrados:</strong> <?php echo $total_alunos_cadastrados; ?></p>
    
    <hr>
    
    <h2>Alunos Cadastrados</h2>
    
    <?php if ($total_alunos_cadastrados > 0): ?>
        <table border="1" width="100%">
            <tr>
                <th>Nome do Aluno</th>
                <th>CPF</th>
                <th>Bairro</th>
                <th>Escola</th>
            </tr>
            <?php while ($aluno = $result_alunos->fetch_assoc()): ?>
            <tr>
                <td><?php echo $aluno['nome_aluno']; ?></td>
                <td><?php echo $aluno['cpf_aluno']; ?></td>
                <td><?php echo $aluno['bairro_aluno']; ?></td>
                <td><?php echo $aluno['nome_escola']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhum aluno cadastrado.</p>
    <?php endif; ?>
    
    <hr>
    
    <h2>Ações</h2>
    
    <?php if ($total_alunos_cadastrados < $qtd_alunos): ?>
        <a href="cadastro_aluno.php">
            <button>Cadastrar Alunos</button>
        </a>
    <?php else: ?>
        <p>Você já cadastrou todos os alunos permitidos.</p>
    <?php endif; ?>
    
    <br>
    <a href="../logout.php">
        <button>Sair</button>
    </a>

</body>
</html>

<?php
$stmt_alunos->close();
$mysqli->close();
?>