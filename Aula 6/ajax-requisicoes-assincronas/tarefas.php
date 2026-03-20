<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/funcoes.php';

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {
    if ($metodo === 'GET') {
        $acao = (string) ($_GET['acao'] ?? 'listar');

        if ($acao !== 'listar') {
            resposta_json([
                'status' => 'error',
                'mensagem' => 'Ação inválida para requisições GET.',
                'htmlTabela' => '',
            ], 400);
        }

        $tarefas = ler_tarefas();

        resposta_json([
            'status' => 'success',
            'mensagem' => 'Tarefas carregadas com sucesso.',
            'htmlTabela' => renderizar_tabela_tarefas($tarefas),
        ]);
    }

    if ($metodo !== 'POST') {
        resposta_json([
            'status' => 'error',
            'mensagem' => 'Método não permitido.',
            'htmlTabela' => '',
        ], 405);
    }

    $acao = (string) ($_POST['acao'] ?? '');

    if ($acao === 'cadastrar') {
        $descricao = sanitizar_texto_linha((string) ($_POST['descricao'] ?? ''));
        $prioridade = (string) ($_POST['prioridade'] ?? '');

        if ($descricao === '') {
            resposta_json([
                'status' => 'error',
                'mensagem' => 'Informe a descrição da tarefa.',
                'htmlTabela' => renderizar_tabela_tarefas(ler_tarefas()),
            ], 422);
        }

        if (!prioridade_valida($prioridade)) {
            resposta_json([
                'status' => 'error',
                'mensagem' => 'Selecione uma prioridade válida.',
                'htmlTabela' => renderizar_tabela_tarefas(ler_tarefas()),
            ], 422);
        }

        $tarefas = ler_tarefas();
        $tarefas[] = [
            'descricao' => $descricao,
            'prioridade' => $prioridade,
            'data' => date('d/m/Y H:i'),
        ];

        salvar_tarefas($tarefas);

        resposta_json([
            'status' => 'success',
            'mensagem' => 'Tarefa cadastrada com sucesso.',
            'htmlTabela' => renderizar_tabela_tarefas($tarefas),
        ]);
    }

    if ($acao === 'apagar') {
        salvar_tarefas([]);

        resposta_json([
            'status' => 'success',
            'mensagem' => 'Todas as tarefas foram apagadas.',
            'htmlTabela' => renderizar_tabela_tarefas([]),
        ]);
    }

    resposta_json([
        'status' => 'error',
        'mensagem' => 'Ação inválida.',
        'htmlTabela' => '',
    ], 400);
} catch (RuntimeException $exception) {
    resposta_json([
        'status' => 'error',
        'mensagem' => $exception->getMessage(),
        'htmlTabela' => '',
    ], 500);
}
