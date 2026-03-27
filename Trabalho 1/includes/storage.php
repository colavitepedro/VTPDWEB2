<?php
declare(strict_types=1);

function storage_dir(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage';
}

function counter_state_path(): string
{
    return storage_dir() . DIRECTORY_SEPARATOR . 'counters.txt';
}

function logs_path(): string
{
    return storage_dir() . DIRECTORY_SEPARATOR . 'access_logs.txt';
}

function lock_path(): string
{
    return storage_dir() . DIRECTORY_SEPARATOR . 'state.lock';
}

function legacy_counter_state_path(): string
{
    return storage_dir() . DIRECTORY_SEPARATOR . 'counters.json';
}

function legacy_logs_path(): string
{
    return storage_dir() . DIRECTORY_SEPARATOR . 'access_logs.jsonl';
}

function default_counter_state(): array
{
    return [
        'pages' => array_fill_keys(array_keys(tracked_pages()), 0),
        'next_log_id' => 1,
    ];
}

function ensure_storage_ready(): void
{
    $directory = storage_dir();

    if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
        throw new RuntimeException('NÃ£o foi possÃ­vel criar a pasta de armazenamento.');
    }

    migrate_legacy_storage_file(legacy_counter_state_path(), counter_state_path());
    migrate_legacy_storage_file(legacy_logs_path(), logs_path());

    if (!is_file(counter_state_path())) {
        $json = json_encode(default_counter_state(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $saved = file_put_contents(counter_state_path(), (string) $json . PHP_EOL);

        if ($saved === false) {
            throw new RuntimeException('NÃ£o foi possÃ­vel inicializar o arquivo de contadores.');
        }
    }

    if (!is_file(logs_path()) && touch(logs_path()) === false) {
        throw new RuntimeException('NÃ£o foi possÃ­vel inicializar o arquivo de logs.');
    }

    if (!is_file(lock_path()) && touch(lock_path()) === false) {
        throw new RuntimeException('NÃ£o foi possÃ­vel criar o arquivo de bloqueio.');
    }
}

function migrate_legacy_storage_file(string $legacyPath, string $targetPath): void
{
    if (is_file($targetPath) || !is_file($legacyPath)) {
        return;
    }

    if (@rename($legacyPath, $targetPath)) {
        return;
    }

    $content = @file_get_contents($legacyPath);

    if (!is_string($content)) {
        return;
    }

    $saved = @file_put_contents($targetPath, $content);

    if ($saved === false) {
        return;
    }

    @unlink($legacyPath);
}

function with_storage_lock(callable $callback)
{
    ensure_storage_ready();

    $handle = fopen(lock_path(), 'c+');

    if ($handle === false) {
        throw new RuntimeException('NÃ£o foi possÃ­vel abrir o arquivo de bloqueio.');
    }

    try {
        if (!flock($handle, LOCK_EX)) {
            throw new RuntimeException('NÃ£o foi possÃ­vel bloquear o armazenamento.');
        }

        return $callback();
    } finally {
        flock($handle, LOCK_UN);
        fclose($handle);
    }
}

function normalize_counter_state(array $state): array
{
    $pages = default_counter_state()['pages'];

    if (isset($state['pages']) && is_array($state['pages'])) {
        foreach ($pages as $pageKey => $count) {
            $pages[$pageKey] = max(0, (int) ($state['pages'][$pageKey] ?? 0));
        }
    }

    $nextLogId = max(1, (int) ($state['next_log_id'] ?? 1));

    return [
        'pages' => $pages,
        'next_log_id' => $nextLogId,
    ];
}

function read_counter_state_unlocked(): array
{
    $raw = @file_get_contents(counter_state_path());

    if (!is_string($raw) || trim($raw) === '') {
        return default_counter_state();
    }

    $decoded = json_decode($raw, true);

    if (!is_array($decoded)) {
        return default_counter_state();
    }

    return normalize_counter_state($decoded);
}

function write_counter_state_unlocked(array $state): void
{
    $normalized = normalize_counter_state($state);
    $json = json_encode($normalized, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    if ($json === false) {
        throw new RuntimeException('NÃ£o foi possÃ­vel serializar o estado dos contadores.');
    }

    $saved = file_put_contents(counter_state_path(), $json . PHP_EOL);

    if ($saved === false) {
        throw new RuntimeException('NÃ£o foi possÃ­vel gravar o estado dos contadores.');
    }
}

function read_logs_unlocked(): array
{
    $lines = file(logs_path(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (!is_array($lines)) {
        return [];
    }

    $logs = [];

    foreach ($lines as $line) {
        $decoded = json_decode($line, true);

        if (!is_array($decoded)) {
            continue;
        }

        $logs[] = [
            'id' => max(1, (int) ($decoded['id'] ?? 0)),
            'page_key' => (string) ($decoded['page_key'] ?? ''),
            'page_name' => (string) ($decoded['page_name'] ?? ''),
            'accessed_at' => (string) ($decoded['accessed_at'] ?? ''),
            'ip' => (string) ($decoded['ip'] ?? 'IP nÃ£o identificado'),
            'user_agent' => (string) ($decoded['user_agent'] ?? 'Navegador nÃ£o identificado'),
        ];
    }

    return $logs;
}

function append_log_entry_unlocked(array $entry): void
{
    $handle = fopen(logs_path(), 'ab');

    if ($handle === false) {
        throw new RuntimeException('NÃ£o foi possÃ­vel abrir o arquivo de logs para escrita.');
    }

    try {
        $payload = json_encode($entry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if ($payload === false) {
            throw new RuntimeException('NÃ£o foi possÃ­vel serializar um registro de acesso.');
        }

        if (fwrite($handle, $payload . PHP_EOL) === false) {
            throw new RuntimeException('NÃ£o foi possÃ­vel gravar um registro de acesso.');
        }
    } finally {
        fclose($handle);
    }
}

function rewrite_logs_unlocked(array $logs): void
{
    $rows = [];

    foreach ($logs as $log) {
        $payload = json_encode($log, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if ($payload !== false) {
            $rows[] = $payload;
        }
    }

    $content = $rows === [] ? '' : implode(PHP_EOL, $rows) . PHP_EOL;
    $handle = fopen(logs_path(), 'c+b');

    if ($handle === false) {
        throw new RuntimeException('NÃ£o foi possÃ­vel abrir o arquivo de logs para regravaÃ§Ã£o.');
    }

    try {
        if (!ftruncate($handle, 0)) {
            throw new RuntimeException('NÃ£o foi possÃ­vel limpar o conteÃºdo anterior do arquivo de logs.');
        }

        rewind($handle);

        if ($content !== '' && fwrite($handle, $content) === false) {
            throw new RuntimeException('NÃ£o foi possÃ­vel gravar o novo conteÃºdo do arquivo de logs.');
        }

        fflush($handle);
    } finally {
        fclose($handle);
    }
}

function record_page_view(string $pageKey): void
{
    if (!tracked_page_exists($pageKey)) {
        throw new InvalidArgumentException('PÃ¡gina invÃ¡lida para registro de acesso.');
    }

    with_storage_lock(function () use ($pageKey): void {
        $state = read_counter_state_unlocked();
        $page = tracked_page($pageKey);

        $state['pages'][$pageKey] = max(0, (int) ($state['pages'][$pageKey] ?? 0)) + 1;

        $entry = [
            'id' => max(1, (int) ($state['next_log_id'] ?? 1)),
            'page_key' => $pageKey,
            'page_name' => (string) $page['label'],
            'accessed_at' => current_timestamp(),
            'ip' => client_ip_address(),
            'user_agent' => client_user_agent(),
        ];

        append_log_entry_unlocked($entry);
        $state['next_log_id'] = (int) $entry['id'] + 1;

        write_counter_state_unlocked($state);
    });
}

function register_page_view_with_feedback(string $pageKey): ?string
{
    try {
        record_page_view($pageKey);

        return null;
    } catch (Throwable $throwable) {
        return 'O acesso a esta pÃ¡gina foi exibido, mas nÃ£o foi possÃ­vel gravar a visita nos arquivos de controle.';
    }
}

function access_dashboard_data(): array
{
    return with_storage_lock(function (): array {
        $state = read_counter_state_unlocked();
        $pages = [];

        foreach ($state['pages'] as $pageKey => $count) {
            $page = tracked_page($pageKey);
            $pages[] = [
                'key' => $pageKey,
                'label' => (string) $page['label'],
                'file' => (string) $page['file'],
                'summary' => (string) $page['summary'],
                'count' => max(0, (int) $count),
            ];
        }

        usort(
            $pages,
            static function (array $left, array $right): int {
                if ($left['count'] === $right['count']) {
                    return strcmp((string) $left['label'], (string) $right['label']);
                }

                return $right['count'] <=> $left['count'];
            }
        );

        return [
            'pages' => $pages,
            'total' => array_sum(array_map(static fn (array $page): int => (int) $page['count'], $pages)),
            'logs' => array_reverse(read_logs_unlocked()),
        ];
    });
}

function clear_single_counter(string $pageKey): void
{
    if (!tracked_page_exists($pageKey)) {
        throw new InvalidArgumentException('PÃ¡gina invÃ¡lida para limpeza de contador.');
    }

    with_storage_lock(function () use ($pageKey): void {
        $state = read_counter_state_unlocked();
        $state['pages'][$pageKey] = 0;
        write_counter_state_unlocked($state);
    });
}

function clear_all_counters(): void
{
    with_storage_lock(function (): void {
        $state = read_counter_state_unlocked();

        foreach (array_keys($state['pages']) as $pageKey) {
            $state['pages'][$pageKey] = 0;
        }

        write_counter_state_unlocked($state);
    });
}

function clear_access_logs(): void
{
    with_storage_lock(function (): void {
        $state = read_counter_state_unlocked();
        $state['next_log_id'] = 1;

        rewrite_logs_unlocked([]);
        write_counter_state_unlocked($state);
    });
}
