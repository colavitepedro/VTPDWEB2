<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

encerrar_sessao_logs();
definir_mensagem('Sessão encerrada. Para consultar os logs novamente, informe a chave de acesso.', 'info');

redirecionar('logs.php');
