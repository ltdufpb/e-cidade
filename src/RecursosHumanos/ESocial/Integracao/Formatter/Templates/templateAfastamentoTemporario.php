<?php
return [
    'ideVinculo' => [
        'properties' => [
            'cpfTrab',
            'nisTrab' => [
                'required' => false,
            ],
            'matricula' => [
                'required' => false,
            ],
            'codCateg' => [
                'required' => false,
            ]
        ]
    ],
    'infoAfastamento' => [
        'groups' => [
            'iniAfastamento' => [
                'properties' => [
                    'dtIniAfast',
                    'codMotAfast',
                    'infoMesmoMtv' => [
                        'required' => false,
                    ],
                    'tpAcidTransito' => [
                        'required' => false,
                    ],
                    'observacao' => [
                        'required' => false,
                    ],
                ],
                'groups' => [
                    'perAquis' => [
                        'required' => false,
                        'properties' => [
                            'dtInicio' => [
                                'required' => true,
                            ],
                            'dtFim' => [
                                'required' => false
                            ]
                        ]
                    ],
                    'infoCessao' => [
                        'required' => false,
                        'properties' => [
                            'cnpjCess',
                            'infOnus' => [
                                'type' => 'int'
                            ]
                        ]
                    ],
                    'infoMandSind' => [
                        'required' => false,
                        'properties' => [
                            'cnpjSind',
                            'infOnusRemun' => [
                                'type' => 'int'
                            ]
                        ]
                    ]
                ]
            ],
            'infoRetif' => [
                'required' => false,
                'properties' => [
                    'origRetif' => [
                        'type' => 'int'
                    ],
                    'tpProc' => [
                        'required' => false,
                        'type' => 'int'
                    ],
                    'nrProc' => [
                        'required' => false,
                    ]
                ]
            ],
            'fimAfastamento' => [
                'required' => false,
                'properties' => [
                    'dtTermAfast'
                ]
            ]
        ]
    ]
];
