<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Destino do contato';
$activePage = 'contato';

$nome = normalizar_texto((string) ($_POST['nome'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$mensagem = normalizar_texto((string) ($_POST['mensagem'] ?? ''));
$dataHora = date('d/m/Y - H:i:s');
$erros = [];
$arquivoGerado = null;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    $erros[] = 'Envie o formulário de contato para visualizar esta página.';
}

if ($nome === '') {
    $erros[] = 'Informe o nome.';
}

if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $erros[] = 'Informe um e-mail válido.';
}

if ($mensagem === '') {
    $erros[] = 'Informe a mensagem.';
}

if ($erros === []) {
    try {
        $arquivoGerado = salvar_contato([
            'data' => $dataHora,
            'nome' => $nome,
            'email' => $email,
            'mensagem' => $mensagem,
        ]);
    } catch (RuntimeException $exception) {
        $erros[] = $exception->getMessage();
    }
}

require __DIR__ . '/includes/header.php';
?>
      <section class="hero-panel">
        <h1>Formulário para contato</h1>
      </section>

      <section class="result-panel">
        <?php if ($erros !== []): ?>
          <div class="alert-box">
            <h2>Não foi possível processar o contato.</h2>
            <ul class="error-list">
              <?php foreach ($erros as $erro): ?>
                <li><?= escapar($erro) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php else: ?>
          <p>Nome informado: <?= escapar($nome) ?></p>
          <p>Email: <?= escapar($email) ?></p>
          <p>Mensagem: <?= nl2br(escapar($mensagem)) ?></p>
          <p>Data: <?= escapar($dataHora) ?></p>
          <p class="file-note">Arquivo salvo em <code>contatos/<?= escapar($arquivoGerado ?? '') ?></code>.</p>
        <?php endif; ?>

        <div class="button-row">
          <a class="btn btn-info" href="contato.php">Voltar</a>
        </div>
      </section>
<?php require __DIR__ . '/includes/footer.php'; ?>
