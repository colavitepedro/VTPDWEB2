<?php
declare(strict_types=1);

$gruposDeInteresses = [
    [
        "Esportes",
        "Futebol",
        "Basquete",
        "Tênis",
        "Taekwondo",
        "Tecnologia",
    ],
    [
        "Smartphones",
        "Computadores e hardware",
        "Desktop gamers",
        "Notebooks",
        "Veículos",
        "Escritório",
    ],
    [
        "Vestuário",
        "Perfumes",
        "Economia",
        "Comidas",
        "Bebidas",
        "Imóveis",
    ],
    [
        "Calçados",
        "Hotéis",
        "Pousadas",
        "Cinema",
        "Filmes",
        "Séries",
    ],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário</title>
  <link rel="stylesheet" href="../estilo.css">
</head>
<body>
  <main class="main-shell">
    <h1 class="page-title">Formulário</h1>
    <hr class="page-rule">

    <form method="POST" action="resultado.php" accept-charset="UTF-8" class="toolbar-form">
      <p class="section-label">Escolha alguns interesses:</p>

      <div class="interest-grid">
        <?php foreach ($gruposDeInteresses as $grupo): ?>
          <div class="checkbox-list">
            <?php foreach ($grupo as $interesse): ?>
              <label class="checkbox-line">
                <input
                  type="checkbox"
                  name="interesses[]"
                  value="<?= htmlspecialchars($interesse, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>"
                >
                <span><?= htmlspecialchars($interesse, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="actions">
        <button class="btn btn-primary" type="submit">Enviar</button>
        <button class="btn btn-warning" type="reset">Limpar</button>
      </div>
    </form>

    <p class="back-row"><a href="../index.php">Voltar para Aula 5</a></p>
  </main>
</body>
</html>
