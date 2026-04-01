<?php
declare(strict_types=1);

function escapar(?string $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function classe_link_navegacao(string $paginaAtiva, string $pagina): string
{
    return $paginaAtiva === $pagina ? 'site-nav__link is-active' : 'site-nav__link';
}

function redirecionar(string $destino): void
{
    header('Location: ' . $destino);
    exit;
}

function definir_mensagem(string $mensagem, string $tipo = 'info'): void
{
    $_SESSION['mensagem'] = [
        'texto' => $mensagem,
        'tipo' => $tipo,
    ];
}

function obter_mensagem(): ?array
{
    $mensagem = $_SESSION['mensagem'] ?? null;
    unset($_SESSION['mensagem']);

    if (!is_array($mensagem) || !isset($mensagem['texto'], $mensagem['tipo'])) {
        return null;
    }

    return [
        'texto' => (string) $mensagem['texto'],
        'tipo' => (string) $mensagem['tipo'],
    ];
}

function esta_logado_nos_logs(): bool
{
    return ($_SESSION['painel_logs_autenticado'] ?? false) === true;
}

function autenticar_logs(string $chave): bool
{
    if (trim($chave) !== CHAVE_ACESSO_LOGS) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['painel_logs_autenticado'] = true;

    return true;
}

function encerrar_sessao_logs(): void
{
    unset($_SESSION['painel_logs_autenticado']);
    session_regenerate_id(true);
}

function pasta_armazenamento(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage';
}

function caminho_arquivo_contadores(): string
{
    return pasta_armazenamento() . DIRECTORY_SEPARATOR . 'counters.txt';
}

function caminho_arquivo_logs(): string
{
    return pasta_armazenamento() . DIRECTORY_SEPARATOR . 'access_logs.txt';
}

function contadores_padrao(): array
{
    $contadores = [];

    foreach (array_keys(PAGINAS_MONITORADAS) as $pagina) {
        $contadores[$pagina] = 0;
    }

    return $contadores;
}

function garantir_arquivos_controle(): void
{
    $pasta = pasta_armazenamento();

    if (!is_dir($pasta) && !mkdir($pasta, 0755, true) && !is_dir($pasta)) {
        throw new RuntimeException('Não foi possível criar a pasta de armazenamento.');
    }

    if (!is_file(caminho_arquivo_contadores())) {
        salvar_contadores(contadores_padrao());
    }

    if (!is_file(caminho_arquivo_logs())) {
        $salvou = file_put_contents(caminho_arquivo_logs(), '', LOCK_EX);

        if ($salvou === false) {
            throw new RuntimeException('Não foi possível criar o arquivo de logs.');
        }
    }
}

function ler_contadores(): array
{
    garantir_arquivos_controle();

    $contadores = contadores_padrao();
    $conteudo = trim((string) @file_get_contents(caminho_arquivo_contadores()));

    if ($conteudo === '') {
        return $contadores;
    }

    if (str_starts_with($conteudo, '{')) {
        $dados = json_decode($conteudo, true);

        if (is_array($dados) && isset($dados['pages']) && is_array($dados['pages'])) {
            foreach ($contadores as $pagina => $valor) {
                $contadores[$pagina] = max(0, (int) ($dados['pages'][$pagina] ?? 0));
            }
        }

        return $contadores;
    }

    $linhas = preg_split("/\r\n|\n|\r/", $conteudo) ?: [];

    foreach ($linhas as $linha) {
        $partes = explode('=', $linha, 2);

        if (count($partes) !== 2) {
            continue;
        }

        $pagina = trim($partes[0]);
        $valor = trim($partes[1]);

        if (array_key_exists($pagina, $contadores)) {
            $contadores[$pagina] = max(0, (int) $valor);
        }
    }

    return $contadores;
}

function salvar_contadores(array $contadores): void
{
    $linhas = [];

    foreach (array_keys(PAGINAS_MONITORADAS) as $pagina) {
        $linhas[] = $pagina . '=' . max(0, (int) ($contadores[$pagina] ?? 0));
    }

    $salvou = file_put_contents(caminho_arquivo_contadores(), implode(PHP_EOL, $linhas) . PHP_EOL, LOCK_EX);

    if ($salvou === false) {
        throw new RuntimeException('Não foi possível gravar os contadores.');
    }
}

function ler_registros_acesso(): array
{
    garantir_arquivos_controle();

    $linhas = file(caminho_arquivo_logs(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (!is_array($linhas)) {
        return [];
    }

    $registros = [];

    foreach ($linhas as $linha) {
        $linha = trim($linha);

        if ($linha === '') {
            continue;
        }

        if (str_starts_with($linha, '{')) {
            $dados = json_decode($linha, true);

            if (is_array($dados)) {
                $registros[] = [
                    'id' => max(1, (int) ($dados['id'] ?? 0)),
                    'pagina' => (string) ($dados['page_key'] ?? ''),
                    'titulo' => (string) ($dados['page_name'] ?? ''),
                    'data' => (string) ($dados['accessed_at'] ?? ''),
                    'ip' => (string) ($dados['ip'] ?? 'Não identificado'),
                    'navegador' => (string) ($dados['user_agent'] ?? 'Não identificado'),
                ];
            }

            continue;
        }

        $partes = explode('|', $linha, 6);

        if (count($partes) !== 6) {
            continue;
        }

        $registros[] = [
            'id' => max(1, (int) trim($partes[0])),
            'pagina' => trim($partes[1]),
            'titulo' => trim($partes[2]),
            'data' => trim($partes[3]),
            'ip' => trim($partes[4]),
            'navegador' => trim($partes[5]),
        ];
    }

    return $registros;
}

function salvar_registros_acesso(array $registros): void
{
    $linhas = [];

    foreach ($registros as $registro) {
        $linhas[] = implode('|', [
            max(1, (int) ($registro['id'] ?? 0)),
            trim((string) ($registro['pagina'] ?? '')),
            trim((string) ($registro['titulo'] ?? '')),
            trim((string) ($registro['data'] ?? '')),
            trim((string) ($registro['ip'] ?? '')),
            preg_replace('/\s+/', ' ', str_replace('|', '/', trim((string) ($registro['navegador'] ?? '')))) ?? '',
        ]);
    }

    $conteudo = $linhas === [] ? '' : implode(PHP_EOL, $linhas) . PHP_EOL;
    $salvou = file_put_contents(caminho_arquivo_logs(), $conteudo, LOCK_EX);

    if ($salvou === false) {
        throw new RuntimeException('Não foi possível gravar o arquivo de logs.');
    }
}

function obter_pagina_monitorada(string $pagina): array
{
    if (!isset(PAGINAS_MONITORADAS[$pagina])) {
        throw new InvalidArgumentException('Página monitorada inválida.');
    }

    return PAGINAS_MONITORADAS[$pagina];
}

function ip_cliente(): string
{
    return trim((string) ($_SERVER['REMOTE_ADDR'] ?? '')) !== ''
        ? trim((string) $_SERVER['REMOTE_ADDR'])
        : 'Não identificado';
}

function navegador_cliente(): string
{
    return trim((string) ($_SERVER['HTTP_USER_AGENT'] ?? '')) !== ''
        ? trim((string) $_SERVER['HTTP_USER_AGENT'])
        : 'Não identificado';
}

function registrar_acesso(string $pagina): void
{
    $dadosPagina = obter_pagina_monitorada($pagina);
    $contadores = ler_contadores();
    $registros = ler_registros_acesso();

    $contadores[$pagina] = max(0, (int) ($contadores[$pagina] ?? 0)) + 1;

    $registros[] = [
        'id' => count($registros) + 1,
        'pagina' => $pagina,
        'titulo' => (string) $dadosPagina['rotulo'],
        'data' => date('Y-m-d H:i:s'),
        'ip' => ip_cliente(),
        'navegador' => navegador_cliente(),
    ];

    salvar_contadores($contadores);
    salvar_registros_acesso($registros);
}

function registrar_acesso_com_mensagem(string $pagina): ?string
{
    try {
        registrar_acesso($pagina);

        return null;
    } catch (Throwable $erro) {
        return 'A página foi exibida, mas não foi possível gravar o acesso nos arquivos de texto.';
    }
}

function obter_dados_painel(): array
{
    $contadores = ler_contadores();
    $registros = ler_registros_acesso();
    $paginas = [];

    foreach (PAGINAS_MONITORADAS as $chave => $pagina) {
        $paginas[] = [
            'chave' => $chave,
            'rotulo' => (string) $pagina['rotulo'],
            'resumo' => (string) $pagina['resumo'],
            'quantidade' => max(0, (int) ($contadores[$chave] ?? 0)),
        ];
    }

    usort(
        $paginas,
        static function (array $esquerda, array $direita): int {
            if ($esquerda['quantidade'] === $direita['quantidade']) {
                return strcmp((string) $esquerda['rotulo'], (string) $direita['rotulo']);
            }

            return $direita['quantidade'] <=> $esquerda['quantidade'];
        }
    );

    return [
        'paginas' => $paginas,
        'total' => array_sum(array_column($paginas, 'quantidade')),
        'registros' => array_reverse($registros),
    ];
}

function limpar_contador(string $pagina): void
{
    $contadores = ler_contadores();
    obter_pagina_monitorada($pagina);
    $contadores[$pagina] = 0;
    salvar_contadores($contadores);
}

function limpar_todos_contadores(): void
{
    salvar_contadores(contadores_padrao());
}

function limpar_logs(): void
{
    salvar_registros_acesso([]);
}

function formatar_data_br(string $data): string
{
    $dataHora = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data);

    if ($dataHora instanceof DateTimeImmutable) {
        return $dataHora->format('d/m/Y H:i:s');
    }

    return $data;
}

function resumir_texto(string $texto, int $limite = 96): string
{
    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($texto, 'UTF-8') <= $limite) {
            return $texto;
        }

        return mb_substr($texto, 0, $limite - 3, 'UTF-8') . '...';
    }

    if (strlen($texto) <= $limite) {
        return $texto;
    }

    return substr($texto, 0, $limite - 3) . '...';
}
