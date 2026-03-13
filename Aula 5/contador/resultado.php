<?php
declare(strict_types=1);

function read_int_post(string $key): ?int
{
    $value = trim((string) ($_POST[$key] ?? ""));

    if (preg_match("/^-?\\d+$/", $value) !== 1) {
        return null;
    }

    return (int) $value;
}

$inicio = read_int_post("inicio");
$final = read_int_post("final");
$incremento = read_int_post("incremento");
$dadosValidos = $inicio !== null && $final !== null && $incremento !== null && $incremento > 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contador</title>
  <link rel="stylesheet" href="../estilo.css">
  <style>
    .counter-subtitle {
      margin: 0 0 10px;
      font-size: 2rem;
      font-weight: 700;
    }

    .counter-line {
      margin: 0 0 14px;
      font-size: 1.12rem;
    }

    .counter-sequence {
      margin-top: 6px;
      font-size: 1.12rem;
    }
  </style>
</head>
<body>
  <main class="main-shell">
    <h1 class="page-title">Contador</h1>
    <hr class="page-rule">

    <?php if (!$dadosValidos): ?>
      <p class="notice">Envie valores inteiros válidos e use incremento maior que zero.</p>
    <?php else: ?>
      <h2 class="counter-subtitle">Parâmetros informados:</h2>
      <p class="counter-line">Início: <?= $inicio ?></p>
      <p class="counter-line">Final: <?= $final ?></p>
      <p class="counter-line">Incremento: <?= $incremento ?></p>
      <p class="counter-sequence">
        <?php if ($inicio <= $final): ?>
          <?php for ($i = $inicio; $i <= $final; $i += $incremento): ?>
            <?= $i ?><?= $i + $incremento <= $final ? " " : "" ?>
          <?php endfor; ?>
        <?php else: ?>
          <?php for ($i = $inicio; $i >= $final; $i -= $incremento): ?>
            <?= $i ?><?= $i - $incremento >= $final ? " " : "" ?>
          <?php endfor; ?>
        <?php endif; ?>
      </p>
    <?php endif; ?>

    <p class="back-row"><a href="index.php">Voltar</a></p>
  </main>
</body>
</html>
