<?php
declare(strict_types=1);

$numeroBruto = trim((string) ($_GET["numero"] ?? ""));
$numero = null;

if ($numeroBruto !== "" && preg_match("/^-?\\d+$/", $numeroBruto) === 1) {
    $numero = (int) $numeroBruto;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tabuada</title>
  <link rel="stylesheet" href="../estilo.css">
  <style>
    .tabuada-bloco {
      margin-top: 1.5rem;
    }

    .tabuada-bloco h2 {
      margin: 0 0 14px;
      font-size: 2.2rem;
      font-weight: 600;
    }

    .tabuada-bloco p {
      margin: 0 0 0.9rem;
      font-size: 1.1rem;
    }
  </style>
</head>
<body>
  <main class="main-shell">
    <h1 class="page-title">Tabuada</h1>
    <hr class="page-rule">

    <form method="GET" action="" accept-charset="UTF-8" class="toolbar-form">
      <div class="toolbar">
        <div class="field-inline">
          <label for="numero">Número:</label>
          <input
            class="control"
            type="number"
            id="numero"
            name="numero"
            step="1"
            required
            value="<?= htmlspecialchars($numeroBruto, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>"
          >
        </div>
      </div>

      <div class="actions actions-offset">
        <button class="btn btn-success" type="submit">Enviar</button>
        <a class="btn btn-warning" href="index.php">Limpar</a>
      </div>
    </form>

    <?php if ($numeroBruto !== "" && $numero === null): ?>
      <p class="notice">Informe um número inteiro válido.</p>
    <?php endif; ?>

    <?php if ($numero !== null): ?>
      <div class="tabuada-bloco">
        <h2>Tabuada do <?= htmlspecialchars((string) $numero, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></h2>
        <?php for ($i = 1; $i <= 10; $i++): ?>
          <p><?= $numero ?> x <?= $i ?> = <?= $numero * $i ?></p>
        <?php endfor; ?>
      </div>
    <?php endif; ?>

    <p class="back-row"><a href="../index.php">Voltar para Aula 5</a></p>
  </main>
</body>
</html>
