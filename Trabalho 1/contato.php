<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$trackingMessage = register_page_view_with_feedback('contato');
$pageTitle = 'Contato | Trabalho 1';
$activePage = 'contato';

require __DIR__ . '/includes/header.php';
?>
<section class="page-intro page-panel page-panel--green">
  <p class="eyebrow">Contato</p>
  <h1 class="section-title">Canais para networking e retorno acadêmico</h1>
  <p class="section-lead">
    Esta página concentra formas simples de contato e resume o foco do projeto: desenvolvimento web com PHP,
    rastreabilidade de acessos.
  </p>
</section>

<?php if ($trackingMessage !== null): ?>
  <div class="feedback-banner feedback-banner--warning">
    <?= escape_html($trackingMessage) ?>
  </div>
<?php endif; ?>

<section class="content-grid">
  <article class="info-card page-panel page-panel--green">
    <p class="eyebrow">E-mail</p>
    <h2>Contato principal</h2>
    <p>
      <a class="inline-link" href="mailto:<?= escape_html(STUDENT_EMAIL) ?>"><?= escape_html(STUDENT_EMAIL) ?></a>
    </p>
    <p></p>
  </article>

  <article class="info-card page-panel page-panel--green">
    <p class="eyebrow">GitHub</p>
    <h2>Repositório da disciplina</h2>
    <p>
      <a class="inline-link" href="https://github.com/colavitepedro/VTPDWEB2" target="_blank" rel="noopener noreferrer">
        github.com/colavitepedro/VTPDWEB2
      </a>
    </p>
    <p>Repositório usado para versionar as atividades da disciplina e preparar a entrega final do trabalho.</p>
  </article>

  <article class="info-card page-panel page-panel--green">
    <p class="eyebrow">EC2</p>
    <h2>Publicação no EC2</h2>
    <p>
      A publicação do projeto no EC2 foi realizado usando o serviço de hospedagem da AWS, garantindo que as páginas estejam acessíveis via IP público da instância.

    </p>
  </article>
</section>

</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
