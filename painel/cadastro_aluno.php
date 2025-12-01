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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: Inter
        }
    </style>
</head>

<body class="h-screen">

    <div class="max-w-4xl mx-auto py-10">

        <div class="bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                Cadastro de <?php echo $qtd_alunos; ?> aluno(s)
            </h2>

            <?php echo $msg_erro_escolas; ?>

            <form action="../tela-login/acoes_login.php" method="POST" class="mt-8 space-y-6">

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
                        <div class='bg-gray-50 p-6 rounded-lg border shadow-sm'>
                            <h3 class='text-xl font-semibold text-gray-800 mb-4'>Aluno $i</h3>

                            <div class='grid grid-cols-1 md:grid-cols-2 gap-4'>

                                <div>
                                    <label class='block text-sm font-medium text-gray-700'>Nome do Aluno</label>
                                    <input 
                                        type='text' 
                                        name='alunos[$i][nome_aluno]' 
                                        class='mt-1 w-full p-3 border rounded-lg outline-none '
                                        placeholder='Nome do aluno $i'
                                        required
                                    >
                                </div>

                                <div>
                                    <label class='block text-sm font-medium text-gray-700'>CPF</label>
                                    <input 
                                        type='text'
                                        maxlength='11'
                                        name='alunos[$i][cpf_aluno]'
                                        class='mt-1 w-full p-3 border rounded-lg outline-none'
                                        placeholder='Digite o CPF'
                                        required
                                    >
                                </div>

                                <input type='hidden' name='alunos[$i][bairro_usuario]' value='" . htmlspecialchars($bairro_usuario) . "'>

                                <div>
                                    <label class='block text-sm font-medium text-gray-700'>Data de Nascimento</label>
                                    <input 
                                        type='date'
                                        name='alunos[$i][data_nascimento]'
                                        class='mt-1 w-full p-3 border rounded-lg outline-none'
                                        required
                                    >
                                </div>

                                <div>
                                    <label class='block text-sm font-medium text-gray-700'>
                                        Escola do Bairro: " . htmlspecialchars($bairro_usuario) . "
                                    </label>
                                    <select 
                                        name='alunos[$i][escola]'
                                        class='mt-1 w-full p-3 border rounded-lg outline-none '
                                        required
                                    >
                                        <option value=''>Selecione a escola</option>";

                        if (!empty($escolas_do_bairro)) {
                            foreach ($escolas_do_bairro as $esc) {
                                echo "<option value='{$esc['id_escola']}|{$esc['nome_escola']}'>{$esc['nome_escola']}</option>";
                            }
                        } else {
                            echo "<option value=''>NENHUMA ESCOLA DISPONÍVEL NESTE BAIRRO</option>";
                        }

                        echo "
                                    </select>
                                </div>

                            </div>
                        </div>
                        ";
                    }
                } else {
                    echo "<p>O usuário não indicou a quantidade de alunos para cadastro.</p>";
                }
                ?>

                <button
                    type="submit"
                    name="salvar_alunos"
                    class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold text-lg shadow hover:bg-green-700 transition"
                >
                    Salvar Alunos
                </button>

            </form>
        </div>
    </div>

</body>
</html>