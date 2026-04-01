<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/funcoes.php';

date_default_timezone_set(FUSO_HORARIO_APLICACAO);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
