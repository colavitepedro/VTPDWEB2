<?php
declare(strict_types=1);

$pageTitle = "Início";
$activePage = "inicio";

require __DIR__ . "/includes/header.php";
?>
      <section class="hero-panel">
        <h1>Site exemplo com include e require</h1>
      </section>

      <section class="content-grid">
        <article class="text-card">
          <h2>Estrutura reutilizável</h2>
          <p>Este praticando separa o layout em cabeçalho, conteúdo e rodapé, reutilizando os mesmos arquivos em todas as páginas do site.</p>
          <p>O objetivo é manter o projeto organizado, facilitar manutenção e evitar repetição de código quando novas páginas forem adicionadas.</p>
        </article>

        <article class="text-card accent-card">
          <h2>O que foi implementado</h2>
          <ul class="feature-list">
            <li>Página inicial, Sobre, FAQs e Contato</li>
            <li>Menu com destaque da página ativa</li>
            <li>Formulário funcional de contato</li>
            <li>Página de destino com gravação em arquivo texto</li>
          </ul>
        </article>
      </section>
<?php require __DIR__ . "/includes/footer.php"; ?>
