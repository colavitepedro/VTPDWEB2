<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/funcoes.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    resposta_json([
        'status' => 'error',
        'mensagem' => 'Método não permitido.',
        'fieldClass' => 'is-invalid',
        'feedbackClass' => 'text-danger',
    ], 405);
}

$emailBruto = (string) ($_POST['email'] ?? '');
$email = sanitizar_email($emailBruto);

if (trim($emailBruto) === '') {
    resposta_json([
        'status' => 'error',
        'mensagem' => 'Informe um e-mail.',
        'fieldClass' => 'is-invalid',
        'feedbackClass' => 'text-danger',
    ], 422);
}

if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    resposta_json([
        'status' => 'error',
        'mensagem' => 'Informe um e-mail válido.',
        'fieldClass' => 'is-invalid',
        'feedbackClass' => 'text-danger',
    ], 422);
}

try {
    $emails = ler_emails();

    if (in_array($email, $emails, true)) {
        resposta_json([
            'status' => 'error',
            'mensagem' => 'Este e-mail já está cadastrado.',
            'fieldClass' => 'is-invalid',
            'feedbackClass' => 'text-danger',
        ], 409);
    }

    salvar_email($email);

    resposta_json([
        'status' => 'success',
        'mensagem' => 'E-mail disponível e cadastrado com sucesso.',
        'fieldClass' => 'is-valid',
        'feedbackClass' => 'text-success',
    ]);
} catch (RuntimeException $exception) {
    resposta_json([
        'status' => 'error',
        'mensagem' => $exception->getMessage(),
        'fieldClass' => 'is-invalid',
        'feedbackClass' => 'text-danger',
    ], 500);
}
