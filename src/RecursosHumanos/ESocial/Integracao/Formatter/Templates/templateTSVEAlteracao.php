<?php
/* S-2306 - Trabalhador Sem Vínculo de Emprego/Estatutário - Alteração */
return [
    'ideTrabSemVinculo' => [
        'properties' => [
            'cpfTrab',
            'nisTrab',
            'codCateg' => [
              'type' => 'int'
            ]
        ]
    ],
    'infoTSVAlteracao' => [
        'properties' => [
            'dtAlteracao',
            'natAtividade' => [
                'type' => 'int'
            ]
        ],
        'groups' => [
            'infoComplementares' => [
                'groups' => [
                    'cargoFuncao' => [
                        'properties' => [
                            'codCargo',
                            'codFuncao'
                        ]
                    ],
                    'remuneracao' => [
                        'properties' => [
                            'vrSalFx' => [
                                'type' => 'float'
                            ],
                            'undSalFixo' => [
                              'type' => 'int'
                            ],
                            'dscSalVar'
                        ]
                    ],
                    'infoEstagiario' => [
                        'properties' => [
                            'natEstagio',
                            'nivEstagio' => [
                                'type' => 'int',
                            ],
                            'areaAtuacao',
                            'nrApol',
                            'vlrBolsa' => [
                                'type' => 'float',
                            ],
                            'dtPrevTerm'
                        ],
                        'groups' => [
                            'instEnsino' => [
                                'properties' => [
                                    'instEnsino_cnpjInstEnsino' => 'cnpjInstEnsino',
                                    'instEnsino_nmRazao' => 'nmRazao',
                                    'instEnsino_dscLograd' => 'dscLograd',
                                    'instEnsino_nrLograd' => 'nrLograd',
                                    'instEnsino_bairro' => 'bairro',
                                    'instEnsino_cep' => 'cep',
                                    'instEnsino_codMunic' => [
                                        'nome_api' => 'codMunic'
                                    ],
                                    'instEnsino_uf' => 'uf',
                                ]
                            ],
                            'ageIntegracao' => [
                                'properties' => [
                                    'ageIntegracao_cnpjAgntInteg' => 'cnpjAgntInteg',
                                    'ageIntegracao_nmRazao' => 'nmRazao',
                                    'ageIntegracao_dscLograd' => 'dscLograd',
                                    'ageIntegracao_nrLograd' => 'nrLograd',
                                    'ageIntegracao_bairro' => 'bairro',
                                    'ageIntegracao_cep' => 'cep',
                                    'ageIntegracao_codMunic' => [
                                        'nome_api' => 'codMunic'
                                    ],
                                    'ageIntegracao_uf' => 'uf',
                                ]
                            ],
                            'supervisorEstagio' => [
                                'properties' => [
                                    'cpfSupervisor',
                                    'nmSuperv'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
