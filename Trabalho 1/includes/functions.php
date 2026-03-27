<?php
declare(strict_types=1);

function escape_html(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function current_method(): string
{
    return strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
}

function is_post_request(): bool
{
    return current_method() === 'POST';
}

function redirect_to(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function nav_link_class(string $activePage, string $pageKey): string
{
    return $activePage === $pageKey ? 'site-nav__link is-active' : 'site-nav__link';
}

function tracked_page_exists(string $pageKey): bool
{
    return array_key_exists($pageKey, tracked_pages());
}

function tracked_page(string $pageKey): array
{
    $pages = tracked_pages();

    if (!isset($pages[$pageKey])) {
        throw new InvalidArgumentException('Página monitorada inválida.');
    }

    return $pages[$pageKey];
}

function set_feedback_message(string $message, string $type = 'info'): void
{
    $_SESSION['feedback'] = [
        'message' => $message,
        'type' => $type,
    ];
}

function consume_feedback_message(): ?array
{
    $feedback = $_SESSION['feedback'] ?? null;
    unset($_SESSION['feedback']);

    if (!is_array($feedback) || !isset($feedback['message'], $feedback['type'])) {
        return null;
    }

    return [
        'message' => (string) $feedback['message'],
        'type' => (string) $feedback['type'],
    ];
}

function csrf_token(): string
{
    $token = $_SESSION['csrf_token'] ?? null;

    if (!is_string($token) || $token === '') {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
    }

    return $token;
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . escape_html(csrf_token()) . '">';
}

function is_valid_csrf_token(?string $token): bool
{
    return is_string($token) && hash_equals(csrf_token(), $token);
}

function current_timestamp(): string
{
    return date('Y-m-d H:i:s');
}

function format_datetime_for_display(string $value): string
{
    $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $value);

    if ($dateTime instanceof DateTimeImmutable) {
        return $dateTime->format('d/m/Y H:i:s');
    }

    return $value;
}

function client_ip_address(): string
{
    $candidates = [
        $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null,
        $_SERVER['HTTP_CLIENT_IP'] ?? null,
        $_SERVER['REMOTE_ADDR'] ?? null,
    ];

    foreach ($candidates as $candidate) {
        if (!is_string($candidate) || trim($candidate) === '') {
            continue;
        }

        foreach (explode(',', $candidate) as $ip) {
            $ip = trim($ip);

            if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                return $ip;
            }
        }
    }

    return 'IP não identificado';
}

function client_user_agent(): string
{
    $userAgent = trim((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''));

    return $userAgent !== '' ? $userAgent : 'Navegador não identificado';
}

function shortened_user_agent(string $userAgent, int $limit = 96): string
{
    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($userAgent, 'UTF-8') <= $limit) {
            return $userAgent;
        }

        return mb_substr($userAgent, 0, $limit - 1, 'UTF-8') . '…';
    }

    if (strlen($userAgent) <= $limit) {
        return $userAgent;
    }

    return substr($userAgent, 0, $limit - 3) . '...';
}
