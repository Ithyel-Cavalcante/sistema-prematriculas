<?php
session_start();

include '../conn.php';
include '../protect.php';

$ano_atual = date('Y');
$data_corte = new DateTime("$ano_atual-03-31");

$sql_alunos = "
SELECT 
    a.id_escola, 
    a.nome_aluno, 
    a.cpf_aluno, 
    a.bairro_aluno, 
    a.data_nascimento,
    a.turma_alocada,
    u.telefone_usuario  
FROM 
    alunos a 
INNER JOIN 
    usuario u ON a.id_usuario = u.id_usuario 
ORDER BY 
    a.id_aluno DESC
";

$stmt_alunos = $mysqli->prepare($sql_alunos);

if ($stmt_alunos === false) {
    die('Erro de Preparação do SQL: ' . $mysqli->error . ' Consulta: ' . htmlspecialchars($sql_alunos));
}

$stmt_alunos->execute();
$result_alunos = $stmt_alunos->get_result();
$total_alunos_cadastrados = $result_alunos->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f9; }
        h1 { color: #333; border-bottom: 2px solid #ccc; padding-bottom: 10px; }
        h2 { color: #555; }
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
        
        .btn-relatorio { background-color: #007bff; color: white; }
        .btn-sair { background-color: #dc3545; color: white; }
    </style>
    <title>Painel Principal Admin</title>
</head>
<body>
    <h1>Painel do Admin</h1>

    <h2>Alunos Cadastrados (Total: <?php echo $total_alunos_cadastrados; ?>)</h2>
    
    <?php if ($total_alunos_cadastrados > 0): ?>
        <table>
            <tr>
                <th>Nome do Aluno</th>
                <th>CPF</th>
                <th>Bairro</th>
                <th>Escola</th>
                <th>Turma (Calculada)</th>
                <th>Data Nascimento</th>
                <th>Telefone do Responsável</th>
            </tr>
            <?php while ($aluno = $result_alunos->fetch_assoc()): ?>
                <?php
                    $nome_turma = "Não Encontrada";
                    $nome_escola = "Escola Não Localizada";
                    $idade_do_aluno_no_corte = 0;
                    
                    try {
                        $data_nascimento = new DateTime($aluno['data_nascimento']);
                        $intervalo = $data_nascimento->diff($data_corte);
                        $idade_do_aluno_no_corte = $intervalo->y; 

                        $stmt_escola_turma = $mysqli->prepare("
                            SELECT 
                                E.nome_escola, FE.nome_turma
                            FROM 
                                escolas E
                            JOIN 
                                escola_faixa_etaria FE ON E.id_escola = FE.id_escola
                            WHERE 
                                E.id_escola = ? 
                            AND 
                                ? BETWEEN FE.idade_minima_anos AND FE.idade_maxima_anos
                            LIMIT 1
                        ");

                        $id_escola_int = (int) $aluno['id_escola']; 
                        
                        if ($stmt_escola_turma === false) {
                            throw new Exception('Erro de Preparação da Consulta da Turma: ' . $mysqli->error);
                        }

                        $stmt_escola_turma->bind_param("ii", $id_escola_int, $idade_do_aluno_no_corte);
                        $stmt_escola_turma->execute();
                        $result_escola_turma = $stmt_escola_turma->get_result();

                        if ($row_turma = $result_escola_turma->fetch_assoc()) {
                            $nome_turma = $row_turma['nome_turma'];
                            $nome_escola = $row_turma['nome_escola'];
                        } else {
                            $nome_turma = "Faixa Etária Incompatível ($idade_do_aluno_no_corte anos)";
                            
                            $stmt_escola = $mysqli->prepare("SELECT nome_escola FROM escolas WHERE id_escola = ? LIMIT 1");
                            
                            if ($stmt_escola === false) {
                                throw new Exception('Erro de Preparação da Consulta da Escola: ' . $mysqli->error);
                            }
                            
                            $stmt_escola->bind_param("i", $id_escola_int);
                            $stmt_escola->execute();
                            $result_escola = $stmt_escola->get_result();
                            if ($row_escola = $result_escola->fetch_assoc()) {
                                $nome_escola = $row_escola['nome_escola'];
                            }
                            $stmt_escola->close();
                        }

                        $stmt_escola_turma->close();
                        
                    } catch (Exception $e) {
                        error_log("Erro ao processar data/turma para aluno " . $aluno['nome_aluno'] . ": " . $e->getMessage());
                        $nome_turma = "Erro de Processamento";
                        $nome_escola = "Erro de Processamento";
                    }
                    
                ?>
            <tr>
                <td><?php echo htmlspecialchars($aluno['nome_aluno']); ?></td>
                <td><?php echo htmlspecialchars($aluno['cpf_aluno']); ?></td>
                <td><?php echo htmlspecialchars($aluno['bairro_aluno']); ?></td>
                <td><?php echo htmlspecialchars($nome_escola); ?></td>
                <td><?php echo htmlspecialchars($aluno['turma_alocada']); ?></td>
                <td><?php echo htmlspecialchars($aluno['data_nascimento']); ?></td>
                <td><?php echo htmlspecialchars($aluno['telefone_usuario']); ?></td>
            </tr>
            <?php endwhile; ?>
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
$stmt_alunos->close();
$mysqli->close();
?>