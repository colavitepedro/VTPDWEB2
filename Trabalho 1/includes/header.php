<?php
declare(strict_types=1);

$tituloPagina = $tituloPagina ?? NOME_APLICACAO;
$paginaAtiva = $paginaAtiva ?? '';
$mensagemFeedback = obter_mensagem();
$classeCorpo = 'page-' . ($paginaAtiva !== '' ? $paginaAtiva : 'default');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= escapar($tituloPagina) ?></title>
  <meta name="description" content="Projeto em PHP com contador de acessos, logs em arquivo de texto e autenticação por sessão.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&family=Source+Serif+4:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="<?= escapar($classeCorpo) ?>">
  <div class="site-shell">
    <header class="site-header">
      <a class="site-brand" href="index.php">
        <span class="site-brand__mark">P</span>
        <span class="site-brand__text">Pedro Colavite Conilho</span>
      </a>

      <nav class="site-nav" aria-label="Navegação principal">
        <?php foreach (MENU_PRINCIPAL as $chavePagina => $item): ?>
          <a class="<?= escapar(classe_link_navegacao($paginaAtiva, $chavePagina)) ?>" href="<?= escapar((string) $item['arquivo']) ?>">
            <?= escapar((string) $item['rotulo']) ?>
          </a>
        <?php endforeach; ?>

        <?php if (esta_logado_nos_logs()): ?>
          <a class="site-nav__link site-nav__link--logout" href="sair.php">Sair</a>
        <?php endif; ?>
      </nav>
    </header>

    <main class="site-main">
      <?php if ($mensagemFeedback !== null): ?>
        <div class="feedback-banner feedback-banner--<?= escapar($mensagemFeedback['tipo']) ?>">
          <?= escapar($mensagemFeedback['texto']) ?>
        </div>
      <?php endif; ?>
