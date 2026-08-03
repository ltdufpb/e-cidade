<?php
return [
    'ideTrabSemVinculo' => [
        'properties' => [
            'cpfTrab',
            'nisTrab',
            'termino_ideTrabSemVinculo_codCateg' =>'codCateg'
        ]
    ],
    'infoTSVTermino' => [
        'properties' => [
            'dtTerm',
            'mtvDesligTSV',
            'pensAlim',
            'percAliment',
            'vrAlim',
        ],
        'groups' => [
            'verbasResc' => [
                'groups'=> [
                    'dmDev' => [
                        'groups' => [
                            'ideEstabLot' => [
                                'properties' => [
                                    'termino_lotacao_tpInsc' => 'tpInsc',
                                    'nrInsc',
                                    'codLotacao'
                                ],
                                'groups' => [
                                    'detVerbas' => [
                                        'type' => 'array',
                                        'items' => [
                                            'properties' => [
                                                'codRubr',
                                                'ideTabRubr',
                                                'qtdRubr' => [
                                                    'type' => 'float'
                                                ],
                                                'fatorRubr',
                                                'vrUnit' => [
                                                    'type' => 'float'
                                                ],
                                                'vrRubr' => [
                                                    'type' => 'float'
                                                ]
                                            ]
                                        ]
                                    ],
                                    'infoSaudeColet' => [
                                        'groups' => [
                                            'detOper' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'properties' => [
                                                        'cnpjOper',
                                                        'regANS',
                                                        'vrPgTit' => [
                                                            'type' => 'float'
                                                        ]
                                                    ],
                                                    'groups' => [
                                                        'detPlano' => [
                                                            'type' => 'array',
                                                            'items' => [
                                                                'properties' => [
                                                                    'tpDep',
                                                                    'cpfDep',
                                                                    'nmDep',
                                                                    'dtNascto',
                                                                    'vlrPgDep' => [
                                                                        'type' => 'float'
                                                                    ]
                                                                ]
                                                            ]
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    'infoAgNocivo' => [
                                        'properties' => [
                                            'grauExp' => [
                                                'type' => 'int'
                                            ]
                                        ]
                                    ],
                                    'infoSimples' => [
                                        'properties' => [
                                            'termino_indSimples' => 'indSimples'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'procJudTrab' => [
                        'type' => 'array',
                        'items' => [
                            'properties' => [
                                'tpTrib' => [
                                    'type' => 'int'
                                ],
                                'nrProcJud',
                                'codSusp' => [
                                    'type' => 'int'
                                ]
                            ]
                        ]
                    ],
                    'infoMV' => [
                        'properties' => [
                            'indMV'
                        ],
                        'groups' => [
                            'remunOutrEmpr' =>  [
                                'type' => 'array',
                                'items' => [
                                    'properties' => [
                                        'tpInsc' => [
                                            'type' => 'int'
                                        ],
                                        'nrInsc',
                                        'codCateg' => [
                                            'type' => 'int'
                                        ],
                                        'vlrRemunOE' => [
                                            'type' => 'float'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'quarentena' => [
                'properties' => [
                    'dtFimQuar'
                ]
            ],
            'mudancaCPF' => [
                'properties' => [
                    'novoCPF'
                ]
            ]
        ]
    ],
    'termino_rubricas' => [
        'properties' => [
            'desligamento_rubricas_json'
        ]
    ]
];
