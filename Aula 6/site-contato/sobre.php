<?php
declare(strict_types=1);

$pageTitle = "Sobre";
$activePage = "sobre";

require __DIR__ . "/includes/header.php";
?>
      <section class="hero-panel">
        <h1>Sobre</h1>
      </section>

      <section class="content-grid">
        <article class="text-card">
          <h2>Quem somos</h2>
          <p>Esta página simula uma seção institucional simples, feita para praticar a reutilização do layout com `require` no cabeçalho e no rodapé.</p>
          <p>O conteúdo é propositalmente enxuto: texto explicativo, uma imagem local e a mesma navegação compartilhada com as demais páginas.</p>
        </article>

        <figure class="image-card">
          <img src="assets/sobre.svg" alt="Ilustração da página Sobre">
        </figure>
      </section>
<?php require __DIR__ . "/includes/footer.php"; ?>
