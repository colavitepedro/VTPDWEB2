<?php
declare(strict_types=1);

$interessesRecebidos = $_POST["interesses"] ?? [];

if (!is_array($interessesRecebidos)) {
    $interessesRecebidos = [];
}

$dadosDaRequisicao = [];

foreach ($interessesRecebidos as $interesse) {
    if (!is_string($interesse)) {
        continue;
    }

    $interesseLimpo = trim($interesse);

    if ($interesseLimpo === "") {
        continue;
    }

    $dadosDaRequisicao[] = $interesseLimpo;
}

$interessesOrdenados = array_values(array_unique($dadosDaRequisicao));
sort($interessesOrdenados, SORT_NATURAL | SORT_FLAG_CASE);

$interessesExibidos = array_slice($interessesOrdenados, 0, 3);
$mostrarReticencias = count($interessesOrdenados) > 3;

ob_start();
var_dump($dadosDaRequisicao);
$dumpDaRequisicao = (string) ob_get_clean();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Destino</title>
  <link rel="stylesheet" href="../estilo.css">
</head>
<body>
  <main class="main-shell">
    <h1 class="page-title">Destino</h1>
    <hr class="page-rule">

    <div class="content-block">
      <h2 class="section-title">Dados da requisição:</h2>
      <pre class="dump-box"><?= htmlspecialchars($dumpDaRequisicao, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></pre>

      <h2 class="section-title">Interesses selecionados (em ordem alfabética)</h2>

      <?php if ($interessesOrdenados === []): ?>
        <p class="notice">Nenhum interesse foi selecionado.</p>
      <?php else: ?>
        <ul class="plain-list">
          <?php foreach ($interessesExibidos as $interesse): ?>
            <li><?= htmlspecialchars($interesse, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></li>
          <?php endforeach; ?>

          <?php if ($mostrarReticencias): ?>
            <li>...</li>
          <?php endif; ?>
        </ul>
      <?php endif; ?>
    </div>

    <p class="back-row"><a href="index.php">Voltar para o formulário</a></p>
  </main>
</body>
</html>
