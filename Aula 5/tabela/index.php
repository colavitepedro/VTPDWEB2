<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Praticando 4 - Gerador de tabela</title>
  <link rel="stylesheet" href="../estilo.css">
</head>
<body>
  <main class="main-shell">
    <h1 class="page-title">Praticando 4 - Gerador de tabela</h1>
    <hr class="page-rule">

    <form method="POST" action="resultado.php" accept-charset="UTF-8" class="toolbar-form">
      <div class="toolbar">
        <div class="field-inline">
          <label for="linhas">Linhas:</label>
          <input class="control" type="number" id="linhas" name="linhas" min="1" max="20" step="1" required>
        </div>

        <div class="field-inline">
          <label for="colunas">Colunas:</label>
          <input class="control" type="number" id="colunas" name="colunas" min="1" max="20" step="1" required>
        </div>

        <div class="field-inline">
          <label for="estilo">Estilo:</label>
          <select class="control" id="estilo" name="estilo" required>
            <option value="table-primary">table-primary</option>
            <option value="table-secondary">table-secondary</option>
            <option value="table-success">table-success</option>
            <option value="table-danger">table-danger</option>
            <option value="table-warning">table-warning</option>
            <option value="table-info">table-info</option>
            <option value="table-light">table-light</option>
          </select>
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
