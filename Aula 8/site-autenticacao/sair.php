<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$mensagem = usuario_esta_autenticado()
    ? 'Sessão encerrada com sucesso.'
    : 'Nenhuma sessão ativa foi encontrada.';

encerrar_sessao_usuario();
session_start();
definir_flash('info', $mensagem);

redirecionar('index.php');
