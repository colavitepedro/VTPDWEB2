<?php
if (($_SERVER["REQUEST_METHOD"] ?? "GET") !== "POST") {
    header("Location: index.php");
    exit;
}

function read_post_text(string $key, string $fallback): string
{
    $value = trim((string) ($_POST[$key] ?? ""));
    return $value === "" ? $fallback : $value;
}

function read_post_color(string $key, string $fallback): string
{
    $value = trim((string) ($_POST[$key] ?? ""));
    return preg_match("/^#[0-9A-Fa-f]{6}$/", $value) === 1 ? $value : $fallback;
}

function read_post_url(string $key): ?string
{
    $value = trim((string) ($_POST[$key] ?? ""));
    if ($value === "") {
        return null;
    }

    return filter_var($value, FILTER_VALIDATE_URL) ? $value : null;
}

$titulo = read_post_text("titulo", "Sem titulo");
$corpo = read_post_text("corpo", "Sem conteudo");
$corTexto = read_post_color("cor_texto", "#000000");
$corFundo = read_post_color("cor_fundo", "#ffffff");
$urlImagem = read_post_url("url_imagem");
$urlLink = read_post_url("url_link");

$tituloSafe = htmlspecialchars($titulo, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
$corpoSafe = nl2br(htmlspecialchars($corpo, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"));
$urlImagemSafe = $urlImagem !== null ? htmlspecialchars($urlImagem, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") : null;
$urlLinkSafe = $urlLink !== null ? htmlspecialchars($urlLink, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina de Destino</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      min-height: 100vh;
      padding: 24px;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: <?= $corFundo ?>;
      color: <?= $corTexto ?>;
    }

    main {
      max-width: 860px;
      margin: 0 auto;
      line-height: 1.6;
    }

    h1 {
      margin-top: 0;
      margin-bottom: 16px;
    }

    p {
      margin-bottom: 20px;
      word-break: break-word;
    }

    img {
      max-width: 100%;
      height: auto;
      display: block;
      margin: 16px 0;
      border-radius: 10px;
    }

    .actions {
      margin-top: 28px;
    }
  </style>
</head>
<body>
  <main>
    <h1><?= $tituloSafe ?></h1>
    <p><?= $corpoSafe ?></p>

    <?php if ($urlImagemSafe !== null): ?>
      <img src="<?= $urlImagemSafe ?>" alt="Imagem enviada no formulario">
    <?php endif; ?>

    <?php if ($urlLinkSafe !== null): ?>
      <p><a href="<?= $urlLinkSafe ?>" target="_blank" rel="noopener noreferrer">Abrir link informado</a></p>
    <?php endif; ?>

    <div class="actions">
      <a href="index.php">Voltar ao formulario</a>
    </div>
  </main>
</body>
</html>
