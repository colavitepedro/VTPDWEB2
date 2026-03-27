<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

exigir_autenticacao();

$pageTitle = 'Perfil';
$activePage = 'perfil';
$usuario = usuario_atual();
$flash = obter_flash();

require __DIR__ . '/includes/header.php';
?>
      <section class="hero-panel">
        <h1>Perfil do usuário</h1>
      </section>

      <?php if ($flash !== null && $flash['mensagem'] !== ''): ?>
        <div class="<?= classe_flash($flash['tipo']) ?>">
          <p><?= escapar($flash['mensagem']) ?></p>
        </div>
      <?php endif; ?>

      <section class="content-grid">
        <article class="text-card">
          <h2>Dados principais</h2>
          <ul class="profile-list">
            <li><strong>Nome:</strong> <?= escapar((string) ($usuario['nome'] ?? '')) ?></li>
            <li><strong>Login:</strong> <?= escapar((string) ($usuario['login'] ?? '')) ?></li>
            <li><strong>E-mail:</strong> <?= escapar((string) ($usuario['email'] ?? '')) ?></li>
            <li><strong>Telefone:</strong> <?= escapar((string) ($usuario['telefone'] ?? '')) ?></li>
            <li><strong>Endereço:</strong> <?= escapar((string) ($usuario['endereco'] ?? '')) ?></li>
            <li><strong>Curso:</strong> <?= escapar((string) ($usuario['curso'] ?? '')) ?></li>
            <li><strong>Autenticado em:</strong> <?= escapar((string) ($_SESSION['autenticado_em'] ?? '')) ?></li>
          </ul>
        </article>

        <article class="text-card accent-card">
          <h2>Descrição</h2>
          <p><?= escapar((string) ($usuario['bio'] ?? '')) ?></p>
          <p>Esta é a área restrita do site. Se a sessão não existir, o código redireciona automaticamente para a autenticação.</p>
        </article>
      </section>
<?php require __DIR__ . '/includes/footer.php'; ?>
