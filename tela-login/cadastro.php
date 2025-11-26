<?php
session_start();
include '../conn.php';
function buscarBairros($mysqli) {
    
    $stmt = $mysqli->prepare("SELECT id_bairro, nome_bairro FROM bairro ORDER BY nome_bairro ASC");
    
    if (!$stmt) {
        error_log("Erro ao preparar consulta de bairros: " . $mysqli->error);
        return []; 
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $bairros = [];
    
    while ($row = $result->fetch_assoc()) {
        $bairros[] = $row;
    }

    $stmt->close();
    return $bairros;
}

$lista_bairros = buscarBairros($mysqli);
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro - Sistema de Pré Matrículas</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap"
      rel="stylesheet"
    />

    <style>
      * {
        font-family: Inter;
      }
    </style>
  </head>

  <body class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
    <form
      action="acoes_login.php"
      method="post"
      class="flex flex-col gap-4 text-left p-8 sm:p-12 shadow-lg border-zinc-200 border-2 rounded-md w-full max-w-3xl bg-white"
    >
      <h2 class="text-2xl sm:text-3xl font-bold text-center mb-4">
        Cadastro - Sistema de Pré Matrículas
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col gap-4">
          <div class="flex flex-col gap-2">
            <label>Nome <span class="text-red-500">*</span></label>
            <input
              class="w-full px-4 py-2 rounded-md border-2 border-zinc-200 outline-green-400"
              name="nome_usuario"
              placeholder="Seu nome completo"
              type="text"
              maxlength="50"
              required
            />
          </div>

          <div class="flex flex-col gap-2">
            <label>Bairro <span class="text-red-500">*</span></label>
            <select
              class="w-full px-4 py-2 rounded-md border-2 border-zinc-200 outline-green-400"
              name="bairro_usuario"
              required>
              <option value="">Selecione seu bairro</option>
                <?php
                    foreach ($lista_bairros as $bairro) {
                      $valor = htmlspecialchars($bairro['nome_bairro']);
                    echo "<option value='{$valor}'>" . $valor . "</option>";
                  }
                ?>
            </select>
          </div>

          <div class="flex flex-col gap-2">
            <label>Quantidade de alunos <span class="text-red-500">*</span></label>
            <input
              class="w-full px-4 py-2 rounded-md border-2 border-zinc-200 outline-green-400"
              name="qtd_alunos"
              placeholder="Ex: 2"
              type="number"
              required
            />
          </div>
        </div>

        <div class="flex flex-col gap-4">
          <div class="flex flex-col gap-2">
            <label>CPF <span class="text-red-500">*</span></label>
            <input
              class="w-full px-4 py-2 rounded-md border-2 border-zinc-200 outline-green-400"
              name="cpf_usuario"
              type="text"
              placeholder="000.000.000-00"
              maxlength="11"
              required
            />
          </div>

          <div class="flex flex-col gap-4">
          <div class="flex flex-col gap-2">
            <label>Telefone <span class="text-red-500">*</span></label>
            <input
              class="w-full px-4 py-2 rounded-md border-2 border-zinc-200 outline-green-400"
              name="telefone_usuario"
              type="tel"
              placeholder="(xx) xxxxx-xxxx"
              maxlength="11"
              required
            />
          </div>

          <div class="flex flex-col gap-2">
            <label>Email <span class="text-red-500">*</span></label>
            <input
              class="w-full px-4 py-2 rounded-md border-2 border-zinc-200 outline-green-400"
              name="email_usuario"
              type="email"
              maxlength="50"
              placeholder="seuemail@email.com"
              required
            />
          </div>

          <div class="flex flex-col gap-2">
            <label>Senha <span class="text-red-500">*</span></label>
            <input
              class="w-full px-4 py-2 rounded-md border-2 border-zinc-200 outline-green-400"
              name="senha_usuario"
              placeholder="********"
              type="password"
              maxlength="50"
              required
            />
          </div>
        </div>
      </div>

      <button
        type="submit"
        name="adicionar_usuario"
        class="mt-4 px-4 py-2 bg-green-700 text-white font-bold rounded transition hover:bg-green-900 cursor-pointer"
      >
        Cadastrar
      </button>
    </form>
  </body>
</html>
