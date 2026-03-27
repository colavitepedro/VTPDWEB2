<?php
declare(strict_types=1);

$pageTitle = $pageTitle ?? APP_NAME;
$activePage = $activePage ?? '';
$feedback = consume_feedback_message();
$bodyClass = 'page-' . ($activePage !== '' ? $activePage : 'default');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= escape_html($pageTitle) ?></title>
  <meta name="description" content="Projeto em PHP com contador de acessos, logs em arquivo de texto e autenticação por sessão.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&family=Source+Serif+4:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="<?= escape_html($bodyClass) ?>">
  <div class="site-shell">
    <header class="site-header">
      <a class="site-brand" href="index.php">
        <span class="site-brand__mark">P</span>
        <span class="site-brand__text">Pedro Colavite Conilho</span>
      </a>

      <nav class="site-nav" aria-label="Navegação principal">
        <?php foreach (internal_navigation() as $pageKey => $item): ?>
          <a class="<?= escape_html(nav_link_class($activePage, $pageKey)) ?>" href="<?= escape_html((string) $item['file']) ?>">
            <?= escape_html((string) $item['label']) ?>
          </a>
        <?php endforeach; ?>

        <?php if (is_logs_authenticated()): ?>
          <a class="site-nav__link site-nav__link--logout" href="sair.php">Sair</a>
        <?php endif; ?>
      </nav>
    </header>

    <main class="site-main">
      <?php if ($feedback !== null): ?>
        <div class="feedback-banner feedback-banner--<?= escape_html($feedback['type']) ?>">
          <?= escape_html($feedback['message']) ?>
        </div>
      <?php endif; ?>
