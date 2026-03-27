<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Início';
$activePage = 'inicio';
$flash = obter_flash();
$usuario = usuario_atual();

require __DIR__ . '/includes/header.php';
?>
      <section class="hero-panel">
        <h1>Praticando da Aula 8</h1>
      </section>

      <?php if ($flash !== null && $flash['mensagem'] !== ''): ?>
        <div class="<?= classe_flash($flash['tipo']) ?>">
          <p><?= escapar($flash['mensagem']) ?></p>
        </div>
      <?php endif; ?>

      <section class="content-grid">
        <article class="text-card">
          <h2>Lorem</h2>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam aperiam blanditiis quod at pariatur ducimus, est nam fugit, velit necessitatibus unde neque! Sequi tenetur assumenda unde magni aspernatur, neque natus?</p>
        </article>

        <article class="text-card accent-card">
          <?php if ($usuario !== null): ?>
            <h2>Você está autenticado</h2>
            <ul class="feature-list">
              <li>Nome: <?= escapar((string) ($usuario['nome'] ?? '')) ?></li>
              <li>Login: <?= escapar((string) ($usuario['login'] ?? '')) ?></li>
              <li>Autenticado em: <?= escapar((string) ($_SESSION['autenticado_em'] ?? '')) ?></li>
              <li><a href="perfil.php">Acessar a página de perfil</a></li>
            </ul>
          <?php else: ?>
            <h2>Credenciais para teste</h2>
            <ul class="feature-list">
              <li>Usuário: <?= escapar(LOGIN_DEMO) ?></li>
              <li>Senha: <?= escapar(SENHA_DEMO) ?></li>
              <li><a href="entrar.php">Ir para a página Entrar</a></li>
            </ul>
          <?php endif; ?>
        </article>
      </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
