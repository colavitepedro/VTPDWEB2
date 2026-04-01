<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$mensagemRegistro = registrar_acesso_com_mensagem('contato');
$tituloPagina = 'Contato | Trabalho 1';
$paginaAtiva = 'contato';

require __DIR__ . '/includes/header.php';
?>
<section class="page-intro page-panel page-panel--green">
  <p class="eyebrow">Contato</p>
  <h1 class="section-title">Contato</h1>
</section>

<?php if ($mensagemRegistro !== null): ?>
  <div class="feedback-banner feedback-banner--warning">
    <?= escapar($mensagemRegistro) ?>
  </div>
<?php endif; ?>

<section class="content-grid">
  <article class="info-card page-panel page-panel--green">
    <p class="eyebrow">E-mail</p>
    <h2>Contato principal</h2>
    <p>
      <a class="inline-link" href="mailto:<?= escapar(EMAIL_ALUNO) ?>"><?= escapar(EMAIL_ALUNO) ?></a>
    </p>
  </article>

  <article class="info-card page-panel page-panel--green">
    <p class="eyebrow">GitHub</p>
    <h2>Repositório da entrega</h2>
    <p>
      <a class="inline-link" href="https://github.com/colavitepedro/VTPDWE2-SERVER" target="_blank" rel="noopener noreferrer">
        github.com/colavitepedro/VTPDWE2-SERVER
      </a>
    </p>
  </article>

  <article class="info-card page-panel page-panel--green">
    <p class="eyebrow">EC2</p>
    <h2>Publicação no EC2</h2>
    <p>
      Usando a AWS Academy
    </p>
  </article>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
