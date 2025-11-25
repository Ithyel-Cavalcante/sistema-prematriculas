<?php
session_start();

include '../conn.php';
include '../protect.php';

$stmt_alunos = $mysqli->prepare("
    SELECT a.nome_aluno, a.cpf_aluno, a.bairro_aluno, e.nome_escola, a.data_nascimento 
    FROM alunos a 
    INNER JOIN escolas e ON a.id_escola = e.id_escola 
");
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
    <h1>Painel do Admin</h1>
    
    <h2>Alunos Cadastrados</h2>
    
    <?php if ($total_alunos_cadastrados > 0): ?>
        <table border="1" width="100%">
            <tr>
                <th>Nome do Aluno</th>
                <th>CPF</th>
                <th>Bairro</th>
                <th>Escola</th>
                <th>Data Nascimento</th>
            </tr>
            <?php while ($aluno = $result_alunos->fetch_assoc()): ?>
            <tr>
                <td><?php echo $aluno['nome_aluno']; ?></td>
                <td><?php echo $aluno['cpf_aluno']; ?></td>
                <td><?php echo $aluno['bairro_aluno']; ?></td>
                <td><?php echo $aluno['nome_escola']; ?></td>
                <td><?php echo $aluno['data_nascimento']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhum aluno cadastrado.</p>
    <?php endif; ?>
    
    <hr>
    
    <h2>Ações</h2>
    
    <a href="../logout.php">
        <button>Sair</button>
    </a>

</body>
</html>

<?php
$stmt_alunos->close();
$mysqli->close();
?>