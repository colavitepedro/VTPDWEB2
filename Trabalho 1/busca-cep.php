<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

function limpar_cep_busca(string $cep): string
{
    return preg_replace('/\D+/', '', trim($cep)) ?? '';
}

function formatar_cep_busca(string $cep): string
{
    if (strlen($cep) !== 8) {
        return $cep;
    }

    return substr($cep, 0, 2) . '.' . substr($cep, 2, 3) . '-' . substr($cep, 5, 3);
}

function endereco_tem_dados_minimos_busca(array $endereco): bool
{
    $cep = limpar_cep_busca((string) ($endereco['cep'] ?? ''));
    $cidade = trim((string) ($endereco['cidade'] ?? ''));
    $estado = trim((string) ($endereco['estado'] ?? ''));

    return strlen($cep) === 8 && $cidade !== '' && $estado !== '';
}

function consultar_cep_via_viacep(string $cep): array
{
    $url = 'https://viacep.com.br/ws/' . $cep . '/json/';
    $contexto = stream_context_create([
        'http' => [
            'timeout' => 5,
        ],
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
        ],
    ]);

    $conteudo = @file_get_contents($url, false, $contexto);

    if ($conteudo === false) {
        return [
            'sucesso' => false,
            'tipo_erro' => 'consulta',
        ];
    }

    $dados = json_decode($conteudo, true);

    if (!is_array($dados)) {
        return [
            'sucesso' => false,
            'tipo_erro' => 'consulta',
        ];
    }

    if (($dados['erro'] ?? false) === true) {
        return [
            'sucesso' => false,
            'tipo_erro' => 'nao_encontrado',
        ];
    }

    $endereco = [
        'cep' => limpar_cep_busca((string) ($dados['cep'] ?? $cep)),
        'rua' => (string) ($dados['logradouro'] ?? ''),
        'bairro' => (string) ($dados['bairro'] ?? ''),
        'cidade' => (string) ($dados['localidade'] ?? ''),
        'estado' => (string) ($dados['uf'] ?? ''),
    ];

    if (!endereco_tem_dados_minimos_busca($endereco)) {
        return [
            'sucesso' => false,
            'tipo_erro' => 'incompleto',
        ];
    }

    return [
        'sucesso' => true,
        'endereco' => $endereco,
    ];
}

$cepDigitado = (string) ($_POST['cep'] ?? '');
$cepLimpo = limpar_cep_busca($cepDigitado);
$cepExibicao = $cepLimpo !== '' ? formatar_cep_busca($cepLimpo) : '';
$endereco = null;
$erroPrincipal = null;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $acao = (string) ($_POST['acao'] ?? 'buscar');

    if ($acao === 'limpar') {
        redirecionar('busca-cep.php');
    }

    if ($cepLimpo === '') {
        $erroPrincipal = 'Informe um CEP para realizar a busca.';
    } elseif (strlen($cepLimpo) !== 8) {
        $erroPrincipal = 'Informe um CEP válido com 8 números.';
    } else {
        $resultado = consultar_cep_via_viacep($cepLimpo);

        if (($resultado['sucesso'] ?? false) === true) {
            $endereco = $resultado['endereco'];
            $cepExibicao = formatar_cep_busca((string) ($endereco['cep'] ?? $cepLimpo));
        } else {
            $tipoErro = (string) ($resultado['tipo_erro'] ?? 'consulta');

            if ($tipoErro === 'nao_encontrado') {
                $erroPrincipal = 'CEP não encontrado. Confira se ele existe e se foi digitado corretamente.';
            } elseif ($tipoErro === 'incompleto') {
                $erroPrincipal = 'Não foi possível localizar cidade e estado para esse CEP.';
            } else {
                $erroPrincipal = 'Não foi possível consultar o CEP agora. Tente novamente em instantes.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Busca CEP | Trabalho 1</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/cep.css">
</head>
<body>
  <main class="page-shell">
    <div class="page-toolbar">
      <a class="back-link" href="index.php">Voltar para a tela inicial</a>
    </div>

    <h1 class="page-title">Busca CEP</h1>
    <hr class="page-rule">

    <form class="search-form" method="post" action="busca-cep.php">
      <div class="form-row">
        <div class="field-group">
          <label for="cep">CEP:</label>
          <input
            class="form-control"
            type="text"
            id="cep"
            name="cep"
            inputmode="numeric"
            placeholder="Somente números"
            maxlength="8"
            value="<?= escapar($cepDigitado) ?>"
            required
          >
        </div>

        <div class="button-row">
          <button class="btn btn-primary" type="submit" name="acao" value="buscar">Enviar</button>
          <button class="btn btn-warning" type="submit" name="acao" value="limpar">Limpar</button>
        </div>
      </div>
    </form>

    <?php if ($endereco !== null): ?>
      <section class="result-card result-card-success">
        <h2>CEP: <?= escapar($cepExibicao) ?></h2>
        <p>Rua: <?= escapar((string) ($endereco['rua'] ?? 'Não informado')) ?></p>
        <p>Bairro: <?= escapar((string) ($endereco['bairro'] ?? 'Não informado')) ?></p>
        <p>Cidade: <?= escapar((string) ($endereco['cidade'] ?? 'Não informado')) ?></p>
        <p>Estado: <?= escapar((string) ($endereco['estado'] ?? 'Não informado')) ?></p>
      </section>
    <?php elseif ($erroPrincipal !== null): ?>
      <section class="result-card result-card-error">
        <?php if ($cepExibicao !== ''): ?>
          <h2>CEP: <?= escapar($cepExibicao) ?></h2>
        <?php endif; ?>

        <p><?= escapar($erroPrincipal) ?></p>
      </section>
    <?php endif; ?>
  </main>
</body>
</html>
