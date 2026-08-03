<?php
return [
    'ideProcesso' => [
        'properties' => [
            'tpProc'=> [
                'type' => 'int'
            ],
            'nrProc',
            'iniValid',
            'fimValid'
        ]
    ],
    'dadosProc' => [
        'properties' => [
            'indAutoria'=> [
                'type' => 'int'
            ],
            'indMatProc'=> [
                'type' => 'int'
            ],
            'observacao'
        ],
        'groups' => [
            'dadosProcJud' => [
                'properties' => [
                    'ufVara',
                    'codMunic',
                    'idVara'
                ]
            ],
            'infoSusp_1' => [
                'nome_api' => 'infoSusp',
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'codSusp_1'=> 'codSusp',
                        'indSusp_1' => 'indSusp',
                        'dtDecisao_1' => 'dtDecisao',
                        'indDeposito_1' =>'indDeposito'
                    ]
                ]
            ],
            'infoSusp_2' => [
                'nome_api' => 'infoSusp',
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'codSusp_2'=> 'codSusp',
                        'indSusp_2' => 'indSusp',
                        'dtDecisao_2' => 'dtDecisao',
                        'indDeposito_2' =>'indDeposito'
                    ]
                ]
            ],
            'infoSusp_3' => [
                'nome_api' => 'infoSusp',
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'codSusp_3'=> 'codSusp',
                        'indSusp_3' => 'indSusp',
                        'dtDecisao_3' => 'dtDecisao',
                        'indDeposito_3' =>'indDeposito'
                    ]
                ]
            ],
            'infoSusp_4' => [
                'nome_api' => 'infoSusp',
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'codSusp_4'=> 'codSusp',
                        'indSusp_4' => 'indSusp',
                        'dtDecisao_4' => 'dtDecisao',
                        'indDeposito_4' =>'indDeposito'
                    ]
                ]
            ],
            'infoSusp_5' => [
                'nome_api' => 'infoSusp',
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'codSusp_5'=> 'codSusp',
                        'indSusp_5' => 'indSusp',
                        'dtDecisao_5' => 'dtDecisao',
                        'indDeposito_5' =>'indDeposito'
                    ]
                ]
            ]
        ]
    ]
];
