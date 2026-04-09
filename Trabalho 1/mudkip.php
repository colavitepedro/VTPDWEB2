<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$pokemon = POKEDEX_PAGINAS['mudkip'];
$mensagemRegistro = registrar_acesso_com_mensagem('mudkip');
$tituloPagina = $pokemon['nome'] . ' | Trabalho 1';
$paginaAtiva = 'mudkip';

require __DIR__ . '/includes/header.php';
?>
<section class="page-intro page-panel pokemon-apresentacao">
  <div class="pokemon-apresentacao__cabecalho">
    <div>
      <p class="eyebrow"><?= escapar((string) $pokemon['estagio']) ?></p>
      <h1 class="section-title"><?= escapar((string) $pokemon['nome']) ?></h1>
      <p class="section-lead">
        <?= escapar((string) $pokemon['papel']) ?>
      </p>
    </div>

    <div class="pokemon-badges">
      <span class="pokemon-badge"><?= escapar((string) $pokemon['numero']) ?></span>
      <span class="pokemon-badge"><?= escapar((string) $pokemon['categoria']) ?></span>
    </div>
  </div>
</section>

<?php if ($mensagemRegistro !== null): ?>
  <div class="feedback-banner feedback-banner--warning">
    <?= escapar($mensagemRegistro) ?>
  </div>
<?php endif; ?>

<section class="detail-card page-panel detail-card--split pokemon-ficha">
  <div class="pokemon-ilustracao">
    <img class="pokemon-ilustracao__imagem" src="<?= escapar((string) $pokemon['imagem']) ?>" alt="Arte oficial do <?= escapar((string) $pokemon['nome']) ?>">
  </div>

  <div class="pokemon-ficha__conteudo">
    <article class="pokemon-bloco">
      <p class="eyebrow">Descrição da Pokédex</p>
      <h2>Entrada oficial</h2>
      <p class="pokemon-texto">
        <?= escapar((string) $pokemon['descricao']) ?>
      </p>
    </article>

    <article class="pokemon-bloco">
      <p class="eyebrow">Tipos e medidas</p>
      <h2>Ficha principal</h2>
      <div class="pokemon-tipos">
        <?php foreach ($pokemon['tipos'] as $tipo): ?>
          <span class="pokemon-chip"><?= escapar((string) $tipo) ?></span>
        <?php endforeach; ?>
      </div>

      <dl class="pokemon-medidas">
        <div>
          <dt>Categoria</dt>
          <dd><?= escapar((string) $pokemon['categoria']) ?></dd>
        </div>
        <div>
          <dt>Altura</dt>
          <dd><?= escapar((string) $pokemon['altura']) ?></dd>
        </div>
        <div>
          <dt>Peso</dt>
          <dd><?= escapar((string) $pokemon['peso']) ?></dd>
        </div>
      </dl>
    </article>

    <article class="pokemon-bloco">
      <p class="eyebrow">Habilidades</p>
      <h2>Capacidades naturais</h2>
      <ul class="check-list pokemon-lista">
        <?php foreach ($pokemon['habilidades'] as $habilidade): ?>
          <li><?= escapar((string) $habilidade) ?></li>
        <?php endforeach; ?>
      </ul>
    </article>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
