<?php
include '../conn.php'; 
include '../protect.php'; 

$data_hoje = date('Y-m-d');
$nome_arquivo = "relatorio_prematriculas_{$data_hoje}.csv";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');

$output = fopen('php://output', 'w');

$delimitador = ';';
$charset = 'UTF-8';

fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

$sql = "
    SELECT 
        a.id_aluno,
        a.nome_aluno,
        a.cpf_aluno,
        a.data_nascimento,
        a.bairro_aluno,
        a.nome_escola_aluno,
        a.turma_alocada,
        u.nome_usuario AS nome_responsavel,
        u.cpf_usuario AS cpf_responsavel,
        u.telefone_usuario AS telefone_responsavel,
        u.email_usuario AS email_responsavel
    FROM 
        alunos a
    INNER JOIN 
        usuario u ON a.id_usuario = u.id_usuario
    ORDER BY 
        a.nome_aluno ASC;
";

$result = $mysqli->query($sql);

if ($result === false) {
    $erro = "Erro na consulta SQL: " . $mysqli->error;
    fputcsv($output, [$erro], $delimitador);
    fclose($output);
    exit;
}


$cabecalho = [
    'ID Aluno',
    'Nome Aluno',
    'CPF Aluno',
    'Data Nasc.',
    'Idade Atual', 
    'Bairro Aluno',
    'Escola Desejada',
    'Turma Alocada',
    'Nome Responsável',
    'CPF Responsável',
    'Telefone Responsável',
    'Email Responsável'
];

fputcsv($output, $cabecalho, $delimitador);


$hoje = new DateTime();

while ($row = $result->fetch_assoc()) {
    try {
        $data_nascimento = new DateTime($row['data_nascimento']);
        $intervalo = $data_nascimento->diff($hoje);
        $idade_atual = $intervalo->y;
    } catch (Exception $e) {
        $idade_atual = 'Erro Cálculo Idade';
    }

    $linha_dados = [
        $row['id_aluno'],
        $row['nome_aluno'],
        $row['cpf_aluno'],

        (new DateTime($row['data_nascimento']))->format('d/m/Y'), 
        $idade_atual,
        $row['bairro_aluno'],
        $row['nome_escola_aluno'],
        $row['turma_alocada'] ?? 'N/D', 
        $row['nome_responsavel'],
        $row['cpf_responsavel'],
        $row['telefone_responsavel'],
        $row['email_responsavel']
    ];

    fputcsv($output, $linha_dados, $delimitador);
}

fclose($output);

exit;
?>