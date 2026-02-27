<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aula 4 - Formulario POST</title>
  <style>
    :root {
      --bg: #f5f7fb;
      --card: #ffffff;
      --text: #1f2937;
      --line: #d1d5db;
      --accent: #111827;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 24px;
    }

    main {
      width: 100%;
      max-width: 720px;
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 24px;
    }

    h1 {
      margin-top: 0;
      margin-bottom: 8px;
      font-size: 1.6rem;
    }

    p {
      margin-top: 0;
      color: #4b5563;
    }

    form {
      display: grid;
      gap: 14px;
    }

    label {
      display: block;
      font-weight: 600;
      margin-bottom: 6px;
    }

    input,
    textarea {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid var(--line);
      border-radius: 8px;
      font: inherit;
    }

    input[type="color"] {
      padding: 4px;
      height: 42px;
    }

    textarea {
      resize: vertical;
      min-height: 140px;
    }

    button {
      justify-self: start;
      border: 0;
      border-radius: 8px;
      padding: 10px 16px;
      background: var(--accent);
      color: #fff;
      font: inherit;
      cursor: pointer;
    }

    button:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <main>
    <h1>Pratica - Requisicoes POST</h1>
    <p>Preencha os campos para gerar a pagina de destino.</p>

    <form method="POST" action="destino.php" accept-charset="UTF-8">
      <div>
        <label for="titulo">Titulo da pagina</label>
        <input type="text" id="titulo" name="titulo" required>
      </div>

      <div>
        <label for="corpo">Corpo</label>
        <textarea id="corpo" name="corpo" rows="8" required></textarea>
      </div>

      <div>
        <label for="cor_texto">Cor do texto</label>
        <input type="color" id="cor_texto" name="cor_texto" value="#000000" required>
      </div>

      <div>
        <label for="url_imagem">URL de uma imagem</label>
        <input type="url" id="url_imagem" name="url_imagem" placeholder="https://..." required>
      </div>

      <div>
        <label for="url_link">URL de link</label>
        <input type="url" id="url_link" name="url_link" placeholder="https://..." required>
      </div>

      <div>
        <label for="cor_fundo">Cor de plano de fundo da pagina</label>
        <input type="color" id="cor_fundo" name="cor_fundo" value="#ffffff" required>
      </div>

      <button type="submit">Enviar</button>
    </form>
  </main>
</body>
</html>
