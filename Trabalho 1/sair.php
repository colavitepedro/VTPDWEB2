<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

logout_logs_user();
set_feedback_message('Sessão encerrada. Para consultar os logs novamente, informe a chave de acesso.', 'info');

redirect_to('logs.php');
