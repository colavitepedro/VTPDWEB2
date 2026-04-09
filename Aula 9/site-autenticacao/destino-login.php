<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

redirecionar_se_autenticado();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    definir_flash('error', 'Envie o formulário de autenticação para acessar esta área.');
    redirecionar('entrar.php');
}

$login = trim((string) ($_POST['usuario'] ?? ''));
$senha = trim((string) ($_POST['senha'] ?? ''));
$erros = [];

if ($login === '') {
    $erros[] = 'Informe o usuário.';
}

if ($senha === '') {
    $erros[] = 'Informe a senha.';
}

if ($erros === []) {
    $erroAutenticacao = autenticar_usuario($login, $senha);

    if ($erroAutenticacao !== null) {
        $erros[] = $erroAutenticacao;
    }
}

if ($erros === []) {
    definir_flash('success', 'Autenticação realizada com sucesso.');
    redirecionar('index.php');
}

$pageTitle = 'Falha na autenticação';
$activePage = 'entrar';

require __DIR__ . '/includes/header.php';
?>
      <section class="hero-panel">
        <h1>Falha na autenticação</h1>
      </section>

      <section class="result-panel">
        <div class="alert-box">
          <h2>Não foi possível entrar.</h2>
          <ul class="error-list">
            <?php foreach ($erros as $erro): ?>
              <li><?= escapar($erro) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="button-row">
          <a class="btn btn-info" href="entrar.php">Voltar ao formulário</a>
        </div>
      </section>
<?php require __DIR__ . '/includes/footer.php'; ?>
