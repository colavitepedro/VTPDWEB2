<?php
function read_get(string $key): string
{
    return trim((string) ($_GET[$key] ?? ""));
}

function build_link(array $params): string
{
    if ($params === []) {
        return "destino-get.php";
    }

    return "destino-get.php?" . http_build_query($params);
}

$nome = read_get("nome");
$email = read_get("email");
$cor = read_get("cor");

$coresPermitidas = ["lightcoral", "lightgreen", "lightblue"];
$corValida = in_array($cor, $coresPermitidas, true) ? $cor : "";
$corFundo = $corValida !== "" ? $corValida : "#efefef";

$nomeSafe = htmlspecialchars($nome, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
$emailSafe = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");

$mostrarNome = $nome !== "";
$mostrarEmail = $email !== "";
$mostrarBlocoInfo = $mostrarNome || $mostrarEmail;

$paramsComCor = [];
if ($corValida !== "") {
    $paramsComCor["cor"] = $corValida;
}

$linkEder = htmlspecialchars(
    build_link(array_merge(["nome" => "Pedro", "email" => "pedro@gmail.com"], $paramsComCor)),
    ENT_QUOTES | ENT_SUBSTITUTE,
    "UTF-8"
);

$linkJose = htmlspecialchars(
    build_link(array_merge(["nome" => "Vini", "email" => "vini@outlook.com"], $paramsComCor)),
    ENT_QUOTES | ENT_SUBSTITUTE,
    "UTF-8"
);

$paramsPessoa = [];
if ($nome !== "") {
    $paramsPessoa["nome"] = $nome;
}
if ($email !== "") {
    $paramsPessoa["email"] = $email;
}

$linkRed = htmlspecialchars(
    build_link(array_merge(["cor" => "lightcoral"], $paramsPessoa)),
    ENT_QUOTES | ENT_SUBSTITUTE,
    "UTF-8"
);

$linkGreen = htmlspecialchars(
    build_link(array_merge(["cor" => "lightgreen"], $paramsPessoa)),
    ENT_QUOTES | ENT_SUBSTITUTE,
    "UTF-8"
);

$linkBlue = htmlspecialchars(
    build_link(array_merge(["cor" => "lightblue"], $paramsPessoa)),
    ENT_QUOTES | ENT_SUBSTITUTE,
    "UTF-8"
);

$linkLimpar = "destino-get.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Destino GET</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      min-height: 100vh;
      padding: 36px 56px;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: <?= htmlspecialchars($corFundo, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>;
      color: #2f3b4a;
    }

    h1 {
      margin: 0;
      font-size: 58px;
      line-height: 1.05;
      color: #162437;
    }

    hr {
      margin: 22px 0 28px;
      border: none;
      border-top: 2px solid rgba(22, 36, 55, 0.22);
    }

    p {
      margin: 0 0 12px;
      font-size: 40px;
      line-height: 1.3;
    }

    a {
      color: #2f7cf8;
      text-decoration: underline;
      font-size: 40px;
    }

    .links {
      margin-top: 26px;
      margin-bottom: 26px;
    }

    .links p {
      margin-bottom: 14px;
    }

    .cards {
      display: flex;
      gap: 24px;
      flex-wrap: wrap;
      max-width: 1280px;
    }

    .card {
      width: 300px;
      height: 170px;
      border: 3px solid #1f2937;
      border-radius: 2px;
      color: #fff;
      text-decoration: none;
      display: flex;
      align-items: flex-end;
      padding: 12px;
      font-size: 22px;
      font-weight: 600;
      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);
    }

    .red {
      background: #ff0000;
    }

    .green {
      background: #00ff00;
    }

    .blue {
      background: #0000ff;
    }

    @media (max-width: 900px) {
      body {
        padding: 24px 20px;
      }

      h1 {
        font-size: 44px;
      }

      p,
      a {
        font-size: 28px;
      }

      .card {
        width: 100%;
        max-width: 360px;
      }
    }
  </style>
</head>
<body>
  <h1>Destino GET</h1>
  <hr>

  <?php if ($mostrarBlocoInfo): ?>
    <?php if ($mostrarNome): ?>
      <p>Nome informado: <?= $nomeSafe ?></p>
    <?php endif; ?>
    <?php if ($mostrarEmail): ?>
      <p>Email: <?= $emailSafe ?></p>
    <?php endif; ?>
  <?php endif; ?>

  <div class="links">
    <p><a href="<?= $linkEder ?>">[nome = Pedro | email = pedro@gmail.com]</a></p>
    <p><a href="<?= $linkJose ?>">[nome = Vini| email = vini@outlook.com]</a></p>
    <p><a href="<?= $linkLimpar ?>">Limpar tudo</a></p>
  </div>

  <div class="cards">
    <a class="card red" href="<?= $linkRed ?>">Red<br>#FF0000</a>
    <a class="card green" href="<?= $linkGreen ?>">Green<br>#00FF00</a>
    <a class="card blue" href="<?= $linkBlue ?>">Blue<br>#0000FF</a>
  </div>
</body>
</html>
