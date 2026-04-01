<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$mensagemRegistro = registrar_acesso_com_mensagem('sobre');
$tituloPagina = 'Sobre | Trabalho 1';
$paginaAtiva = 'sobre';

require __DIR__ . '/includes/header.php';
?>
<section class="page-intro page-panel page-panel--green">
    <p class="eyebrow">Sobre</p>
  <h1 class="section-title">Sobre</h1>
  <p class="section-lead">
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa id cupiditate expedita esse, ducimus, doloribus consequuntur iure consectetur ea facere debitis aliquid laboriosam voluptatibus explicabo nostrum tenetur quibusdam unde rerum.
  </p>
</section>

<?php if ($mensagemRegistro !== null): ?>
  <div class="feedback-banner feedback-banner--warning">
    <?= escapar($mensagemRegistro) ?>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>