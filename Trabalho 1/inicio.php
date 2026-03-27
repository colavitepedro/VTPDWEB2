<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$trackingMessage = register_page_view_with_feedback('inicio');
$pageTitle = 'Início | Trabalho 1';
$activePage = 'inicio';

require __DIR__ . '/includes/header.php';
?>
<section class="hero-card page-panel page-panel--green">
  <div>
    <p class="eyebrow">Projeto PHP</p>
    <h1 class="section-title">Contador de acessos com persistência em arquivos de texto</h1>
    <p class="section-lead">
      Este site foi pensado para demonstrar navegação entre páginas, controle de visualizações por arquivo
      e uma área restrita para auditoria dos acessos registrados.
    </p>
  </div>

  <div class="hero-card__aside">
    <span class="metric-tag">Tela inicial</span>
    <span class="metric-tag">Logs com IP e navegador</span>
    <span class="metric-tag">Sessão protegida</span>
  </div>
</section>

<?php if ($trackingMessage !== null): ?>
  <div class="feedback-banner feedback-banner--warning">
    <?= escape_html($trackingMessage) ?>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>