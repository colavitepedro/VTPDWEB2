<?php
declare(strict_types=1);

const NOME_APLICACAO = 'Servidor Web da disciplina de VTPDWE2 2026/01';
const NOME_TEMA = 'Linha evolutiva do Mudkip';
const FUSO_HORARIO_APLICACAO = 'America/Sao_Paulo';
const NOME_ALUNO = 'Pedro Colavite Conilho';
const EMAIL_ALUNO = 'colavitepedro1@gmail.com';
const FOTO_ALUNO = 'assets/img/fotoPedro.jpg';
const URL_ATIVIDADE_CEP = 'busca-cep.php';
const CHAVE_ACESSO_LOGS = 'senha_da_nasa';

const POKEDEX_PAGINAS = [
    'mudkip' => [
        'nome' => 'Mudkip',
        'numero' => '#0258',
        'arquivo' => 'mudkip.php',
        'rotulo' => 'Mudkip',
        'estagio' => 'Forma inicial',
        'categoria' => 'Pokémon Peixe da Lama',
        'descricao' => 'Mudkip usa a nadadeira da cabeça como um radar muito sensível. Assim, percebe movimentos da água e do ar ao redor mesmo sem depender da visão.',
        'papel' => 'Mudkip representa o começo da linha evolutiva e concentra a identidade aquática da família, com foco em percepção e mobilidade na água.',
        'tipos' => ['Água'],
        'habilidades' => ['Torrent', 'Damp (oculta)'],
        'altura' => '0,4 m',
        'peso' => '7,6 kg',
        'imagem' => 'assets/img/mudkip.png',
        'resumo' => 'Mudkip é a forma inicial aquática da linha evolutiva.',
    ],
    'marshtomp' => [
        'nome' => 'Marshtomp',
        'numero' => '#0259',
        'arquivo' => 'marshtomp.php',
        'rotulo' => 'Marshtomp',
        'estagio' => 'Forma intermediária',
        'categoria' => 'Pokémon Peixe da Lama',
        'descricao' => 'Marshtomp é coberto por uma película fina e pegajosa que ajuda a viver em terra firme. Quando a maré baixa, gosta de brincar na lama das praias.',
        'papel' => 'Marshtomp é a fase de transição da linha evolutiva. Ele combina adaptação ao ambiente terrestre com a mesma base aquática herdada de Mudkip.',
        'tipos' => ['Água', 'Terra'],
        'habilidades' => ['Torrent', 'Damp (oculta)'],
        'altura' => '0,7 m',
        'peso' => '28,0 kg',
        'imagem' => 'assets/img/marshtomp.png',
        'resumo' => 'Marshtomp representa a adaptação terrestre da linha evolutiva.',
    ],
    'swampert' => [
        'nome' => 'Swampert',
        'numero' => '#0260',
        'arquivo' => 'swampert.php',
        'rotulo' => 'Swampert',
        'estagio' => 'Forma final',
        'categoria' => 'Pokémon Peixe da Lama',
        'descricao' => 'Swampert tem força suficiente para arrastar rochas com mais de uma tonelada. Sua visão potente também permite enxergar com clareza até em águas barrentas.',
        'papel' => 'Swampert fecha a linha evolutiva com foco em força bruta, resistência e domínio de ambientes difíceis, principalmente água turva e terreno lamacento.',
        'tipos' => ['Água', 'Terra'],
        'habilidades' => ['Torrent', 'Damp (oculta)'],
        'altura' => '1,5 m',
        'peso' => '81,9 kg',
        'imagem' => 'assets/img/swampert.png',
        'resumo' => 'Swampert é a forma final poderosa da linha evolutiva.',
    ],
];

const PAGINAS_MONITORADAS = [
    'mudkip' => [
        'rotulo' => 'Mudkip',
        'arquivo' => 'mudkip.php',
        'resumo' => 'Mudkip é a forma inicial aquática da linha evolutiva.',
    ],
    'marshtomp' => [
        'rotulo' => 'Marshtomp',
        'arquivo' => 'marshtomp.php',
        'resumo' => 'Marshtomp representa a adaptação terrestre da linha evolutiva.',
    ],
    'swampert' => [
        'rotulo' => 'Swampert',
        'arquivo' => 'swampert.php',
        'resumo' => 'Swampert é a forma final poderosa da linha evolutiva.',
    ],
];

const MENU_PRINCIPAL = [
    'mudkip' => [
        'rotulo' => 'Mudkip',
        'arquivo' => 'mudkip.php',
    ],
    'marshtomp' => [
        'rotulo' => 'Marshtomp',
        'arquivo' => 'marshtomp.php',
    ],
    'swampert' => [
        'rotulo' => 'Swampert',
        'arquivo' => 'swampert.php',
    ],
    'logs' => [
        'rotulo' => 'Logs de Acesso',
        'arquivo' => 'logs.php',
    ],
];
