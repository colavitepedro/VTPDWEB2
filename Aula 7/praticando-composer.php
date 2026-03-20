<?php
declare(strict_types=1);

use Claudsonm\CepPromise\CepPromise;
use Claudsonm\CepPromise\Exceptions\CepPromiseException;
use Claudsonm\CepPromise\Providers\ViaCepProvider;

$autoload = __DIR__ . '/vendor/autoload.php';
$autoloadDisponivel = is_file($autoload);

if ($autoloadDisponivel) {
    require_once $autoload;
}

function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function limpar_cep(string $cep): string
{
    return preg_replace('/\D+/', '', trim($cep)) ?? '';
}

function formatar_cep_exibicao(string $cep): string
{
    if (strlen($cep) !== 8) {
        return $cep;
    }

    return substr($cep, 0, 2) . '.' . substr($cep, 2, 3) . '-' . substr($cep, 5, 3);
}

function buscar_endereco_via_viacep(string $cep): ?array
{
    if (strlen($cep) !== 8) {
        return null;
    }

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
        return null;
    }

    $dados = json_decode($conteudo, true);

    if (!is_array($dados) || ($dados['erro'] ?? false) === true) {
        return null;
    }

    return [
        'zipCode' => limpar_cep((string) ($dados['cep'] ?? $cep)),
        'street' => (string) ($dados['logradouro'] ?? ''),
        'district' => (string) ($dados['bairro'] ?? ''),
        'city' => (string) ($dados['localidade'] ?? ''),
        'state' => (string) ($dados['uf'] ?? ''),
    ];
}

$cepDigitado = (string) ($_POST['cep'] ?? '');
$cepLimpo = limpar_cep($cepDigitado);
$cepExibicao = $cepLimpo !== '' ? formatar_cep_exibicao($cepLimpo) : '';
$endereco = null;
$erroPrincipal = null;
$detalhesErro = [];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!$autoloadDisponivel) {
        $erroPrincipal = 'A pasta vendor não foi encontrada. Execute o Composer nesta pasta ou copie vendor para a raiz do servidor.';
    } elseif ($cepLimpo === '') {
        $erroPrincipal = 'Informe um CEP para realizar a busca.';
    } else {
        try {
            $endereco = CepPromise::fetch($cepLimpo, [ViaCepProvider::class])->toArray();
            $cepExibicao = formatar_cep_exibicao((string) ($endereco['zipCode'] ?? $cepLimpo));
        } catch (CepPromiseException $exception) {
            $enderecoFallback = buscar_endereco_via_viacep($cepLimpo);

            if ($enderecoFallback !== null) {
                $endereco = $enderecoFallback;
                $cepExibicao = formatar_cep_exibicao((string) ($endereco['zipCode'] ?? $cepLimpo));
            } else {
                $erro = $exception->toArray();
                $erroPrincipal = (string) ($erro['message'] ?? 'Não foi possível localizar o CEP informado.');

                foreach (($erro['errors'] ?? []) as $item) {
                    if (is_array($item) && isset($item['message'])) {
                        $detalhesErro[] = (string) $item['message'];
                        continue;
                    }

                    if ($item instanceof Throwable) {
                        $detalhesErro[] = $item->getMessage();
                        continue;
                    }

                    if ($item !== null && $item !== '') {
                        $detalhesErro[] = (string) $item;
                    }
                }
            }
        } catch (Throwable $exception) {
            $erroPrincipal = 'Não foi possível consultar o CEP agora.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Praticando Composer - Busca CEP com Composer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <main class="page-shell">
    <h1 class="page-title">Praticando Composer - Busca CEP com Composer</h1>
    <hr class="page-rule">

    <form class="search-form" method="POST" action="">
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
            value="<?= escapar($cepDigitado) ?>"
          >
        </div>

        <div class="button-row">
          <button class="btn btn-primary" type="submit">Enviar</button>
          <button class="btn btn-warning" type="reset">Limpar</button>
        </div>
      </div>
    </form>

    <?php if ($endereco !== null): ?>
      <section class="result-card result-card-success">
        <h2>CEP: <?= escapar($cepExibicao) ?></h2>
        <p>Rua: <?= escapar((string) ($endereco['street'] ?? 'Não informado')) ?></p>
        <p>Bairro: <?= escapar((string) ($endereco['district'] ?? 'Não informado')) ?></p>
        <p>Cidade: <?= escapar((string) ($endereco['city'] ?? 'Não informado')) ?></p>
        <p>Estado: <?= escapar((string) ($endereco['state'] ?? 'Não informado')) ?></p>
      </section>
    <?php elseif ($erroPrincipal !== null): ?>
      <section class="result-card result-card-error">
        <?php if ($cepExibicao !== ''): ?>
          <h2>CEP: <?= escapar($cepExibicao) ?></h2>
        <?php endif; ?>

        <p><?= escapar($erroPrincipal) ?></p>

        <?php if ($detalhesErro !== []): ?>
          <p class="error-title">Detalhes do erro</p>
          <ul>
            <?php foreach ($detalhesErro as $detalhe): ?>
              <li><?= escapar($detalhe) ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </section>
    <?php endif; ?>
  </main>
</body>
</html>
