<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= escapar(NOME_APLICACAO) ?></title>
  <meta name="description" content="Página inicial do servidor da disciplina com acesso ao projeto de CEP e ao Trabalho 1 em PHP.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&family=Source+Serif+4:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="page-home">
  <div class="site-shell">
    <main class="landing-main">
      <h1 class="landing-title"><?= escapar(NOME_APLICACAO) ?></h1>

      <section class="landing-panel">
        <div class="landing-panel__left">
          <div class="profile-card">
            <img class="profile-card__photo" src="<?= escapar(FOTO_ALUNO) ?>" alt="Foto do aluno Pedro Colavite Conilho">
            <p class="eyebrow">Aluno</p>
            <h2><?= escapar(NOME_ALUNO) ?></h2>
          </div>
        </div>

        <div class="landing-panel__right">
          <h2 class="landing-links-title">Links</h2>
          <div class="link-stack">
            <a class="feature-link" href="<?= escapar(URL_ATIVIDADE_CEP) ?>">
              <span class="feature-link__label">Praticando Busca CEP</span>
            </a>

            <a class="feature-link" href="inicio.php">
              <span class="feature-link__label">Trabalho 1 - Contador de Acessos</span>
            </a>
          </div>
        </div>
      </section>
    </main>

    <footer class="site-footer">
      <p class="site-footer__title">Trabalho T1 - VTPDWE2 &amp; VTPISRV</p>
      <p><?= escapar(NOME_ALUNO) ?></p>
      <a href="mailto:<?= escapar(EMAIL_ALUNO) ?>"><?= escapar(EMAIL_ALUNO) ?></a>
    </footer>
  </div>
</body>
</html>
