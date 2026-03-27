<?php
declare(strict_types=1);

function is_logs_authenticated(): bool
{
    return ($_SESSION['logs_authenticated'] ?? false) === true;
}

function attempt_logs_login(string $secret): bool
{
    if (!hash_equals(LOGS_SECRET, trim($secret))) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['logs_authenticated'] = true;
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    return true;
}

function logout_logs_user(): void
{
    unset($_SESSION['logs_authenticated']);
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    session_regenerate_id(true);
}
