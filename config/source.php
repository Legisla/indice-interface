<?php

return [
    'legislature_id' => 57,
    'date' => [
        'start' => '2023-02-01'
    ],

    'indicators' => [
        'remove_outliers' => [1, 2, 3, 6, 8, 9, 13, 14, 15],
    ],

    'url' => [

        'root' => 'https://dadosabertos.camara.leg.br/api/',

        'amendments' => [
            'all' => 'https://www.portaltransparencia.gov.br/emendas/consulta/baixar?paginacaoSimples=true&' .
                'direcaoOrdenacao=asc&palavraChave=%s&de=%s&ate=%s',
            'selected_colunns' => '&colunasSelecionadas=codigoEmenda%2Cano%2Cautor%2CnumeroEmenda%2ClocalidadeDoGasto' .
                '%2Cfuncao%2Csubfuncao%2CvalorEmpenhado%2CvalorLiquidado%2CvalorPago',
        ],

        'parties' => [
            'all' => 'v2/partidos?ordem=ASC&ordenarPor=nome&pagina=1&itens=100',
            'details' => 'v2/partidos/',
            'members' => '/membros',
        ],

        'congresspeople' => [
            'all' => 'v2/deputados?idLegislatura=%d&ordem=ASC&ordenarPor=nome',
            'details' => 'v2/deputados/',
            'expenses' => 'v2/deputados/%d/despesas?ano=%d&mes=%d&ordem=ASC&ordenarPor=codDocumento&pagina=%d&itens=100'
        ],

        'propositions' => [
            'all' => 'v2/proposicoes?idDeputadoAutor=%s&dataApresentacaoInicio=%s&dataApresentacaoFim=%s&ordem=ASC&ordenarPor=id&pagina=%s&itens=100',
            'authors' => 'v2/proposicoes/%d/autores',
            'themes' => 'v2/proposicoes/%d/temas',
            'details' => 'v2/proposicoes/',
        ],

        'votations' => [
            'all' => 'v2/votacoes?dataInicio=%s&dataFim=%s&ordem=asc&ordenarPor=id&pagina=%d&itens=200',
            'votes' => 'v2/votacoes/%s/votos',
            'orientations' => 'v2/votacoes/%s/orientacoes'
        ],

        'events' => [
            'all' => 'v2/eventos?codTipoEvento=110&dataInicio=%s&dataFim=%s&ordem=ASC&ordenarPor=id&pagina=%d&itens=100',
            'presence' => 'v2/eventos/%d/deputados'
        ],

        'fronts' => [
            'all' => 'v2/frentes?idLegislatura=%d',
            'details' => 'v2/frentes/'
        ],

        'bodies' => [
            'all' => 'v2/orgaos?dataInicio=%s&dataFim=%s&ordem=ASC&ordenarPor=id&pagina=%d&itens=1000',
            'members' => 'v2/orgaos/%d/membros',
        ],

        'legislatures' => [
            'all' => 'v2/legislaturas/',
        ],

    ],

    'bodies_exception' => [
//        'CONGRESSO NACIONAL',
//        'Plenário',
//        'Plenário Comissão Geral',
//        'CâMARA DOS DEPUTADOS',
//        'Bancada de São Paulo',
//        'Bancada do Rio de Janeiro',
    ],


    'processment' => [
        'indicators' => [
            'chunk_size' => 1000,
        ],
        'debug_memory' => env('PROCESS_DEBUG_MEMORY', false),
        'csv_debug' => env('PROCESS_CSV_DEBUG', false),
        'mail' => [
            'failure' => env('IMPORT_FAILURE_MAIL_RECEIVER', ''),
        ],
    ],


    'import' => [
        'parties' => env('IMPORT_PARTIES', true),

        'congresspeople' => env('IMPORT_CONGRESSPEOPLE', true),

        'expenses' => env('IMPORT_EXPENSES', true),

        'events' => env('IMPORT_EVENTS', true),

        'votations' => env('IMPORT_VOTATIONS', true),

        'positions' => env('IMPORT_POSITIONS', true),

        'propositions' => env('IMPORT_PROPOSITIONS', true),

        'fronts' => env('IMPORT_FRONTS', true),

        'bodies' => env('IMPORT_BODIES', true),

        'amendments' => env('IMPORT_AMENDMENTS', true),

        'indicators' => env('PROCESS_INDICATORS', true),

        'scores' => env('PROCESS_SCORES', true),
    ],
];
