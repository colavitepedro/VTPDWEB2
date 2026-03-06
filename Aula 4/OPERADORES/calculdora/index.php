<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calculadora de média</title>
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
      margin: 0 0 12px;
      font-size: 28px;
    }

    p {
      margin: 0 0 20px;
    }

    form {
      border: 1px solid #cccccc;
      padding: 20px;
    }

    .campo {
      margin-bottom: 16px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }

    input {
      width: 100%;
      max-width: 220px;
      padding: 8px;
      border: 1px solid #999999;
      font: inherit;
    }

    button {
      padding: 8px 14px;
      border: 1px solid #999999;
      background: #f3f3f3;
      color: #000000;
      font: inherit;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <main>
    <h1>Calculadora de média</h1>
    <p>Informe três notas. Use valores de 0 a 10 com passo de 0,5.</p>

    <form method="POST" action="resultado-media.php" accept-charset="UTF-8">
      <div class="campo">
        <label for="nota1">Nota 1</label>
        <input type="number" id="nota1" name="nota1" min="0" max="10" step="0.5" required>
      </div>

      <div class="campo">
        <label for="nota2">Nota 2</label>
        <input type="number" id="nota2" name="nota2" min="0" max="10" step="0.5" required>
      </div>

      <div class="campo">
        <label for="nota3">Nota 3</label>
        <input type="number" id="nota3" name="nota3" min="0" max="10" step="0.5" required>
      </div>

      <button type="submit">Calcular média</button>
    </form>
  </main>
</body>
</html>
