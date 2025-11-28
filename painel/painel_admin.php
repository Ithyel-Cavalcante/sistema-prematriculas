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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f9; }
    h1 { color: #333; border-bottom: 2px solid #ccc; padding-bottom: 10px; margin-bottom: 20px; }
    h2 { color: #555; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-top: 30px; }
    
    .summary-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }
    .summary-card {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        flex: 1 1 300px; 
    }
    .summary-card h3 {
        color: #007bff;
        margin-top: 0;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 10px;
        font-size: 1.1em;
    }
    .summary-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .summary-list li {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px dotted #eee;
    }
    .summary-list li:last-child {
        border-bottom: none;
    }
    .summary-count {
        font-weight: bold;
        color: #4CAF50;
    }

    table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-bottom: 20px; 
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    th, td { 
        padding: 12px 15px; 
        text-align: left; 
        border-bottom: 1px solid #ddd; 
    }
    th { 
        background-color: #4CAF50; 
        color: white; 
        font-weight: bold; 
    }
    tr:nth-child(even) { background-color: #f2f2f2; }
    
    button { 
        padding: 10px 15px; 
        margin-right: 10px; 
        border: none; 
        border-radius: 5px; 
        cursor: pointer; 
        font-weight: bold;
        transition: background-color 0.3s;
    }
    button:hover { opacity: 0.9; }
    
    .btn-acao { background-color: #28a745; color: white; }
    .btn-relatorio { background-color: #007bff; color: white; }
    .btn-sair { background-color: #dc3545; color: white; }

    @media (max-width: 768px) {
        .summary-container {
            flex-direction: column;
            gap: 15px;
        }
        .summary-card {
            flex-basis: auto;
        }
        table, thead, tbody, th, td, tr { 
            display: block; 
        }
        thead tr { 
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        tr { border: 1px solid #ccc; margin-bottom: 10px; }
        td { 
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%; 
            text-align: right;
        }
        td:before { 
            content: attr(data-label);
            position: absolute;
            left: 6px;
            width: 45%; 
            padding-right: 10px; 
            white-space: nowrap;
            text-align: left;
            font-weight: bold;
            color: #555;
        }
    }
</style>
    <title>Painel Principal Admin</title>
</head>
<body>
    <h1>Painel do Admin</h1>

    <div style="margin-bottom: 20px;">
        <a href="../painel/cadastro_aluno.php">
            <button type="button" class="btn-acao">Cadastrar Aluno</button>
        </a>
    </div>

    <h2>Estatísticas de Pré-matrículas (Total: <?php echo $total_alunos_cadastrados; ?>)</h2>
    <div class="summary-container">

        <div class="summary-card">
            <h3>Alunos por Bairro</h3>
            <ul class="summary-list">
                <?php if (!empty($bairros_summary)): ?>
                    <?php foreach ($bairros_summary as $bairro): ?>
                        <li>
                            <span><?php echo htmlspecialchars($bairro['bairro_aluno']); ?></span> 
                            <span class="summary-count"><?php echo $bairro['total']; ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Nenhum dado de bairro.</li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="summary-card">
            <h3>Alunos por Escola</h3>
            <ul class="summary-list">
                <?php if (!empty($escolas_summary)): ?>
                    <?php foreach ($escolas_summary as $escola): ?>
                        <li>
                            <span><?php echo htmlspecialchars($escola['nome_escola'] ?? 'Escola Não Encontrada'); ?></span> 
                            <span class="summary-count"><?php echo $escola['total']; ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Nenhum dado de escola.</li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="summary-card">
            <h3>Alunos por Turma (Calculado)</h3>
            <ul class="summary-list">
                <?php if (!empty($contagem_por_turma)): ?>
                    <?php foreach ($contagem_por_turma as $turma => $total): ?>
                        <li>
                            <span><?php echo htmlspecialchars($turma); ?></span> 
                            <span class="summary-count"><?php echo $total; ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Nenhum aluno classificado.</li>
                <?php endif; ?>
            </ul>
        </div>

    </div>
    
    <h2>Detalhes dos Alunos Cadastrados</h2>

    <?php if ($total_alunos_cadastrados > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome do Aluno</th>
                    <th>CPF</th>
                    <th>Bairro</th>
                    <th>Escola Desejada</th>
                    <th>Turma Alocada</th>
                    <th>Data Nascimento</th>
                    <th>Telefone do Responsável</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if ($result_alunos->data_seek(0) === true): 
                while ($aluno = $result_alunos->fetch_assoc()): 
                    $data_nascimento_formatada = 'Data Inválida';
                    try {
                        $data_nasc_obj = new DateTime($aluno['data_nascimento']);
                        $data_nascimento_formatada = $data_nasc_obj->format('d/m/Y');
                    } catch (Exception $e) {
                    }
            ?>
                <tr>
                    <td data-label="Nome"><?php echo htmlspecialchars($aluno['nome_aluno']); ?></td>
                    <td data-label="CPF"><?php echo htmlspecialchars($aluno['cpf_aluno']); ?></td>
                    <td data-label="Bairro"><?php echo htmlspecialchars($aluno['bairro_aluno']); ?></td>
                    <td data-label="Escola"><?php 
                        $nome_escola_disp = 'Não Encontrada';
                        $id_escola_int = (int) ($aluno['id_escola'] ?? 0); 
                        $stmt_escola_nome = $mysqli->prepare("SELECT nome_escola FROM escolas WHERE id_escola = ? LIMIT 1");
                        if ($stmt_escola_nome && $id_escola_int > 0) {
                            $stmt_escola_nome->bind_param("i", $id_escola_int);
                            $stmt_escola_nome->execute();
                            $res = $stmt_escola_nome->get_result();
                            if ($row = $res->fetch_assoc()) {
                                $nome_escola_disp = $row['nome_escola'];
                            }
                            $stmt_escola_nome->close();
                        }
                        echo htmlspecialchars($nome_escola_disp); 
                    ?></td>
                    <td data-label="Turma"><?php echo htmlspecialchars($aluno['turma_alocada'] ?? 'N/A'); ?></td>
                    <td data-label="Nascimento"><?php echo $data_nascimento_formatada; ?></td>
                    <td data-label="Telefone"><?php echo htmlspecialchars($aluno['telefone_usuario'] ?? 'N/A'); ?></td>
                </tr>
            <?php endwhile; 
            endif;
            ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum aluno cadastrado.</p>
    <?php endif; ?>
    
    <hr>
    
    <h2>Ações</h2>

    <a href="../painel/gerar_relatorio.php">
        <button type="button" class="btn-relatorio">Gerar Relatório</button>
    </a>

    <a href="../logout.php">
        <button class="btn-sair">Sair</button>
    </a>

</body>
</html>

<?php
if (isset($stmt_alunos) && $stmt_alunos instanceof mysqli_stmt) {
    $stmt_alunos->close();
}
$mysqli->close();
?>