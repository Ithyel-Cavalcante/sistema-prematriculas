<?php
session_start();

include '../conn.php';
include '../protect.php';

$ano_atual = date('Y');
$data_corte = new DateTime("$ano_atual-03-31"); 
$contagem_por_turma = [];
$turmas_faixa_etaria = []; 

$sql_alunos = "
SELECT 
    a.id_aluno,
    a.id_escola, 
    a.nome_aluno, 
    a.cpf_aluno, 
    a.bairro_aluno, 
    a.data_nascimento,
    a.turma_alocada,
    u.telefone_usuario
FROM 
    alunos a 
LEFT JOIN 
    usuario u ON a.id_usuario = u.id_usuario  
ORDER BY 
    a.id_aluno DESC
";

$stmt_alunos = $mysqli->prepare($sql_alunos);

if ($stmt_alunos === false) {
    die('Erro de Preparação do SQL (Principal): ' . $mysqli->error . ' Consulta: ' . htmlspecialchars($sql_alunos));
}

$stmt_alunos->execute();
$result_alunos = $stmt_alunos->get_result();
$total_alunos_cadastrados = $result_alunos->num_rows;

$sql_bairros = "
SELECT 
    bairro_aluno, COUNT(id_aluno) as total 
FROM 
    alunos 
GROUP BY 
    bairro_aluno 
ORDER BY 
    total DESC
";
$result_bairros = $mysqli->query($sql_bairros);
$bairros_summary = $result_bairros ? $result_bairros->fetch_all(MYSQLI_ASSOC) : [];


$sql_escolas = "
SELECT 
    E.nome_escola, COUNT(A.id_aluno) as total
FROM 
    alunos A
LEFT JOIN 
    escolas E ON CAST(A.id_escola AS UNSIGNED) = E.id_escola
GROUP BY 
    E.nome_escola
ORDER BY 
    total DESC
";
$result_escolas = $mysqli->query($sql_escolas);
$escolas_summary = $result_escolas ? $result_escolas->fetch_all(MYSQLI_ASSOC) : [];

$sql_faixas_etarias = "
SELECT 
    FE.id_escola, FE.nome_turma, FE.idade_minima_anos, FE.idade_maxima_anos
FROM 
    escola_faixa_etaria FE
ORDER BY 
    FE.id_escola, FE.idade_minima_anos
";
$result_faixas = $mysqli->query($sql_faixas_etarias);
if ($result_faixas) {
    while ($faixa = $result_faixas->fetch_assoc()) {
        $turmas_faixa_etaria[$faixa['id_escola']][] = $faixa;
    }
}

if ($total_alunos_cadastrados > 0) {
    $result_alunos->data_seek(0);
    while ($aluno = $result_alunos->fetch_assoc()) {
        $idade_do_aluno_no_corte = 0;
        $turma_calculada = "Idade Inválida";
        $id_escola = (int) ($aluno['id_escola'] ?? 0);

        try {
            $data_nasc_obj = new DateTime($aluno['data_nascimento']);
            $intervalo = $data_nasc_obj->diff($data_corte);
            $idade_do_aluno_no_corte = $intervalo->y; 

            if (isset($turmas_faixa_etaria[$id_escola])) {
                foreach ($turmas_faixa_etaria[$id_escola] as $faixa) {
                    if ($idade_do_aluno_no_corte >= $faixa['idade_minima_anos'] && $idade_do_aluno_no_corte <= $faixa['idade_maxima_anos']) {
                        $turma_calculada = $faixa['nome_turma'];
                        break;
                    }
                }
            } else {
                $turma_calculada = "Escola Sem Faixas Etárias Cadastradas";
            }
            if ($turma_calculada === "Idade Inválida") {
                 $turma_calculada = "Faixa Etária Incompatível ($idade_do_aluno_no_corte anos)";
            }

        } catch (Exception $e) {
            $turma_calculada = "Data Inválida";
        }

        if (!isset($contagem_por_turma[$turma_calculada])) {
            $contagem_por_turma[$turma_calculada] = 0;
        }
        $contagem_por_turma[$turma_calculada]++;
    }
}

ksort($contagem_por_turma);

if ($total_alunos_cadastrados > 0) {
    $result_alunos->data_seek(0);
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel do Administrador</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: "Inter", sans-serif; }
    </style>
</head>

<body>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Painel do Administrador</h1>
        <div class="bg-white rounded-xl shadow p-6 mb-8 flex items-center justify-between px-8">
            <h2 class="text-xl font-semibold ">
                Estatísticas de Pré-matrículas
                <span class="font-bold text-green-600">(Total: <?php echo $total_alunos_cadastrados; ?>)</span>
            </h2>
            <div class="flex gap-4">
            <a href="../painel/gerar_relatorio.php">
                <button class="bg-green-600 hover:bg-green-700 font-bold text-white px-5 py-2 rounded-lg shadow">
                    Gerar Relatório
                </button>
            </a>

            <a href="../logout.php">
                <button class="bg-red-600 hover:bg-red-700 font-bold text-white px-5 py-2 rounded-lg shadow">
                    Sair
                </button>
            </a>
        </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-5 shadow rounded-xl">
                <h3 class="text-lg font-semibold border-b pb-2 mb-3">Alunos por Bairro</h3>
                <ul class="space-y-2">
                    <?php foreach ($bairros_summary as $bairro): ?>
                        <li class="flex justify-between text-sm">
                            <span><?php echo htmlspecialchars($bairro['bairro_aluno']); ?></span>
                            <span class="font-semibold"><?php echo $bairro['total']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="bg-white p-5 shadow rounded-xl">
                <h3 class="text-lg font-semibold border-b pb-2 mb-3">Alunos por Escola</h3>
                <ul class="space-y-2">
                    <?php foreach ($escolas_summary as $escola): ?>
                        <li class="flex justify-between text-sm">
                            <span><?php echo htmlspecialchars($escola['nome_escola']); ?></span>
                            <span class="font-semibold"><?php echo $escola['total']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="bg-white p-5 shadow rounded-xl">
                <h3 class="text-lg font-semibold border-b pb-2 mb-3">Alunos por Turma</h3>
                <ul class="space-y-2">
                    <?php foreach ($contagem_por_turma as $turma => $total): ?>
                        <li class="flex justify-between text-sm">
                            <span><?php echo htmlspecialchars($turma); ?></span>
                            <span class="font-semibold"><?php echo $total; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <h2 class="text-2xl font-semibold mt-10 mb-4">Detalhes dos Alunos</h2>

        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="p-3 font-bold text-center">Nome</th>
                        <th class="p-3 font-bold text-center">CPF</th>
                        <th class="p-3 font-bold text-center">Bairro</th>
                        <th class="p-3 font-bold text-center">Escola</th>
                        <th class="p-3 font-bold text-center">Turma</th>
                        <th class="p-3 font-bold text-center">Nascimento</th>
                        <th class="p-3 font-bold text-center">Telefone</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($aluno = $result_alunos->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3"><?php echo htmlspecialchars($aluno['nome_aluno']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($aluno['cpf_aluno']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($aluno['bairro_aluno']); ?></td>
                            <td class="p-3"><?php 
                                $id_escola_int = (int) ($aluno['id_escola'] ?? 0); 
                                $nome_escola_disp = "Não Encontrada";

                                $stmt_escola_nome = $mysqli->prepare("SELECT nome_escola FROM escolas WHERE id_escola = ? LIMIT 1");
                                if ($stmt_escola_nome && $id_escola_int > 0) {
                                    $stmt_escola_nome->bind_param("i", $id_escola_int);
                                    $stmt_escola_nome->execute();
                                    $res = $stmt_escola_nome->get_result();
                                    if ($row = $res->fetch_assoc()) $nome_escola_disp = $row['nome_escola'];
                                }
                                echo htmlspecialchars($nome_escola_disp);
                            ?></td>

                            <td class="p-3"><?php echo htmlspecialchars($aluno['turma_alocada']); ?></td>
                            <td class="p-3">
                                <?php
                                    try {
                                        $data_obj = new DateTime($aluno['data_nascimento']);
                                        echo $data_obj->format("d/m/Y");
                                    } catch (Exception $e) {
                                        echo "Inválida";
                                    }
                                ?>
                            </td>
                            <td class="p-3"><?php echo htmlspecialchars($aluno['telefone_usuario'] ?? "N/A"); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
if (isset($stmt_alunos)) $stmt_alunos->close();
$mysqli->close();
?>