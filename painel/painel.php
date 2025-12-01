<?php
session_start();
include '../protect.php';
include '../conn.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../tela-login/login.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$stmt_user = $mysqli->prepare("
    SELECT nome_usuario, bairro_usuario, qtd_alunos 
    FROM usuario 
    WHERE id_usuario = ?
");
$stmt_user->bind_param("i", $id_usuario);
$stmt_user->execute();
$stmt_user->bind_result($nome_usuario, $bairro_usuario, $qtd_alunos);
$stmt_user->fetch();
$stmt_user->close();

$stmt_alunos = $mysqli->prepare("
    SELECT a.nome_aluno, a.cpf_aluno, a.bairro_aluno, a.data_nascimento, e.nome_escola 
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel Principal</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-gray-100 p-4 sm:p-8">

    <div class="max-w-5xl mx-auto bg-white shadow-xl border border-gray-300 rounded-lg p-6 sm:p-10">

        <h1 class="text-3xl font-bold text-center mb-10">Painel do Usuário</h1>
        <h2 class="text-xl font-semibold mb-4">Informações do Usuário</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <p><strong>Nome:</strong> <?= $nome_usuario; ?></p>
            <p><strong>Bairro:</strong> <?= $bairro_usuario; ?></p>
            <p><strong>Alunos Permitidos:</strong> <?= $qtd_alunos; ?></p>
            <p>
                <strong>Alunos Cadastrados:</strong>
                <span class="<?= ($total_alunos_cadastrados >= $qtd_alunos) ? 'text-red-600 font-bold' : 'text-black font-bold'; ?>">
                    <?= $total_alunos_cadastrados; ?>
                </span>
            </p>
        </div>

        <hr class="my-6 border-gray-300" />
        <h2 class="text-xl font-semibold mb-4">Alunos Cadastrados</h2>

        <?php if ($total_alunos_cadastrados > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 rounded-md overflow-hidden">
                    <thead class="bg-green-600">
                        <tr>
                            <th class="px-4 py-3 text-white text-left">Nome do Aluno</th>
                            <th class="px-4 py-3 text-white text-left">CPF</th>
                            <th class="px-4 py-3 text-white text-left">Bairro</th>
                            <th class="px-4 py-3 text-white text-left">Escola</th>
                            <th class="px-4 py-3 text-white text-left">Nascimento</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($aluno = $result_alunos->fetch_assoc()): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3"><?= $aluno['nome_aluno']; ?></td>
                                <td class="px-4 py-3"><?= $aluno['cpf_aluno']; ?></td>
                                <td class="px-4 py-3"><?= $aluno['bairro_aluno']; ?></td>
                                <td class="px-4 py-3"><?= $aluno['nome_escola']; ?></td>
                                <td class="px-4 py-3"><?= $aluno['data_nascimento']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-700 mb-6">Nenhum aluno cadastrado.</p>
        <?php endif; ?>

        <hr class="my-6 border-gray-300" />

        <?php if ($total_alunos_cadastrados >= $qtd_alunos): ?>
            <p class="text-red-600 font-semibold mb-4">
                Você já cadastrou todos os alunos permitidos.
            </p>
        <?php endif; ?>

        <div class="flex flex-col sm:flex-row gap-4">

            <?php if ($total_alunos_cadastrados < $qtd_alunos): ?>
                <a href="cadastro_aluno.php"
                    class="px-6 py-3 bg-black text-white font-semibold rounded-md text-center hover:bg-gray-800">
                    Cadastrar Aluno
                </a>
            <?php endif; ?>

            <a href="../logout.php"
                class="px-6 py-3 bg-red-600 text-white font-semibold rounded-md text-center hover:bg-red-700">
                Sair
            </a>
        </div>

    </div>

</body>
</html>

<?php
$stmt_alunos->close();
$mysqli->close();
?>