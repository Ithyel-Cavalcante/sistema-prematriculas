<?php
session_start();
include "../conn.php";

$admin_email = 'admin@email.com';

if (isset($_POST['adicionar_usuario'])) {
    $nome_usuario = trim($_POST['nome_usuario'] ?? '');
    $cpf_usuario = trim($_POST['cpf_usuario'] ?? '');
    $bairro_usuario = trim($_POST['bairro_usuario'] ?? '');
    $email_usuario = trim($_POST['email_usuario'] ?? '');
    $senha_usuario = trim($_POST['senha_usuario'] ?? '');
    $qtd_alunos = trim($_POST['qtd_alunos'] ?? '');

    if (empty($nome_usuario) || empty($cpf_usuario) || empty($bairro_usuario) || empty($senha_usuario) || empty($qtd_alunos || empty($email_usuario))) {
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

    $stmt = $mysqli->prepare("INSERT INTO usuario (nome_usuario, cpf_usuario, bairro_usuario, qtd_alunos, email_usuario, senha_usuario) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "<script>alert('Erro ao preparar consulta: " . $mysqli->error . "'); window.history.back();</script>";
        exit;
    }

    $stmt->bind_param("ssssss", $nome_usuario, $cpf_usuario, $bairro_usuario, $qtd_alunos, $email_usuario, $senha_hash);

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

            $sql_verifica_faixa = "
                SELECT 
                    nome_turma 
                FROM 
                    escola_faixa_etaria 
                WHERE 
                    id_escola = ?
                AND 
                    ? BETWEEN idade_minima_anos AND idade_maxima_anos
                LIMIT 1
            ";
            
            $stmt_verifica = $mysqli->prepare($sql_verifica_faixa);
            
            if ($stmt_verifica === false) {
                error_log("Erro ao preparar verificação etária: " . $mysqli->error);
                $erros_etarios[] = "Erro interno ao verificar faixa etária para $nome.";
                continue;
            }

            $stmt_verifica->bind_param("ii", $id_escola, $idade_do_aluno_no_corte);
            $stmt_verifica->execute();
            $result_verifica = $stmt_verifica->get_result();
            
            if ($result_verifica->num_rows == 0) {
                $erros_etarios[] = "Aluno $nome (idade $idade_do_aluno_no_corte anos): A escola '$nome_escola_aluno' não possui turma para esta faixa etária no corte de $ano_atual. Por favor, corrija no formulário.";
                $stmt_verifica->close();
                continue; 
            }
            
            $stmt_verifica->close();
            
            $status_col_exists = $mysqli->query("SHOW COLUMNS FROM `alunos` LIKE 'status_matricula'")->num_rows > 0;
            $status_default = 'Aguardando Avaliação';

            if ($status_col_exists) {
                 $sql_insert = "
                    INSERT INTO alunos (id_escola, id_usuario, nome_aluno, cpf_aluno, bairro_aluno, data_nascimento, nome_escola_aluno, status_matricula)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                 ";
                 $stmt = $mysqli->prepare($sql_insert);
                 $stmt->bind_param("iissssss",
                    $id_escola,
                    $_SESSION['id_usuario'],
                    $nome,
                    $cpf,
                    $bairro,
                    $data_nascimento_aluno,
                    $nome_escola_aluno,
                    $status_default
                 );
            } else {
                 $sql_insert = "
                    INSERT INTO alunos (id_escola, id_usuario, nome_aluno, cpf_aluno, bairro_aluno, data_nascimento, nome_escola_aluno)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                 ";
                 $stmt = $mysqli->prepare($sql_insert);
                 $stmt->bind_param("iisssss",
                    $id_escola,
                    $_SESSION['id_usuario'],
                    $nome,
                    $cpf,
                    $bairro,
                    $data_nascimento_aluno,
                    $nome_escola_aluno
                 );
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
            $redirect_url = $redirecionar ? '../painel/painel.php' : '../painel/cadastro_aluno.php'; // Volta para o cadastro se houver erros sem salvar
            
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