<?php
declare(strict_types=1);

const LOGIN_DEMO = 'pedro';
const SENHA_DEMO = 'pedro';

function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function classe_nav(string $paginaAtiva, string $pagina): string
{
    return $paginaAtiva === $pagina ? 'nav-link is-active' : 'nav-link';
}

function normalizar_texto(string $texto): string
{
    $textoNormalizado = str_replace(["\r\n", "\r"], "\n", trim($texto));

    return preg_replace("/\n{3,}/", "\n\n", $textoNormalizado) ?? $textoNormalizado;
}

function diretorio_contatos(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'contatos';
}

function nome_arquivo_contato(): string
{
    return 'Contato_' . date('d_m_Y') . '_' . str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT) . '.txt';
}

function salvar_contato(array $contato): string
{
    $diretorio = diretorio_contatos();

    if (!is_dir($diretorio) && !mkdir($diretorio, 0777, true) && !is_dir($diretorio)) {
        throw new RuntimeException('Não foi possível criar a pasta de contatos.');
    }

    $nomeArquivo = nome_arquivo_contato();
    $caminhoArquivo = $diretorio . DIRECTORY_SEPARATOR . $nomeArquivo;

    $conteudo = 'Contato via site:' . PHP_EOL . PHP_EOL
        . 'Data: ' . $contato['data'] . PHP_EOL . PHP_EOL
        . 'Nome: ' . $contato['nome'] . PHP_EOL
        . 'Email: ' . $contato['email'] . PHP_EOL
        . 'Mensagem: ' . $contato['mensagem'] . PHP_EOL . PHP_EOL
        . str_repeat('-', 70) . PHP_EOL;

    $escrito = file_put_contents($caminhoArquivo, $conteudo, LOCK_EX);

    if ($escrito === false) {
        throw new RuntimeException('Não foi possível gravar o arquivo do contato.');
    }

    return $nomeArquivo;
}

function dados_usuario_demo(): array
{
    return [
        'login' => LOGIN_DEMO,
        'senha' => SENHA_DEMO,
        'nome' => 'Pedro Colavite Conilho',
        'email' => 'colavite.pedro@ifsp.edu.br',
        'telefone' => '(17) 99726-1752',
        'endereco' => 'Fernandópolis - SP ',
        'curso' => 'Desenvolvimento Web 2',
        'bio' => 'Corinthiano',
    ];
}

function usuario_esta_autenticado(): bool
{
    return isset($_SESSION['usuario']) && is_array($_SESSION['usuario']);
}

function usuario_atual(): ?array
{
    if (!usuario_esta_autenticado()) {
        return null;
    }

    return $_SESSION['usuario'];
}

function autenticar_usuario(string $login, string $senha): bool
{
    $usuarioDemo = dados_usuario_demo();

    if ($login !== $usuarioDemo['login'] || $senha !== $usuarioDemo['senha']) {
        return false;
    }

    session_regenerate_id(true);

    $_SESSION['usuario'] = [
        'login' => $usuarioDemo['login'],
        'nome' => $usuarioDemo['nome'],
        'email' => $usuarioDemo['email'],
        'telefone' => $usuarioDemo['telefone'],
        'endereco' => $usuarioDemo['endereco'],
        'curso' => $usuarioDemo['curso'],
        'bio' => $usuarioDemo['bio'],
    ];
    $_SESSION['autenticado_em'] = date('d/m/Y H:i:s');

    return true;
}

function destruir_cookie_sessao(): void
{
    if (ini_get('session.use_cookies') !== '1') {
        return;
    }

    $parametros = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        [
            'expires' => time() - 42000,
            'path' => $parametros['path'],
            'domain' => $parametros['domain'],
            'secure' => $parametros['secure'],
            'httponly' => $parametros['httponly'],
            'samesite' => $parametros['samesite'] ?? 'Lax',
        ]
    );
}

function encerrar_sessao_usuario(): void
{
    $_SESSION = [];
    destruir_cookie_sessao();

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
}

function definir_flash(string $tipo, string $mensagem): void
{
    $_SESSION['flash'] = [
        'tipo' => $tipo,
        'mensagem' => $mensagem,
    ];
}

function obter_flash(): ?array
{
    if (!isset($_SESSION['flash']) || !is_array($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return [
        'tipo' => (string) ($flash['tipo'] ?? 'info'),
        'mensagem' => (string) ($flash['mensagem'] ?? ''),
    ];
}

function classe_flash(string $tipo): string
{
    return match ($tipo) {
        'success' => 'flash-message flash-success',
        'error' => 'flash-message flash-error',
        default => 'flash-message flash-info',
    };
}

function redirecionar(string $destino): never
{
    header('Location: ' . $destino);
    exit;
}

function redirecionar_se_autenticado(string $destino = 'index.php'): void
{
    if (!usuario_esta_autenticado()) {
        return;
    }

    definir_flash('info', 'Você já está autenticado. Use o menu para acessar o perfil ou sair da sessão.');
    redirecionar($destino);
}

function exigir_autenticacao(string $destino = 'entrar.php'): void
{
    if (usuario_esta_autenticado()) {
        return;
    }

    definir_flash('error', 'Faça autenticação antes de acessar a página de perfil.');
    redirecionar($destino);
}
