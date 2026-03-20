<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Praticando - Verificação de email</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/site.css">
</head>
<body>
  <main class="page-shell">
    <header class="page-heading">
      <p class="eyebrow"></p>
      <h1>Praticando - Verificação de email</h1>
    </header>

    <section class="form-section">
      <form id="emailForm" class="email-check-form" novalidate>
        <label class="form-label fw-semibold" for="email">Informe seu melhor e-mail</label>

        <div class="input-group input-group-lg flex-nowrap">
          <input class="form-control" type="email" id="email" name="email" placeholder="email@address.com" autocomplete="email">
          <button class="btn btn-primary px-4" type="submit" id="emailSubmitButton">Verificar</button>
        </div>

        <div id="emailFeedback" class="feedback-text small mt-2" aria-live="polite"></div>
      </form>
    </section>

    <a class="back-link" href="index.php">Voltar ao menu</a>
  </main>

  <footer class="page-footer" aria-hidden="true"></footer>

  <script src="assets/verificacao-email.js"></script>
</body>
</html>
