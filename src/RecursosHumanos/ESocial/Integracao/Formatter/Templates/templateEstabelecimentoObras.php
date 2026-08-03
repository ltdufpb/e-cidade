<?php
return [
    'ideEstab' => [
        'nome_api' => 'ideEstab',
        'properties' => [
            'tpInsc' => [
                'nome_api'=> 'tpInsc',
                'type' => 'int'
            ],
            'nrInsc' => [
                'nome_api'=> 'nrInsc',
                'type' => 'string'
            ],
            'iniValid1005' => 'iniValid',
            'fimValid1005' => 'fimValid'
        ]
    ],
    'dadosEstab' => [
        'nome_api' => 'dadosEstab',
        'properties' => [
            'cnaePrep' => [
              'type' => 'string'
            ]
        ],
        'groups' =>  [
            'aliqGilrat' => [
                'nome_api' => 'aliqGilrat',
                'properties' => [
                    'aliqRat' => [
                        'nome_api'=>'aliqRat',
                        'type' => 'integer'
                    ],
                    'fap' => [
                        'nome_api'=>'fap',
                        'type' => 'string'
                    ]
                ],
                'groups' => [
                    'procAdmJudRat' =>  [
                        'properties' => [
                            'tpProc' => [
                                'nome_api'=> 'tpProc',
                                'type' => 'int'
                            ],
                            'nrProc' => 'nrProc',
                            'codSusp'
                        ]
                    ],
                    'procAdmJudFap' =>  [
                        'properties' => [
                            'tpProc' => [
                                'nome_api'=> 'tpProc',
                                'type' => 'int'
                            ],
                            'nrProc' => 'nrProc',
                            'codSusp'
                        ]
                    ]
                ]
            ],
            'infoCaepf' =>  [
                'nome_api' => 'infoCaepf',
                'properties' => [
                    'tpCaepf' => [
                        'nome_api'=> 'tpCaepf',
                        'type' => 'int'
                    ],
                ]
            ],
            'infoObra' =>  [
                'nome_api' => 'infoObra',
                'properties' => [
                    'indSubstPatrObra' => [
                        'nome_api'=>  'indSubstPatrObra',
                        'type' => 'int'
                    ]
                ]
            ],
            'infoTrab' =>  [
                'nome_api' => 'infoTrab',
                'groups' => [
                    'infoApr' =>  [
                        'nome_api' => 'infoApr',
                        'groups' => [
                            'infoEntEduc' =>  [
                                'type' => 'array',
                                'label' => 'Identificação da(s) entidade(s) educativa(s) ou de prática desportiva',
                                'nome_api' => 'infoEntEduc',
                                'items' => [
                                    'properties' => [
                                        'nrInsc'
                                    ]
                                ]
                            ],
                        ]
                    ],
                    'infoPCD' =>  [
                        'nome_api' => 'infoPCD',
                        'properties' => [
                            'nrProcJud' => 'nrProcJud'
                        ]
                    ]
                ]
            ],
        ]
    ],
];
