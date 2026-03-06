<?php
declare(strict_types=1);

function read_grade(string $key): ?float
{
    $rawValue = trim((string) ($_POST[$key] ?? ""));

    if ($rawValue === "" || !is_numeric($rawValue)) {
        return null;
    }

    $value = (float) $rawValue;

    if ($value < 0 || $value > 10) {
        return null;
    }

    return $value;
}

$nota1 = read_grade("nota1");
$nota2 = read_grade("nota2");
$nota3 = read_grade("nota3");

$notasValidas = $nota1 !== null && $nota2 !== null && $nota3 !== null;

$media = null;
$status = "";
$descricao = "";
$statusClass = "";

if ($notasValidas) {
    $media = ($nota1 + $nota2 + $nota3) / 3;

    if ($media < 4) {
        $status = "Reprovado";
        $descricao = "A média ficou abaixo de 4.";
        $statusClass = "status-reprovado";
    } elseif ($media < 6) {
        $status = "Recuperação";
        $descricao = "A média ficou entre 4 e 6.";
        $statusClass = "status-recuperacao";
    } else {
        $status = "Aprovado";
        $descricao = "A média foi igual ou superior a 6.";
        $statusClass = "status-aprovado";
    }
}

function format_grade(?float $value): string
{
    if ($value === null) {
        return "--";
    }

    return number_format($value, 1, ",", ".");
}

function format_average(?float $value): string
{
    if ($value === null) {
        return "--";
    }

    return number_format($value, 2, ",", ".");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultado da média</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      background: #ffffff;
      color: #000000;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 16px;
      line-height: 1.5;
    }

    main {
      max-width: 680px;
      margin: 40px auto;
      padding: 0 16px;
    }

    h1 {
      margin: 0 0 16px;
      font-size: 28px;
    }

    .bloco {
      border: 1px solid #cccccc;
      padding: 20px;
      margin-bottom: 16px;
    }

    p {
      margin: 0 0 10px;
    }

    .status {
      font-weight: bold;
    }

    .reprovado {
      color: #c00000;
    }

    .recuperacao {
      color: #c77900;
    }

    .aprovado {
      color: #008000;
    }

    .invalido {
      color: #444444;
    }

    a {
      color: #0000ee;
    }
  </style>
</head>
<body>
  <main>
    <h1>Resultado da média</h1>
    <div class="bloco">
      <p>Nota 1: <?= htmlspecialchars(format_grade($nota1), ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></p>
      <p>Nota 2: <?= htmlspecialchars(format_grade($nota2), ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></p>
      <p>Nota 3: <?= htmlspecialchars(format_grade($nota3), ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></p>
      <p>Média: <?= htmlspecialchars(format_average($media), ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></p>
    </div>

    <?php if ($notasValidas): ?>
      <div class="bloco">
        <p>A média final é <?= htmlspecialchars(format_average($media), ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>.</p>
        <p class="status <?= htmlspecialchars(str_replace('status-', '', $statusClass), ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>">
          Situação: <?= htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>
        </p>
        <p><?= htmlspecialchars($descricao, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></p>
      </div>
    <?php else: ?>
      <div class="bloco">
        <p class="status invalido">Dados inválidos</p>
        <p>Envie três notas numéricas entre 0 e 10 para calcular a média corretamente.</p>
      </div>
    <?php endif; ?>

    <p><a href="index.php">Voltar</a></p>
  </main>
</body>
</html>
