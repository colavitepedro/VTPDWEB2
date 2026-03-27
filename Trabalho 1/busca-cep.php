<?php
declare(strict_types=1);

$activityPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Aula 7' . DIRECTORY_SEPARATOR . 'praticando-composer.php';

if (!is_file($activityPath)) {
    http_response_code(500);
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Busca CEP indisponível</title>
      <link rel="stylesheet" href="assets/cep.css">
    </head>
    <body>
      <main class="page-shell">
        <div class="page-toolbar">
          <a class="back-link" href="index.php">Voltar para a tela inicial</a>
        </div>
        <h1 class="page-title">Busca CEP indisponível</h1>
        <hr class="page-rule">
        <section class="result-card result-card-error">
          <p>Não foi possível localizar o arquivo da atividade da Aula 7.</p>
          <p>Verifique se <code>Aula 7/praticando-composer.php</code> está disponível ao lado da pasta <code>Trabalho 1</code>.</p>
        </section>
      </main>
    </body>
    </html>
    <?php
    exit;
}

ob_start();
require $activityPath;
$html = (string) ob_get_clean();

$html = str_replace(
    [
        'href="estilo.css"',
        '<title>Busca CEP com Composer</title>',
        '<title>Praticando Composer - Busca CEP com Composer</title>',
        '<main class="page-shell">',
    ],
    [
        'href="assets/cep.css"',
        '<title>Busca CEP | Trabalho 1</title>',
        '<main class="page-shell"><div class="page-toolbar"><a class="back-link" href="index.php">Voltar para a tela inicial</a></div>',
    ],
    $html
);

echo $html;
