<?php
return [
    'ideRubrica' => [
        'properties' => [
            'codRubr',
            'ideTabRubr',
            'iniValid',
            'fimValid'
        ]
    ],
    'dadosRubrica' => [
        'properties' => [
            'dscRubr',
            'natRubr' => [
                'type' => 'int'
            ],
            'tpRubr' => [
                'type' => 'int'
            ],
            'codIncCP',
            'codIncIRRF',
            'codIncFGTS',
            'codIncCPRP',
            'tetoRemun',
            'observacao',
        ],
        'groups' => [
            'ideProcessoCP' => [
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'tpProc' => [
                            'type' => 'int'
                        ],
                        'nrProc',
                        'extDecisao' => [
                            'type' => 'int'
                        ],
                        'codSusp'
                    ]
                ]
            ],
            'ideProcessoIRRF' => [
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'nrProc',
                        'codSusp'
                    ]
                ]
            ],
            'ideProcessoFGTS' => [
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'nrProc'
                    ]
                ]
            ]
        ]
    ]
];
