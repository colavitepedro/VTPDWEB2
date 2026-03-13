<?php
declare(strict_types=1);

$numeroBruto = trim((string) ($_GET["numero"] ?? ""));
$numero = null;

if ($numeroBruto !== "" && preg_match("/^-?\\d+$/", $numeroBruto) === 1) {
    $numero = (int) $numeroBruto;
}

$ehPrimo = false;
$mensagemPrimo = "";
$mensagemParidade = "";
$badgeClass = "badge-red";

if ($numero !== null) {
    $ehPrimo = $numero > 1;

    if ($numero > 1) {
        for ($i = 2; $i < $numero; $i++) {
            if ($numero % $i === 0) {
                $ehPrimo = false;
                break;
            }
        }
    }

    if ($ehPrimo) {
        $mensagemPrimo = "é";
        $badgeClass = "badge-green";
    } else {
        $mensagemPrimo = "não é";
        $badgeClass = "badge-red";
    }

    if ($numero % 2 === 0) {
        $mensagemParidade = "PAR";
    } else {
        $mensagemParidade = "ÍMPAR";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Praticando 3 - Números primos</title>
  <link rel="stylesheet" href="../estilo.css">
</head>
<body>
  <main class="main-shell">
    <h1 class="page-title">Praticando 3 - Números primos</h1>
    <hr class="page-rule">

    <div class="number-links">
      <a href="?numero=1">Número 1</a>
      <a href="?numero=2">Número 2</a>
      <a href="?numero=3">Número 3</a>
      <a href="?numero=5">Número 5</a>
      <a href="?numero=20">Número 20</a>
      <a href="?numero=32">Número 32</a>
      <a href="?numero=37">Número 37</a>
    </div>

    <?php if ($numero !== null): ?>
      <div class="result-center">
        <p>
          O número
          <span class="badge-box <?= $badgeClass ?>"><?= $numero ?></span>
          <span class="badge-box <?= $badgeClass ?>"><?= htmlspecialchars($mensagemPrimo, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></span>
          um número
          <span class="badge-box <?= $badgeClass ?>">PRIMO</span>.
        </p>

        <p>
          Além disso ele é um número
          <span class="badge-box <?= $badgeClass ?>"><?= htmlspecialchars($mensagemParidade, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></span>
        </p>
      </div>
    <?php endif; ?>

    <p class="back-row"><a href="../index.php">Voltar para Aula 5</a></p>
  </main>
</body>
</html>
