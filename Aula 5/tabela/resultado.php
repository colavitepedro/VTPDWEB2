<?php
declare(strict_types=1);

function read_int_post(string $key): ?int
{
    $value = trim((string) ($_POST[$key] ?? ""));

    if (preg_match("/^\\d+$/", $value) !== 1) {
        return null;
    }

    return (int) $value;
}

$linhas = read_int_post("linhas");
$colunas = read_int_post("colunas");
$estilo = trim((string) ($_POST["estilo"] ?? ""));
$dadosValidos = $linhas !== null && $colunas !== null && $linhas > 0 && $colunas > 0 && $linhas <= 20 && $colunas <= 20;
$estilosPermitidos = [
    "table-primary",
    "table-secondary",
    "table-success",
    "table-danger",
    "table-warning",
    "table-info",
    "table-light",
];
$classeTabela = in_array($estilo, $estilosPermitidos, true) ? $estilo : "table-primary";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tabela gerada</title>
  <link rel="stylesheet" href="../estilo.css">
</head>
<body>
  <main class="main-shell">
    <h1 class="page-title">Praticando 4 - Gerador de tabela</h1>
    <hr class="page-rule">

    <?php if (!$dadosValidos): ?>
      <p class="notice">Informe valores entre 1 e 20 para linhas e colunas.</p>
    <?php else: ?>
      <h2 class="table-heading">Tabela <?= $linhas ?>x<?= $colunas ?></h2>

      <div class="table-wrap">
        <table class="generated-table <?= htmlspecialchars($classeTabela, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>">
          <?php for ($linha = 1; $linha <= $linhas; $linha++): ?>
            <tr>
              <?php for ($coluna = 1; $coluna <= $colunas; $coluna++): ?>
                <td>-</td>
              <?php endfor; ?>
            </tr>
          <?php endfor; ?>
        </table>
      </div>
    <?php endif; ?>

    <p class="back-row"><a href="index.php">Voltar</a></p>
  </main>
</body>
</html>
