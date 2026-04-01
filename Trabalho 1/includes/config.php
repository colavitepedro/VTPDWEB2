<?php
declare(strict_types=1);

const NOME_APLICACAO = 'Servidor Web da disciplina de VTPDWE2 2026/01';
const FUSO_HORARIO_APLICACAO = 'America/Sao_Paulo';
const NOME_ALUNO = 'Pedro Colavite Conilho';
const EMAIL_ALUNO = 'colavitepedro1@gmail.com';
const FOTO_ALUNO = 'assets/img/fotoPedro.jpg';
const URL_ATIVIDADE_CEP = 'busca-cep.php';
const CHAVE_ACESSO_LOGS = 'senha_da_nasa';

const PAGINAS_MONITORADAS = [
    'inicio' => [
        'rotulo' => 'Início',
        'arquivo' => 'inicio.php',
        'resumo' => 'Apresentação do projeto e dos requisitos do trabalho.',
    ],
    'sobre' => [
        'rotulo' => 'Sobre',
        'arquivo' => 'sobre.php',
        'resumo' => 'Resumo das decisões usadas na construção do site.',
    ],
    'contato' => [
        'rotulo' => 'Contato',
        'arquivo' => 'contato.php',
        'resumo' => 'Informações de contato e de publicação do projeto.',
    ],
];

const MENU_PRINCIPAL = [
    'inicio' => [
        'rotulo' => 'Início',
        'arquivo' => 'inicio.php',
    ],
    'sobre' => [
        'rotulo' => 'Sobre',
        'arquivo' => 'sobre.php',
    ],
    'contato' => [
        'rotulo' => 'Contato',
        'arquivo' => 'contato.php',
    ],
    'logs' => [
        'rotulo' => 'Logs de Acesso',
        'arquivo' => 'logs.php',
    ],
];
