<?php
return [
    'ideVinculo' => [
        'properties' => [
            'cpfTrab',
            'nisTrab',
            'matricula'
        ]
    ],
    'altContratual' => [
        'properties' => [
            'dtAlteracao',
            'dtEf',
            'dscAlt'
        ],
        'groups' => [
            'vinculo' => [
                'properties' => [
                    'tpRegPrev' => [
                        'type' => 'integer',
                    ]
                ]
            ],
            'infoRegimeTrab' => [
                'groups' => [
                    'infoCeletista' => [
                        'properties' => [
                            'tpRegJor' => [
                                'type' => 'integer',
                            ],
                            'natAtividade' => [
                                'type' => 'integer',
                            ],
                            'dtBase' => [
                                'type' => 'integer',
                            ],
                            'cnpjSindCategProf'
                        ],
                        'groups' => [
                            'trabTemp' => [

                                'properties' => [
                                    'justProrr'
                                ]
                            ],
                            'aprend' => [
                                'properties' => [
                                    'aprend_tpInsc' => [
                                        'nome_api' => 'tpInsc',
                                        'type' => 'integer',
                                    ],
                                    'aprend_nrInsc' => 'nrInsc'
                                ]
                            ]
                        ]
                    ],
                    'infoEstatutario' => [
                        'properties' => [
                            'tpPlanRP' => [
                                'type' => 'integer',
                            ]
                        ]
                    ]
                ]
            ],
            'infoContrato' => [
                'properties' => [
                    'codCargo',
                    'codFuncao',
                    'codCateg' => [
                        'type' => 'integer',
                    ],
                    'codCarreira',
                    'dtIngrCarr'
                ],
                'groups' => [
                    'remuneracao' => [
                        'properties' => [
                            'vrSalFx' => [
                                'type' => 'float'
                            ],
                            'undSalFixo' => [
                                'type' => 'integer',
                            ],
                            'dscSalVar'
                        ]
                    ],
                    'duracao' => [
                        'properties' => [
                            'tpContr' => [
                                'type' => 'integer',
                            ],
                            'dtTerm',
                            'objDet'
                        ]
                    ],
                    'localTrabalho' => [
                        'groups' => [
                            'localTrabGeral' => [
                                'properties' => [
                                    'localTrabGeral_tpInsc' => [
                                        'nome_api' => 'tpInsc',
                                        'type' => 'integer',
                                    ],
                                    'localTrabGeral_nrInsc' => 'nrInsc',
                                    'localTrabGeral_descComp' => 'descComp'
                                ]
                            ],
                            'localTrabDom' => [
                                'properties' => [
                                    'localTrabDom_tpLograd' => 'tpLograd',
                                    'localTrabDom_dscLograd' => 'dscLograd',
                                    'localTrabDom_nrLograd' => 'nrLograd',
                                    'localTrabDom_complemento' => 'complemento',
                                    'localTrabDom_bairro' => 'bairro',
                                    'localTrabDom_cep' => 'cep',
                                    'localTrabDom_codMunic' => [
                                        'nome_api' => 'codMunic',
                                        'type' => 'integer',
                                    ],
                                    'localTrabDom_uf' => 'uf'
                                ]
                            ]
                        ]
                    ],
                    'horContratual' => [
                        'properties' => [
                            'qtdHrsSem' => [
                                'type' => 'float'
                            ],
                            'tpJornada' => [
                                'type' => 'integer',
                            ],
                            'dscTpJorn',
                            'tmpParc' => [
                                'type' => 'integer',
                            ]
                        ],
                        'groups' => [
                            'horario_semana_1' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'items' => [
                                    'properties' => [
                                        'horario_semana_1_codHorContrat_8' => 'codHorContrat_8',
                                        'horario_semana_1_codHorContrat_7' => 'codHorContrat_7',
                                        'horario_semana_1_codHorContrat_6' => 'codHorContrat_6',
                                        'horario_semana_1_codHorContrat_5' => 'codHorContrat_5',
                                        'horario_semana_1_codHorContrat_4' => 'codHorContrat_4',
                                        'horario_semana_1_codHorContrat_3' => 'codHorContrat_3',
                                        'horario_semana_1_codHorContrat_2' => 'codHorContrat_2',
                                        'horario_semana_1_codHorContrat_1' => 'codHorContrat_1'
                                    ]
                                ]
                            ],
                            'horario_semana_2' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'items' => [
                                    'properties' => [
                                        'horario_semana_2_codHorContrat_8' => 'codHorContrat_8',
                                        'horario_semana_2_codHorContrat_7' => 'codHorContrat_7',
                                        'horario_semana_2_codHorContrat_6' => 'codHorContrat_6',
                                        'horario_semana_2_codHorContrat_5' => 'codHorContrat_5',
                                        'horario_semana_2_codHorContrat_4' => 'codHorContrat_4',
                                        'horario_semana_2_codHorContrat_3' => 'codHorContrat_3',
                                        'horario_semana_2_codHorContrat_2' => 'codHorContrat_2',
                                        'horario_semana_2_codHorContrat_1' => 'codHorContrat_1'
                                    ]
                                ]
                            ],
                            'horario_semana_3' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'items' => [
                                    'properties' => [
                                        'horario_semana_3_codHorContrat_8' => 'codHorContrat_8',
                                        'horario_semana_3_codHorContrat_7' => 'codHorContrat_7',
                                        'horario_semana_3_codHorContrat_6' => 'codHorContrat_6',
                                        'horario_semana_3_codHorContrat_5' => 'codHorContrat_5',
                                        'horario_semana_3_codHorContrat_4' => 'codHorContrat_4',
                                        'horario_semana_3_codHorContrat_3' => 'codHorContrat_3',
                                        'horario_semana_3_codHorContrat_2' => 'codHorContrat_2',
                                        'horario_semana_3_codHorContrat_1' => 'codHorContrat_1'
                                    ]
                                ]
                            ],
                            'horario_semana_4' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'items' => [
                                    'properties' => [
                                        'horario_semana_4_codHorContrat_8' => 'codHorContrat_8',
                                        'horario_semana_4_codHorContrat_7' => 'codHorContrat_7',
                                        'horario_semana_4_codHorContrat_6' => 'codHorContrat_6',
                                        'horario_semana_4_codHorContrat_5' => 'codHorContrat_5',
                                        'horario_semana_4_codHorContrat_4' => 'codHorContrat_4',
                                        'horario_semana_4_codHorContrat_3' => 'codHorContrat_3',
                                        'horario_semana_4_codHorContrat_2' => 'codHorContrat_2',
                                        'horario_semana_4_codHorContrat_1' => 'codHorContrat_1'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'filiacaoSindical_1' => [
                        'type' => 'array',
                        'nome_api' => 'filiacaoSindical',
                        'items' => [
                            'properties' => [
                                'filiacaoSindical_1_cnpjSindTrab' => 'cnpjSindTrab'
                            ]
                        ]
                    ],
                    'filiacaoSindical_2' => [
                        'type' => 'array',
                        'nome_api' => 'filiacaoSindical',
                        'items' => [
                            'properties' => [
                                'filiacaoSindical_2_cnpjSindTrab' => 'cnpjSindTrab'
                            ]
                        ]
                    ],
                    'alvaraJudicial' => [
                        'properties' => [
                            'nrProcJud'
                        ]
                    ],
                    'observacoes' => [
                        'type' => 'array',
                        'nome_api' => 'observacoes',
                        'items' => [
                            'properties' => [
                                'observacao'
                            ]
                        ]
                    ],
                    'servPubl' => [
                        'properties' => [
                            'mtvAlter' => [
                                'type' => 'integer',
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
