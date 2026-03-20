<?php
declare(strict_types=1);

function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function classe_nav(string $paginaAtiva, string $pagina): string
{
    return $paginaAtiva === $pagina ? "nav-link is-active" : "nav-link";
}

function normalizar_texto(string $texto): string
{
    $textoNormalizado = str_replace(["\r\n", "\r"], "\n", trim($texto));

    return preg_replace("/\n{3,}/", "\n\n", $textoNormalizado) ?? $textoNormalizado;
}

function diretorio_contatos(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . "contatos";
}

function nome_arquivo_contato(): string
{
    return "Contato_" . date("d_m_Y") . "_" . str_pad((string) random_int(0, 99999), 5, "0", STR_PAD_LEFT) . ".txt";
}

function salvar_contato(array $contato): string
{
    $diretorio = diretorio_contatos();

    if (!is_dir($diretorio) && !mkdir($diretorio, 0777, true) && !is_dir($diretorio)) {
        throw new RuntimeException("Não foi possível criar a pasta de contatos.");
    }

    $nomeArquivo = nome_arquivo_contato();
    $caminhoArquivo = $diretorio . DIRECTORY_SEPARATOR . $nomeArquivo;

    $conteudo = "Contato via site:" . PHP_EOL . PHP_EOL
        . "Data: " . $contato["data"] . PHP_EOL . PHP_EOL
        . "Nome: " . $contato["nome"] . PHP_EOL
        . "Email: " . $contato["email"] . PHP_EOL
        . "Mensagem: " . $contato["mensagem"] . PHP_EOL . PHP_EOL
        . str_repeat("-", 70) . PHP_EOL;

    $escrito = file_put_contents($caminhoArquivo, $conteudo, LOCK_EX);

    if ($escrito === false) {
        throw new RuntimeException("Não foi possível gravar o arquivo do contato.");
    }

    return $nomeArquivo;
}
