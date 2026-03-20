<?php
declare(strict_types=1);

function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function sanitizar_texto_linha(string $valor): string
{
    $texto = trim(strip_tags($valor));

    return preg_replace('/\s+/u', ' ', $texto) ?? $texto;
}

function sanitizar_email(string $valor): string
{
    $email = trim(mb_strtolower($valor, 'UTF-8'));
    $emailSanitizado = filter_var($email, FILTER_SANITIZE_EMAIL);

    return is_string($emailSanitizado) ? $emailSanitizado : '';
}

function diretorio_dados(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'dados';
}

function caminho_arquivo_emails(): string
{
    return diretorio_dados() . DIRECTORY_SEPARATOR . 'emails.txt';
}

function caminho_arquivo_tarefas(): string
{
    return diretorio_dados() . DIRECTORY_SEPARATOR . 'tarefas.txt';
}

function emails_padrao(): array
{
    return [
        'epansani@ifsp.edu.br',
        'epansani@gmail.com',
    ];
}

function conteudo_padrao_emails(): string
{
    return implode(PHP_EOL, emails_padrao()) . PHP_EOL;
}

function tarefas_padrao(): array
{
    return [
        [
            'descricao' => 'Estudar Ajax',
            'prioridade' => 'Alta',
            'data' => '12/03/2026 22:32',
        ],
        [
            'descricao' => 'Preparar aula de PHP',
            'prioridade' => 'Alta',
            'data' => '12/03/2026 22:32',
        ],
        [
            'descricao' => 'Atualizar Moodle',
            'prioridade' => 'Média',
            'data' => '12/03/2026 22:32',
        ],
        [
            'descricao' => 'Organizar arquivos',
            'prioridade' => 'Baixa',
            'data' => '12/03/2026 22:32',
        ],
    ];
}

function conteudo_padrao_tarefas(): string
{
    $json = json_encode(
        tarefas_padrao(),
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    if ($json === false) {
        throw new RuntimeException('Não foi possível gerar o conteúdo inicial das tarefas.');
    }

    return $json;
}

function garantir_arquivo(string $caminho, string $conteudoInicial): void
{
    $diretorio = dirname($caminho);

    if (!is_dir($diretorio) && !mkdir($diretorio, 0777, true) && !is_dir($diretorio)) {
        throw new RuntimeException('Não foi possível criar o diretório de dados.');
    }

    if (!file_exists($caminho)) {
        $resultado = file_put_contents($caminho, $conteudoInicial, LOCK_EX);

        if ($resultado === false) {
            throw new RuntimeException('Não foi possível criar o arquivo de dados.');
        }
    }
}

function ler_emails(): array
{
    garantir_arquivo(caminho_arquivo_emails(), conteudo_padrao_emails());

    $linhas = file(caminho_arquivo_emails(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($linhas === false) {
        throw new RuntimeException('Não foi possível ler o arquivo de e-mails.');
    }

    $emails = [];

    foreach ($linhas as $linha) {
        $email = sanitizar_email($linha);

        if ($email !== '' && !in_array($email, $emails, true)) {
            $emails[] = $email;
        }
    }

    return $emails;
}

function salvar_email(string $email): void
{
    $emails = ler_emails();

    if (!in_array($email, $emails, true)) {
        $emails[] = $email;
    }

    $conteudo = implode(PHP_EOL, $emails);

    if ($conteudo !== '') {
        $conteudo .= PHP_EOL;
    }

    $resultado = file_put_contents(caminho_arquivo_emails(), $conteudo, LOCK_EX);

    if ($resultado === false) {
        throw new RuntimeException('Não foi possível gravar o e-mail no arquivo.');
    }
}

function prioridade_valida(string $prioridade): bool
{
    return in_array($prioridade, ['Alta', 'Média', 'Baixa'], true);
}

function ler_tarefas(): array
{
    garantir_arquivo(caminho_arquivo_tarefas(), conteudo_padrao_tarefas());

    $conteudo = file_get_contents(caminho_arquivo_tarefas());

    if ($conteudo === false) {
        throw new RuntimeException('Não foi possível ler o arquivo de tarefas.');
    }

    try {
        $tarefas = json_decode($conteudo, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        throw new RuntimeException('O arquivo de tarefas contém JSON inválido. Corrija o arquivo antes de continuar.');
    }

    if (!is_array($tarefas)) {
        throw new RuntimeException('O arquivo de tarefas possui uma estrutura inválida.');
    }

    $tarefasNormalizadas = [];

    foreach ($tarefas as $tarefa) {
        if (
            !is_array($tarefa)
            || !array_key_exists('descricao', $tarefa)
            || !array_key_exists('prioridade', $tarefa)
            || !array_key_exists('data', $tarefa)
        ) {
            throw new RuntimeException('O arquivo de tarefas possui uma estrutura inválida.');
        }

        $descricao = sanitizar_texto_linha((string) $tarefa['descricao']);
        $prioridade = (string) $tarefa['prioridade'];
        $data = sanitizar_texto_linha((string) $tarefa['data']);

        if ($descricao === '' || !prioridade_valida($prioridade) || $data === '') {
            throw new RuntimeException('O arquivo de tarefas possui dados inválidos.');
        }

        $tarefasNormalizadas[] = [
            'descricao' => $descricao,
            'prioridade' => $prioridade,
            'data' => $data,
        ];
    }

    return $tarefasNormalizadas;
}

function salvar_tarefas(array $tarefas): void
{
    $json = json_encode(
        array_values($tarefas),
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    if ($json === false) {
        throw new RuntimeException('Não foi possível converter as tarefas para JSON.');
    }

    $resultado = file_put_contents(caminho_arquivo_tarefas(), $json, LOCK_EX);

    if ($resultado === false) {
        throw new RuntimeException('Não foi possível gravar o arquivo de tarefas.');
    }
}

function classe_badge_prioridade(string $prioridade): string
{
    if ($prioridade === 'Alta') {
        return 'text-bg-danger';
    }

    if ($prioridade === 'Média') {
        return 'text-bg-warning';
    }

    if ($prioridade === 'Baixa') {
        return 'text-bg-success';
    }

    return 'text-bg-secondary';
}

function renderizar_tabela_tarefas(array $tarefas): string
{
    if ($tarefas === []) {
        return '<div class="alert alert-secondary mb-0">Nenhuma tarefa cadastrada até o momento.</div>';
    }

    ob_start();
    ?>
    <div class="table-responsive">
      <table class="table align-middle table-striped mb-0">
        <thead>
          <tr>
            <th scope="col">Descrição</th>
            <th scope="col">Prioridade</th>
            <th scope="col">Data</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tarefas as $tarefa): ?>
            <tr>
              <td><?= escapar($tarefa['descricao']) ?></td>
              <td>
                <span class="badge rounded-pill <?= escapar(classe_badge_prioridade($tarefa['prioridade'])) ?>">
                  <?= escapar($tarefa['prioridade']) ?>
                </span>
              </td>
              <td><?= escapar($tarefa['data']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php

    $html = ob_get_clean();

    return $html === false ? '' : $html;
}

function resposta_json(array $dados, int $statusCode = 200): never
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');

    $json = json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($json === false) {
        echo '{"status":"error","mensagem":"Não foi possível gerar a resposta JSON."}';
        exit;
    }

    echo $json;
    exit;
}
