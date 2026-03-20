<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/funcoes.php';

$tabelaInicial = '';
$erroInicial = null;

try {
    $tabelaInicial = renderizar_tabela_tarefas(ler_tarefas());
} catch (RuntimeException $exception) {
    $erroInicial = $exception->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Praticando - Cadastro de tarefas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/site.css">
</head>
<body>
  <main class="page-shell">
    <header class="page-heading">
      <p class="eyebrow"></p>
      <h1>Praticando - Cadastro de tarefas</h1>
    </header>

    <section class="task-form-panel simple-panel">
      <form id="taskForm" class="row g-4 align-items-start" novalidate>
        <div class="col-lg-6">
          <label class="form-label fw-semibold" for="descricao">Descrição da tarefa</label>
          <input class="form-control form-control-lg" type="text" id="descricao" name="descricao" placeholder="Digite a tarefa que deseja cadastrar">
        </div>

        <div class="col-lg-4">
          <span class="form-label fw-semibold d-block mb-3">Prioridade</span>

          <div class="priority-stack">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="prioridade" id="prioridadeAlta" value="Alta" checked>
              <label class="form-check-label" for="prioridadeAlta">Alta</label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="prioridade" id="prioridadeMedia" value="Média">
              <label class="form-check-label" for="prioridadeMedia">Média</label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="prioridade" id="prioridadeBaixa" value="Baixa">
              <label class="form-check-label" for="prioridadeBaixa">Baixa</label>
            </div>
          </div>
        </div>

        <div class="col-12">
          <button class="btn btn-primary btn-lg px-4" type="submit" id="taskSubmitButton">Cadastrar</button>
        </div>
      </form>

      <div id="taskStatus" class="alert d-none status-alert mt-4" role="alert"></div>
    </section>

    <section class="table-section">
      <h2 class="section-title">Tarefas cadastradas</h2>

      <div id="taskTableContainer" class="table-shell">
        <?php if ($erroInicial !== null): ?>
          <div class="alert alert-danger mb-0"><?= escapar($erroInicial) ?></div>
        <?php else: ?>
          <?= $tabelaInicial ?>
        <?php endif; ?>
      </div>

      <div class="action-row">
        <button class="btn btn-danger btn-lg" type="button" id="clearTasksButton">Apagar todas</button>
      </div>
    </section>

    <a class="back-link" href="index.php">Voltar ao menu</a>
  </main>

  <footer class="page-footer" aria-hidden="true"></footer>

  <script src="assets/lista-tarefas.js"></script>
</body>
</html>
