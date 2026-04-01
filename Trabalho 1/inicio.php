<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$mensagemRegistro = registrar_acesso_com_mensagem('inicio');
$tituloPagina = 'Início | Trabalho 1';
$paginaAtiva = 'inicio';

require __DIR__ . '/includes/header.php';
?>
<section class="hero-card page-panel page-panel--green">
  <div>
    <p class="eyebrow">Projeto PHP</p>
    <h1 class="section-title">Contador de acessos com persistência em arquivos de texto</h1>
  </div>

  <div class="hero-card__aside">
    <span class="metric-tag">Tela inicial</span>
    <span class="metric-tag">Logs com IP e navegador</span>
    <span class="metric-tag">Sessão protegida</span>
  </div>
</section>

<?php if ($mensagemRegistro !== null): ?>
  <div class="feedback-banner feedback-banner--warning">
    <?= escapar($mensagemRegistro) ?>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
