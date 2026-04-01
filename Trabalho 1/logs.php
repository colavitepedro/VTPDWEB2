<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$tituloPagina = 'Logs de Acesso | Trabalho 1';
$paginaAtiva = 'logs';
$erroLogin = null;
$erroPainel = null;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $acao = (string) ($_POST['acao'] ?? '');

    if ($acao === 'login') {
        $chave = (string) ($_POST['chave_acesso'] ?? '');

        if (autenticar_logs($chave)) {
            definir_mensagem('Autenticação realizada com sucesso.', 'success');
            redirecionar('logs.php');
        }

        $erroLogin = 'Palavra-chave incorreta. Tente novamente.';
    } elseif (!esta_logado_nos_logs()) {
        definir_mensagem('Faça login para acessar o painel de logs.', 'danger');
        redirecionar('logs.php');
    } else {
        try {
            if ($acao === 'limpar_contador') {
                $chavePagina = (string) ($_POST['chave_pagina'] ?? '');
                $pagina = obter_pagina_monitorada($chavePagina);
                limpar_contador($chavePagina);
                definir_mensagem('O contador da página "' . $pagina['rotulo'] . '" foi zerado.', 'success');
            } elseif ($acao === 'limpar_todos_contadores') {
                limpar_todos_contadores();
                definir_mensagem('Todos os contadores de acesso foram zerados.', 'success');
            } elseif ($acao === 'limpar_logs') {
                limpar_logs();
                definir_mensagem('O arquivo de logs foi limpo com sucesso.', 'success');
            } else {
                definir_mensagem('Ação inválida.', 'danger');
            }
        } catch (Throwable $erro) {
            definir_mensagem('Não foi possível concluir a ação solicitada nos arquivos de controle.', 'danger');
        }

        redirecionar('logs.php');
    }
}

$painel = [
    'paginas' => [],
    'total' => 0,
    'registros' => [],
];

if (esta_logado_nos_logs()) {
    try {
        $painel = obter_dados_painel();
    } catch (Throwable $erro) {
        $erroPainel = 'A autenticação foi concluída, mas os dados do painel não puderam ser carregados.';
    }
}

require __DIR__ . '/includes/header.php';
?>

<?php if (!esta_logado_nos_logs()): ?>
  <section class="painel-logs page-panel page-panel--pink">
    <div class="topo-painel-logs topo-painel-logs--login">
      <div>
        <p class="eyebrow">Área restrita</p>
        <h1 class="titulo-painel-logs">Logs de Acesso</h1>
        <p class="texto-painel-logs">
          Use a palavra-chave definida no enunciado para consultar os registros e as estatísticas do projeto.
        </p>
      </div>

      <div class="icone-documento-log" aria-hidden="true">
        <span class="icone-documento-log__faixa">LOG</span>
      </div>
    </div>

    <?php if ($erroLogin !== null): ?>
      <div class="feedback-banner feedback-banner--danger">
        <?= escapar($erroLogin) ?>
      </div>
    <?php endif; ?>

    <form class="login-form caixa-login-logs" method="post" action="logs.php">
      <input type="hidden" name="acao" value="login">

      <label class="field-label" for="chave_acesso">Chave de acesso</label>
      <input
        class="text-input"
        type="password"
        id="chave_acesso"
        name="chave_acesso"
        placeholder="Digite a chave"
        autocomplete="current-password"
        required
      >

      <button class="action-button" type="submit">Entrar</button>
    </form>
  </section>
<?php else: ?>
  <?php if ($erroPainel !== null): ?>
    <div class="feedback-banner feedback-banner--warning">
      <?= escapar($erroPainel) ?>
    </div>
  <?php endif; ?>

  <section class="painel-logs page-panel page-panel--pink">
    <div class="topo-painel-logs">
      <div>
        <p class="eyebrow">Painel protegido</p>
        <h1 class="titulo-painel-logs">Logs de Acesso</h1>
      </div>

      <div class="icone-documento-log" aria-hidden="true">
        <span class="icone-documento-log__faixa">LOG</span>
      </div>
    </div>

    <div class="grade-resumo-logs">
      <?php foreach ($painel['paginas'] as $pagina): ?>
        <article class="cartao-resumo-log">
          <p class="cartao-resumo-log__rotulo"><?= escapar((string) $pagina['rotulo']) ?></p>
          <strong class="cartao-resumo-log__valor"><?= escapar((string) $pagina['quantidade']) ?> Acessos</strong>

          <form method="post" action="logs.php" onsubmit="return confirm('Deseja zerar somente o contador desta página?');">
            <input type="hidden" name="acao" value="limpar_contador">
            <input type="hidden" name="chave_pagina" value="<?= escapar((string) $pagina['chave']) ?>">
            <button class="action-button action-button--ghost action-button--small" type="submit">Limpar</button>
          </form>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="barra-total-logs">
      <p>Total de Acessos: <strong><?= escapar((string) $painel['total']) ?></strong></p>

      <form method="post" action="logs.php" onsubmit="return confirm('Deseja realmente zerar todos os contadores?');">
        <input type="hidden" name="acao" value="limpar_todos_contadores">
        <button class="action-button action-button--danger action-button--small" type="submit">Limpar todos os acessos</button>
      </form>
    </div>

    <section class="bloco-tabela-logs">
      <div class="cabecalho-tabela-logs">
        <h2>Registros de acesso</h2>

        <form method="post" action="logs.php" onsubmit="return confirm('Deseja apagar todos os registros de acesso?');">
          <input type="hidden" name="acao" value="limpar_logs">
          <button class="action-button action-button--danger action-button--small" type="submit">Limpar logs</button>
        </form>
      </div>

      <?php if ($painel['registros'] === []): ?>
        <p class="empty-state">Ainda não existem registros de acesso para exibir.</p>
      <?php else: ?>
        <div class="table-wrapper table-wrapper--logs">
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
              <?php foreach ($painel['registros'] as $registro): ?>
                <tr>
                  <td><?= escapar((string) $registro['id']) ?></td>
                  <td><?= escapar((string) $registro['titulo']) ?></td>
                  <td><?= escapar(formatar_data_br((string) $registro['data'])) ?></td>
                  <td><?= escapar((string) $registro['ip']) ?></td>
                  <td title="<?= escapar((string) $registro['navegador']) ?>">
                    <?= escapar(resumir_texto((string) $registro['navegador'])) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </section>
  </section>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
