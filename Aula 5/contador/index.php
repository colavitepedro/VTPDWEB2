<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contador</title>
  <link rel="stylesheet" href="../estilo.css">
</head>
<body>
  <main class="main-shell">
    <h1 class="page-title">Contador</h1>
    <hr class="page-rule">

    <form method="POST" action="resultado.php" accept-charset="UTF-8" class="toolbar-form">
      <div class="toolbar">
        <div class="field-inline">
          <label for="inicio">Início:</label>
          <input class="control" type="number" id="inicio" name="inicio" step="1" required>
        </div>

        <div class="field-inline">
          <label for="final">Final:</label>
          <input class="control" type="number" id="final" name="final" step="1" required>
        </div>

        <div class="field-inline">
          <label for="incremento">Incremento:</label>
          <input class="control" type="number" id="incremento" name="incremento" step="1" min="1" required>
        </div>
      </div>

      <div class="actions">
        <button class="btn btn-success" type="submit">Enviar</button>
        <a class="btn btn-warning" href="index.php">Limpar</a>
      </div>
    </form>

    <p class="back-row"><a href="../index.php">Voltar para Aula 5</a></p>
  </main>
</body>
</html>
