<?php
declare(strict_types=1);

const COOKIE_DIAS = 30;

function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function ler_query(string $chave): string
{
    return trim((string) ($_GET[$chave] ?? ''));
}

function ler_cookie(string $chave): string
{
    return trim((string) ($_COOKIE[$chave] ?? ''));
}

function opcoes_cookie(): array
{
    $seguro = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

    return [
        'expires' => time() + (60 * 60 * 24 * COOKIE_DIAS),
        'path' => '/',
        'secure' => $seguro,
        'httponly' => true,
        'samesite' => 'Lax',
    ];
}

function salvar_cookie(string $chave, string $valor): void
{
    setcookie($chave, $valor, opcoes_cookie());
    $_COOKIE[$chave] = $valor;
}

function remover_cookie(string $chave): void
{
    $opcoes = opcoes_cookie();
    $opcoes['expires'] = time() - 3600;

    setcookie($chave, '', $opcoes);
    unset($_COOKIE[$chave]);
}

function redirecionar(string $destino): never
{
    header('Location: ' . $destino);
    exit;
}

function link_com_parametros(array $parametros): string
{
    if ($parametros === []) {
        return 'index.php';
    }

    return 'index.php?' . http_build_query($parametros);
}

$coresPermitidas = [
    'lightcoral' => '#FF0000',
    'lightgreen' => '#00FF00',
    'lightblue' => '#0000FF',
];

if (isset($_GET['limpar'])) {
    remover_cookie('nome');
    remover_cookie('email');
    remover_cookie('cor');
    redirecionar('index.php');
}

$houveAtualizacao = false;

$nomeRecebido = ler_query('nome');
if ($nomeRecebido !== '') {
    salvar_cookie('nome', $nomeRecebido);
    $houveAtualizacao = true;
}

$emailRecebido = ler_query('email');
if ($emailRecebido !== '' && filter_var($emailRecebido, FILTER_VALIDATE_EMAIL) !== false) {
    salvar_cookie('email', $emailRecebido);
    $houveAtualizacao = true;
}

$corRecebida = ler_query('cor');
if ($corRecebida !== '' && array_key_exists($corRecebida, $coresPermitidas)) {
    salvar_cookie('cor', $corRecebida);
    $houveAtualizacao = true;
}

if ($houveAtualizacao) {
    redirecionar('index.php');
}

$nome = ler_cookie('nome');
$email = ler_cookie('email');
$cor = ler_cookie('cor');
$corValida = array_key_exists($cor, $coresPermitidas) ? $cor : '';
$corFundo = $corValida !== '' ? $corValida : '#efefef';
$mostrarNome = $nome !== '';
$mostrarEmail = $email !== '';
$mostrarInformacoes = $mostrarNome || $mostrarEmail;

$parametrosPessoa = [];
if ($corValida !== '') {
    $parametrosPessoa['cor'] = $corValida;
}

$linkPedro = link_com_parametros(array_merge(
    ['nome' => 'Pedro', 'email' => 'pedro@gmail.com'],
    $parametrosPessoa
));

$linkVini = link_com_parametros(array_merge(
    ['nome' => 'Vini', 'email' => 'vini@outlook.com'],
    $parametrosPessoa
));

$linkRed = link_com_parametros(['cor' => 'lightcoral']);
$linkGreen = link_com_parametros(['cor' => 'lightgreen']);
$linkBlue = link_com_parametros(['cor' => 'lightblue']);
$linkLimpar = link_com_parametros(['limpar' => '1']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cookies com links e cores</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      min-height: 100vh;
      padding: 36px 56px;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: <?= escapar($corFundo) ?>;
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
      font-size: 34px;
      line-height: 1.3;
    }

    a {
      color: #2f7cf8;
      text-decoration: underline;
      font-size: 34px;
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
      margin-top: 26px;
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

    .hint-box {
      max-width: 780px;
      padding: 18px 22px;
      border: 1px solid rgba(22, 36, 55, 0.18);
      background: rgba(255, 255, 255, 0.72);
    }

    .hint-box p {
      margin-bottom: 10px;
      font-size: 22px;
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

      .hint-box p {
        font-size: 18px;
      }
    }
  </style>
</head>
<body>
  <h1>Cookies com links e cores</h1>
  <hr>

  <?php if ($mostrarInformacoes): ?>
    <?php if ($mostrarNome): ?>
      <p>Nome informado: <?= escapar($nome) ?></p>
    <?php endif; ?>

    <?php if ($mostrarEmail): ?>
      <p>Email: <?= escapar($email) ?></p>
    <?php endif; ?>
  <?php else: ?>
    <div class="hint-box">
      <p>Selecione um dos links de usuário e uma das cores.</p>
      <p>Os dados serão gravados em cookies e a página continuará preenchida mesmo após ser fechada e aberta novamente.</p>
    </div>
  <?php endif; ?>

  <div class="links">
    <p><a href="<?= escapar($linkPedro) ?>">[nome = Pedro | email = pedro@gmail.com]</a></p>
    <p><a href="<?= escapar($linkVini) ?>">[nome = Vini | email = vini@outlook.com]</a></p>
    <p><a href="<?= escapar($linkLimpar) ?>">Limpar tudo</a></p>
  </div>

  <div class="cards">
    <a class="card red" href="<?= escapar($linkRed) ?>">Red<br>#FF0000</a>
    <a class="card green" href="<?= escapar($linkGreen) ?>">Green<br>#00FF00</a>
    <a class="card blue" href="<?= escapar($linkBlue) ?>">Blue<br>#0000FF</a>
  </div>
</body>
</html>
