<?php
declare(strict_types=1);

require_once __DIR__ . "/funcoes.php";

$pageTitle = $pageTitle ?? "Site com contato";
$activePage = $activePage ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= escapar($pageTitle) ?></title>
  <link rel="stylesheet" href="assets/site.css">
</head>
<body>
  <div class="site-shell">
    <header class="site-header">
      <a class="brand" href="index.php">
        <span class="brand-mark">P</span>
        <span class="brand-text">Pedro Colavite Conilho</span>
      </a>

      <nav class="main-nav" aria-label="Principal">
        <a class="<?= classe_nav($activePage, "inicio") ?>" href="index.php">Início</a>
        <a class="<?= classe_nav($activePage, "sobre") ?>" href="sobre.php">Sobre</a>
        <a class="<?= classe_nav($activePage, "faqs") ?>" href="faqs.php">FAQs</a>
        <a class="<?= classe_nav($activePage, "contato") ?>" href="contato.php">Contato</a>
      </nav>
    </header>

    <main class="site-content">
