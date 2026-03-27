<?php
declare(strict_types=1);

const APP_NAME = 'Servidor Web da disciplina de VTPDWE2 2026/01';
const APP_TIMEZONE = 'America/Sao_Paulo';
const STUDENT_NAME = 'Pedro Colavite Conilho';
const STUDENT_EMAIL = 'colavitepedro1@gmail.com';
const STUDENT_PHOTO = 'assets/img/fotoPedro.jpg';
const CEP_ACTIVITY_URL = 'busca-cep.php';
const LOGS_SECRET = 'senha_da_nasa';

function tracked_pages(): array
{
    return [
        'inicio' => [
            'label' => 'Início',
            'file' => 'inicio.php',
            'summary' => 'Panorama do projeto e dos objetivos do laboratório.',
        ],
        'sobre' => [
            'label' => 'Sobre',
            'file' => 'sobre.php',
            'summary' => 'Bastidores, escolhas técnicas e princípios usados no trabalho.',
        ],
        'contato' => [
            'label' => 'Contato',
            'file' => 'contato.php',
            'summary' => 'Canais de contato e informações rápidas para networking.',
        ],
    ];
}

function internal_navigation(): array
{
    $navigation = tracked_pages();
    $navigation['logs'] = [
        'label' => 'Logs de Acesso',
        'file' => 'logs.php',
        'summary' => 'Estatísticas e registros das visualizações monitoradas.',
    ];

    return $navigation;
}
