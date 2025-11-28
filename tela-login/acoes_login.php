<?php
session_start();
include "../conn.php";

$admin_email = 'admin@email.com';


if (!function_exists('array_by_ref')) {
    function array_by_ref(&$arr) {
        $refs = [];
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
}

if (isset($_POST['adicionar_usuario'])) {
    $nome_usuario = trim($_POST['nome_usuario'] ?? '');
    $cpf_usuario = trim($_POST['cpf_usuario'] ?? '');
    $bairro_usuario = trim($_POST['bairro_usuario'] ?? '');
    $email_usuario = trim($_POST['email_usuario'] ?? '');
    $senha_usuario = trim($_POST['senha_usuario'] ?? '');
    $qtd_alunos = trim($_POST['qtd_alunos'] ?? '');
    $telefone_user = trim($_POST['telefone_usuario'] ?? '');

    if (empty($nome_usuario) || empty($cpf_usuario) || empty($bairro_usuario) || empty($senha_usuario) || empty($qtd_alunos) || empty($email_usuario) || empty($telefone_user)) {
        echo "<script>alert('Erro: Preencha todos os campos.'); window.history.back();</script>";
        exit;
    }

    if (!preg_match('/^\d{11}$/', $cpf_usuario)) {
        echo "<script>alert('Erro: CPF deve conter exatamente 11 dígitos.'); window.history.back();</script>";
        exit;
    }

    if(!filter_var($email_usuario, FILTER_VALIDATE_EMAIL)){
        echo "<script>alert('Erro: email não é válido!'); window.history.back();</script>";
        exit;    
    }

    $stmt_check = $mysqli->prepare("SELECT cpf_usuario, email_usuario FROM usuario WHERE cpf_usuario = ? OR email_usuario = ?");

    if (!$stmt_check) {
        echo "<script>alert('Erro ao preparar verificação de duplicidade: " . $mysqli->error . "'); window.history.back();</script>";
        exit;
    }

    $stmt_check = $mysqli->prepare("SELECT cpf_usuario, email_usuario FROM usuario WHERE cpf_usuario = ? OR email_usuario = ?");

    $stmt_check->bind_param("ss", $cpf_usuario, $email_usuario);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $existing_user = $result_check->fetch_assoc();
        $error_message = '';
        
        if ($existing_user['cpf_usuario'] === $cpf_usuario) {
            $error_message = 'Erro: O CPF informado já está cadastrado.';
        } 
        else if ($existing_user['email_usuario'] === $email_usuario) {
            $error_message = 'Erro: O Email informado já está cadastrado.';
        }

        $stmt_check->close();
        
        echo "<script>alert('$error_message'); window.history.back();</script>";
        exit;
    }

    $stmt_check->close();

    $senha_hash = password_hash($senha_usuario, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO usuario (nome_usuario, cpf_usuario, bairro_usuario, qtd_alunos, email_usuario, senha_usuario, telefone_usuario) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "<script>alert('Erro ao preparar consulta: " . $mysqli->error . "'); window.history.back();</script>";
        exit;
    }

    $stmt->bind_param("sssssss", $nome_usuario, $cpf_usuario, $bairro_usuario, $qtd_alunos, $email_usuario, $senha_hash, $telefone_user);

    if ($stmt->execute()) {
        echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar usuário: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $mysqli->close();
    exit;
}

if (isset($_POST['login_usuario'])) {
    $email_usuario = trim($_POST['email_usuario'] ?? '');
    $senha_usuario = trim($_POST['senha_usuario'] ?? '');
    
    if (empty($email_usuario) || empty($senha_usuario)) {
        echo "<script>alert('Erro: Preencha email e senha.'); window.history.back();</script>";
        exit;
    }

    $stmt = $mysqli->prepare("SELECT id_usuario, nome_usuario, qtd_alunos, senha_usuario, bairro_usuario FROM usuario WHERE email_usuario = ?");
    $stmt->bind_param("s", $email_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($senha_usuario, $row['senha_usuario'])) {
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nome_usuario'] = $row['nome_usuario'];
            $_SESSION['qtd_alunos'] = $row['qtd_alunos'];
            $_SESSION['bairro_usuario'] = $row['bairro_usuario'];

            if($email_usuario === $admin_email){
                $_SESSION['is_admin'] = true;
                $redirect = '../painel/painel_admin.php';
            }else{
                $_SESSION['is_admin'] = false;
                $redirect = '../painel/painel.php';
            }
            
            echo "<script>alert('Login realizado com sucesso!'); window.location.href = '$redirect';</script>";
        } else {
            echo "<script>alert('Senha incorreta.'); window.history.back();</script>";
        }
    } else {

        echo "<script>alert('Usuário não encontrado.'); window.history.back();</script>";
    }

    $stmt->close();
    $mysqli->close();
    exit;
}

if(isset($_POST['salvar_alunos'])){
    if (!empty($_POST['alunos'])) {
        $alunos_salvos = 0;
        $erros_etarios = [];

        $ano_atual = date('Y');
        $data_corte = new DateTime("$ano_atual-03-31");
        
        foreach ($_POST['alunos'] as $i => $aluno) {
            $nome = trim($aluno['nome_aluno'] ?? '');
            $cpf = trim($aluno['cpf_aluno'] ?? '');
            $bairro = trim($aluno['bairro_usuario'] ?? '');
            $data_nascimento_aluno = trim($aluno['data_nascimento'] ?? '');
            
            $escola_data = explode('|', $aluno['escola'] ?? '');
            $id_escola = intval($escola_data[0] ?? 0);
            $nome_escola_aluno = trim($escola_data[1] ?? 'Escola não informada');
            
            $turma_alocada = 'Não Alocado'; 

            if(empty($nome) || empty($cpf) || $id_escola == 0 || empty($data_nascimento_aluno)) {
                error_log("Aluno " . ($i+1) . " ignorado: Campos obrigatórios ausentes.");
                continue;
            }

            try {
                $data_nascimento = new DateTime($data_nascimento_aluno);
                $intervalo = $data_nascimento->diff($data_corte);
                $idade_do_aluno_no_corte = $intervalo->y;
            } catch (Exception $e) {
                error_log("Erro na data de nascimento do Aluno " . ($i+1) . ": " . $e->getMessage());
                $erros_etarios[] = "Aluno $nome: Data de nascimento inválida.";
                continue;
            }

            
            $sql_turmas_compativeis = "
                SELECT 
                    nome_turma 
                FROM 
                    escola_faixa_etaria 
                WHERE 
                    id_escola = ?
                AND 
                    ? BETWEEN idade_minima_anos AND idade_maxima_anos
                ORDER BY 
                    id_faixa ASC
            ";
            
            $stmt_turmas = $mysqli->prepare($sql_turmas_compativeis);
            
            if ($stmt_turmas === false) {
                error_log("Erro ao preparar busca de turmas: " . $mysqli->error);
                $erros_etarios[] = "Erro interno ao verificar faixas etárias para $nome.";
                continue;
            }

            $stmt_turmas->bind_param("ii", $id_escola, $idade_do_aluno_no_corte);
            $stmt_turmas->execute();
            $result_turmas = $stmt_turmas->get_result();
            $turmas_array = [];
            
            while ($row = $result_turmas->fetch_assoc()) {
                $turmas_array[] = $row['nome_turma'];
            }
            $stmt_turmas->close();
            
            if (empty($turmas_array)) {
                $erros_etarios[] = "Aluno $nome (idade $idade_do_aluno_no_corte anos): A escola '$nome_escola_aluno' não possui turma para esta faixa etária no corte de $ano_atual. Por favor, corrija no formulário.";
                continue; 
            }

            $num_turmas = count($turmas_array);

            $sql_count_faixa = "
                SELECT 
                    COUNT(a.id_aluno) AS total_alocados
                FROM 
                    alunos a
                INNER JOIN 
                    escola_faixa_etaria efe ON a.id_escola = efe.id_escola
                WHERE 
                    a.id_escola = ? 
                AND 
                    DATEDIFF(?, a.data_nascimento) / 365.25 BETWEEN efe.idade_minima_anos AND efe.idade_maxima_anos
            ";

            $stmt_count_faixa = $mysqli->prepare($sql_count_faixa);
            $data_corte_str = $data_corte->format('Y-m-d');
            
            if ($stmt_count_faixa === false) {
                error_log("Erro ao preparar contagem de faixa etária: " . $mysqli->error);
            } else {
                
                $sql_count_faixa_simples = "
                    SELECT 
                        COUNT(a.id_aluno) AS total_alocados
                    FROM 
                        alunos a
                    WHERE 
                        a.id_escola = ? 
                "; 

                $sql_count_total = "SELECT COUNT(id_aluno) AS total_alunos FROM alunos";
                $result_count_total = $mysqli->query($sql_count_total);
                $total_alunos_cadastrados_agora = $result_count_total->fetch_assoc()['total_alunos'] ?? 0;
                
                $indice_revezamento = $total_alunos_cadastrados_agora % $num_turmas; 
                
                $turma_alocada = $turmas_array[$indice_revezamento];
            }
                        
            $status_col_exists = $mysqli->query("SHOW COLUMNS FROM `alunos` LIKE 'status_matricula'")->num_rows > 0;
            $turma_col_exists = $mysqli->query("SHOW COLUMNS FROM `alunos` LIKE 'turma_alocada'")->num_rows > 0;
            $status_default = 'Aguardando Avaliação';

            $colunas = "id_escola, id_usuario, nome_aluno, cpf_aluno, bairro_aluno, data_nascimento, nome_escola_aluno";
            $placeholders = "?, ?, ?, ?, ?, ?, ?";
            $tipos = "iisssss";
            $parametros = [$id_escola, $_SESSION['id_usuario'], $nome, $cpf, $bairro, $data_nascimento_aluno, $nome_escola_aluno];

            if ($turma_col_exists) {
                $colunas .= ", turma_alocada";
                $placeholders .= ", ?";
                $tipos .= "s";
                $parametros[] = $turma_alocada;
            }
            
            if ($status_col_exists) {
                $colunas .= ", status_matricula";
                $placeholders .= ", ?";
                $tipos .= "s";
                $parametros[] = $status_default;
            }

            $sql_insert = "INSERT INTO alunos ($colunas) VALUES ($placeholders)";
            
            $stmt = $mysqli->prepare($sql_insert);
            
            $bind_params = array_merge([$tipos], $parametros);
            
            if (!call_user_func_array([$stmt, 'bind_param'], array_by_ref($bind_params))) {
                 error_log("Erro ao fazer bind_param: " . $stmt->error);
                 $erros_etarios[] = "Erro interno (Bind Param) ao tentar salvar $nome.";
                 continue;
            }
            
            if ($stmt->execute()) {
                $alunos_salvos++;
            } else {
                error_log("Erro ao salvar aluno: " . $stmt->error);
            }

            $stmt->close();
        }

        
        $msg_alerta = "";
        $redirecionar = false;

        if ($alunos_salvos > 0) {
            $msg_alerta .= "$alunos_salvos aluno(s) cadastrado(s) com sucesso!";
            $redirecionar = true; 
        }
        
        if (!empty($erros_etarios)) {
            if ($alunos_salvos > 0) {
                $msg_alerta .= "\n\nOBSERVAÇÃO: Erros encontrados para alguns alunos:";
            } else {
                $msg_alerta = "ATENÇÃO! Não foi possível salvar nenhum aluno devido aos seguintes problemas:";
            }
            
            $msg_alerta .= "\n- " . implode("\n- ", $erros_etarios);
            
            if ($alunos_salvos == 0) {
                $redirecionar = false; 
            }
        }

        if (!empty($msg_alerta)) {
            $redirect_url = $redirecionar ? '../painel/painel.php' : '../painel/cadastro_aluno.php'; 
            
            $js_msg = json_encode($msg_alerta); 

            echo "<script>
                alert($js_msg); 
                window.location.href='$redirect_url';
            </script>";
        } else {
            echo "<script>alert('Nenhum aluno foi submetido. Verifique o formulário.'); window.history.back();</script>";
        }
        
        exit;
    }
}
?>