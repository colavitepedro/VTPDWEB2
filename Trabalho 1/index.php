<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= escape_html(APP_NAME) ?></title>
  <meta name="description" content="Página inicial do servidor da disciplina com acesso ao projeto de CEP e ao Trabalho 1 em PHP.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&family=Source+Serif+4:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="page-home">
  <div class="site-shell">
    <main class="landing-main">
      <h1 class="landing-title"><?= escape_html(APP_NAME) ?></h1>

      <section class="landing-panel">
        <div class="landing-panel__left">
          <div class="profile-card">
            <img class="profile-card__photo" src="<?= escape_html(STUDENT_PHOTO) ?>" alt="Foto do aluno Pedro Colavite Conilho">
            <p class="eyebrow">Aluno</p>
            <h2><?= escape_html(STUDENT_NAME) ?></h2>
          </div>
        </div>

        <div class="landing-panel__right">
          <h2 class="landing-links-title">Links</h2>
          <div class="link-stack">
            <a class="feature-link" href="<?= escape_html(CEP_ACTIVITY_URL) ?>">
              <span class="feature-link__label">Praticando Busca CEP</span>
              <span class="feature-link__note">Link para a atividade da Aula 7.</span>
            </a>

            <a class="feature-link" href="inicio.php">
              <span class="feature-link__label">Trabalho 1 – Contador de Acessos</span>
              <span class="feature-link__note">Site com três páginas monitoradas, logs e autenticação por sessão.</span>
            </a>
          </div>
        </div>
      </section>
    </main>

    <footer class="site-footer">
      <p class="site-footer__title">Trabalho T1 - VTPDWE2 &amp; VTPISRV</p>
      <p><?= escape_html(STUDENT_NAME) ?></p>
      <a href="mailto:<?= escape_html(STUDENT_EMAIL) ?>"><?= escape_html(STUDENT_EMAIL) ?></a>
    </footer>
  </div>
</body>
</html>
