<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Logs de Acesso | Trabalho 1';
$activePage = 'logs';
$loginError = null;
$dashboardError = null;

if (is_post_request()) {
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'login') {
        $secret = (string) ($_POST['secret_key'] ?? '');

        if (attempt_logs_login($secret)) {
            set_feedback_message('Autenticação realizada com sucesso.', 'success');
            redirect_to('logs.php');
        }

        $loginError = 'Palavra-chave incorreta. Tente novamente.';
    } elseif (!is_logs_authenticated()) {
        set_feedback_message('Tentativa de acesso indevido detectada. Faça login para continuar.', 'danger');
        redirect_to('logs.php');
    } elseif (!is_valid_csrf_token($_POST['csrf_token'] ?? null)) {
        set_feedback_message('Não foi possível validar a ação solicitada. Atualize a página e tente de novo.', 'danger');
        redirect_to('logs.php');
    } else {
        try {
            if ($action === 'clear_counter') {
                $pageKey = (string) ($_POST['page_key'] ?? '');
                $page = tracked_page($pageKey);
                clear_single_counter($pageKey);
                set_feedback_message('O contador da página "' . $page['label'] . '" foi zerado.', 'success');
            } elseif ($action === 'clear_all_counters') {
                clear_all_counters();
                set_feedback_message('Todos os contadores de acesso foram zerados.', 'success');
            } elseif ($action === 'clear_logs') {
                clear_access_logs();
                set_feedback_message('O arquivo de logs foi limpo com sucesso.', 'success');
            } else {
                set_feedback_message('Ação inválida.', 'danger');
            }
        } catch (Throwable $throwable) {
            set_feedback_message('Não foi possível concluir a ação solicitada nos arquivos de controle.', 'danger');
        }

        redirect_to('logs.php');
    }
}

$dashboard = [
    'pages' => [],
    'total' => 0,
    'logs' => [],
];

if (is_logs_authenticated()) {
    try {
        $dashboard = access_dashboard_data();
    } catch (Throwable $throwable) {
        $dashboardError = 'A autenticação foi concluída, mas os dados do painel não puderam ser carregados.';
    }
}

require __DIR__ . '/includes/header.php';
?>


<?php if (!is_logs_authenticated()): ?>
  <section class="login-panel page-panel page-panel--pink">
    <div class="login-panel__content">
      <p class="eyebrow">Autenticação</p>
      <h2>Informe a chave de acesso</h2>
      <p>Use a palavra-chave definida no enunciado para consultar os registros e as estatísticas do projeto.</p>

      <?php if ($loginError !== null): ?>
        <div class="feedback-banner feedback-banner--danger">
          <?= escape_html($loginError) ?>
        </div>
      <?php endif; ?>

      <form class="login-form" method="post" action="logs.php">
        <input type="hidden" name="action" value="login">

        <label class="field-label" for="secret_key">Chave de acesso</label>
        <input
          class="text-input"
          type="password"
          id="secret_key"
          name="secret_key"
          placeholder="Digite a chave"
          autocomplete="current-password"
          required
        >

        <button class="action-button" type="submit">Entrar</button>
      </form>
    </div>
  </section>
<?php else: ?>
  <?php if ($dashboardError !== null): ?>
    <div class="feedback-banner feedback-banner--warning">
      <?= escape_html($dashboardError) ?>
    </div>
  <?php endif; ?>

  <section class="stats-grid">
    <article class="summary-card page-panel page-panel--pink">
      <p class="eyebrow">Total geral</p>
      <h2><?= escape_html((string) $dashboard['total']) ?></h2>
      <p>Soma de todas as visualizações monitoradas entre as três páginas do site.</p>
    </article>

    <article class="summary-card summary-card--wide page-panel page-panel--pink">
      <div class="summary-card__header">
        <div>
          <p class="eyebrow">Contadores por página</p>
          <h2>Ordem decrescente de acessos</h2>
        </div>

        <form method="post" action="logs.php" onsubmit="return confirm('Deseja realmente zerar todos os contadores?');">
          <input type="hidden" name="action" value="clear_all_counters">
          <?= csrf_field() ?>
          <button class="action-button action-button--ghost" type="submit">Zerar tudo</button>
        </form>
      </div>

      <div class="counter-list">
        <?php foreach ($dashboard['pages'] as $page): ?>
          <div class="counter-list__item">
            <div>
              <h3><?= escape_html((string) $page['label']) ?></h3>
              <p><?= escape_html((string) $page['summary']) ?></p>
            </div>

            <div class="counter-list__actions">
              <strong><?= escape_html((string) $page['count']) ?></strong>

              <form method="post" action="logs.php" onsubmit="return confirm('Deseja zerar somente o contador desta página?');">
                <input type="hidden" name="action" value="clear_counter">
                <input type="hidden" name="page_key" value="<?= escape_html((string) $page['key']) ?>">
                <?= csrf_field() ?>
                <button class="action-button action-button--ghost" type="submit">Limpar página</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </article>
  </section>

  <section class="logs-card page-panel page-panel--pink">
    <div class="summary-card__header">
      <div>
        <p class="eyebrow">Registros</p>
        <h2>Histórico de acessos</h2>
      </div>

      <form method="post" action="logs.php" onsubmit="return confirm('Deseja apagar todos os registros de acesso?');">
        <input type="hidden" name="action" value="clear_logs">
        <?= csrf_field() ?>
        <button class="action-button action-button--danger" type="submit">Limpar logs</button>
      </form>
    </div>

    <?php if ($dashboard['logs'] === []): ?>
      <p class="empty-state">Ainda não existem registros de acesso para exibir.</p>
    <?php else: ?>
      <div class="table-wrapper">
        <table class="logs-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Página</th>
              <th>Data e hora</th>
              <th>IP</th>
              <th>Navegador</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($dashboard['logs'] as $log): ?>
              <tr>
                <td><?= escape_html((string) $log['id']) ?></td>
                <td><?= escape_html((string) $log['page_name']) ?></td>
                <td><?= escape_html(format_datetime_for_display((string) $log['accessed_at'])) ?></td>
                <td><?= escape_html((string) $log['ip']) ?></td>
                <td title="<?= escape_html((string) $log['user_agent']) ?>">
                  <?= escape_html(shortened_user_agent((string) $log['user_agent'])) ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
