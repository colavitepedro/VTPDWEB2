<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

redirecionar_se_autenticado();

$pageTitle = 'Entrar';
$activePage = 'entrar';
$flash = obter_flash();

require __DIR__ . '/includes/header.php';
?>
      <section class="hero-panel">
        <h1>Autenticação do usuário</h1>
      </section>

      <?php if ($flash !== null && $flash['mensagem'] !== ''): ?>
        <div class="<?= classe_flash($flash['tipo']) ?>">
          <p><?= escapar($flash['mensagem']) ?></p>
        </div>
      <?php endif; ?>

      <section class="form-panel">
        <form class="contact-form" method="POST" action="destino-login.php" accept-charset="UTF-8">
          <div class="form-grid">
            <div class="field-group">
              <label for="usuario">Usuário</label>
              <input
                type="text"
                id="usuario"
                name="usuario"
                placeholder="Digite o usuário"
                autocomplete="username"
                required
              >
            </div>

            <div class="field-group">
              <label for="senha">Senha</label>
              <input
                type="password"
                id="senha"
                name="senha"
                placeholder="Digite a senha"
                autocomplete="current-password"
                required
              >
            </div>
          </div>

          <div class="button-row centered-row">
            <button class="btn btn-primary" type="submit">Entrar</button>
            <button class="btn btn-warning" type="reset">Limpar</button>
          </div>
        </form>
      </section>


<?php require __DIR__ . '/includes/footer.php'; ?>
