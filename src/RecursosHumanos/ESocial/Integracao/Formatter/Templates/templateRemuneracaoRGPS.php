<?php
return [
    'ideTrabalhador' => [
        'properties' => [
            'cpfTrab',
            'nisTrab'
        ],
        'groups' => [
            'infoMV' => [
                'properties' => [
                    'indMV' => [
                        'type' => 'int'
                    ]
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
            ],
            'infoComplem' => [
                'properties' => [
                    'nmTrab',
                    'dtNascto'
                ],
                'groups' => [
                    'sucessaoVinc' => [
                        'properties' => [
                            'nrInsc',
                            'matricAnt',
                            'dtAdm',
                            'observacao'
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
                        'codSusp'
                    ]
                ]
            ],
            'infoInterm' => [
                'properties' => [
                    'dia' => [
                        'type' => 'int'
                    ]
                ]
            ]
        ]
    ],
    'dmDev' => [
        'properties' => [
            'ideDmDev',
            'codCateg' => [
                'type' => 'int'
            ]
        ],
        'groups' => [
            'infoPerApur' => [
                'groups'=> [
                    'ideEstabLot' => [
                        'type' => 'array',
                        'items' => [
                            'properties' => [
                                'tpInsc' => [
                                    'type' => 'int'
                                ],
                                'nrInsc',
                                'codLotacao',
                                'qtdDiasAv' => [
                                    'type' => 'int'
                                ]
                            ],
                            'groups' => [
                                'remunPerApur' => [
                                    'type' => 'array',
                                    'items' => [
                                        'properties' => [
                                            'matricula',
                                            'indSimples' => [
                                                'type' => 'int'
                                            ]
                                        ],
                                        'groups' => [
                                            'itensRemun' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'properties' => [
                                                        'codRubr',
                                                        'ideTabRubr',
                                                        'qtdRubr' => [
                                                            'type' => 'float'
                                                        ],
                                                        'fatorRubr' => [
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
                                            'infoTrabInterm' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'properties' => [
                                                        'codConv'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'infoPerAnt' => [
                'groups' => [
                    'ideADC' => [
                        'type' => 'array',
                        'items' => [
                            'properties' => [
                                'dtAcConv',
                                'tpAcConv',
                                'compAcConv',
                                'dtEfAcConv',
                                'dsc',
                                'remunSuc'
                            ],
                            'groups' => [
                                'idePeriodo' => [
                                    'type' => 'array',
                                    'items' => [
                                        'properties' => [
                                            'perRef',
                                        ],
                                        'groups' => [
                                            'ideEstabLot' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'properties' => [
                                                        'tpInsc' => [
                                                            'type' => 'int'
                                                        ],
                                                        'nrInsc',
                                                        'codLotacao'
                                                    ],
                                                    'groups' => [
                                                        'remunPerAnt' => [
                                                            'type' => 'array',
                                                            'items' => [
                                                                'properties' => [
                                                                    'matricula',
                                                                    'indSimples' => [
                                                                        'type' => 'int'
                                                                    ],
                                                                ],
                                                                'groups' => [
                                                                    'itensRemun' => [
                                                                        'type' => 'array',
                                                                        'items' => [
                                                                            'properties' => [
                                                                                'codRubr',
                                                                                'ideTabRubr',
                                                                                'qtdRubr' => [
                                                                                    'type' => 'float'
                                                                                ],
                                                                                'fatorRubr' => [
                                                                                    'type' => 'float'
                                                                                ],
                                                                                'vrRubr' => [
                                                                                    'type' => 'float'
                                                                                ],
                                                                                'indApurIR' => [
                                                                                    'type' => 'int'
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
                                                                    'infoTrabInterm'  => [
                                                                        'type' => 'array',
                                                                        'items' => [
                                                                            'properties' => [
                                                                                'codConv'
                                                                            ]
                                                                        ]
                                                                    ]
                                                                ]
                                                            ]
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'infoComplCont' => [
                'properties' => [
                    'codCBO',
                    'natAtividade' => [
                        'type' => 'int'
                    ],
                    'qtdDiasTrab' => [
                        'type' => 'int'
                    ]
                ]
            ]
        ]
    ]
];
