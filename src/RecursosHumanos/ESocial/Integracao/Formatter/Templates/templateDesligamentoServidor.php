<?php
/**
 * S-2299
 * Desligamento do Servidor
 */
return [
    'ideVinculo' => [
        'properties' => [
            'cpfTrab',
            'nisTrab',
            'matricula'
        ]
    ],
    'infoDeslig' => [
        'properties' => [
            'mtvDeslig',
            'dtDeslig',
            'indPagtoAPI',
            'dtProjFimAPI',
            'pensAlim',
            'percAliment',
            'vrAlim',
            'nrCertObito',
            'nrProcTrab',
            'indCumprParc',
            'qtdDiasInterm'
        ],
        'groups' => [
            'observacoes' => [
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'observacao'
                    ]
                ]
            ],
            'sucessaoVinc' => [
                'properties' => [
                    'tpInscSuc',
                    'cnpjSucessora'
                ]
            ],
            'transfTit' => [
                'properties' => [
                    'cpfSubstituto',
                    'dtNascto_transfTit' => 'dtNascto'
                ]
            ],
            'mudancaCPF' => [
                'properties' => [
                    'novoCPF'
                ]
            ],
            'verbasResc' => [
                'groups' => [
                    'dmDev' => [
                        'groups' => [
                            'infoPerApur' => [
                                'groups' => [
                                    'ideEstabLot' => [
                                        'properties' => [
                                            'infoPerApur_tpInsc' => 'tpInsc',
                                            'infoPerApur_nrInsc' => 'nrInsc',
                                            'infoPerApur_codLotacao' => 'codLotacao',
                                        ],
                                        'groups' => [
                                            'detVerbas' => [
                                                'properties' => [
                                                    'detVerbas_codRubr'    => 'codRubr',
                                                    'detVerbas_ideTabRubr' => 'ideTabRubr',
                                                    'detVerbas_qtdRubr'    => 'qtdRubr',
                                                    'detVerbas_fatorRubr'  => 'fatorRubr',
                                                    'detVerbas_vrUnit'     => 'vrUnit',
                                                    'detVerbas_vrRubr'     => 'vrRubr',
                                                ]
                                            ],
                                            'infoSaudeColet' => [
                                                'groups' => [
                                                    'detOper' => [
                                                        'properties' => [
                                                            'detOper_1_cnpjOper',
                                                            'detOper_1_regANS'  ,
                                                            'detOper_1_vrPgTit' ,
                                                            'detOper_2_cnpjOper',
                                                            'detOper_2_regANS'  ,
                                                            'detOper_2_vrPgTit' ,
                                                        ],
                                                        'groups' => [
                                                            'dependente_1' => [
                                                                'type' => 'array',
                                                                'nome_api' => 'detPlano',
                                                                'items' => [
                                                                    'properties' => [
                                                                        'detPlano1_tpDep'    => 'tpDep',
                                                                        'detPlano1_cpfDep'   => 'cpfDep',
                                                                        'detPlano1_nmDep'    => 'nmDep',
                                                                        'detPlano1_dtNascto' => 'dtNascto',
                                                                        'detPlano1_vlrPgDep_operadora1',
                                                                        'detPlano1_vlrPgDep_operadora2',
                                                                        'detPlano1_cnpj_operadora1',
                                                                        'detPlano1_cnpj_operadora2',
                                                                    ]
                                                                ]
                                                            ],
                                                            'dependente_2' => [
                                                                'type' => 'array',
                                                                'nome_api' => 'detPlano',
                                                                'items' => [
                                                                    'properties' => [
                                                                        'detPlano2_tpDep'    => 'tpDep',
                                                                        'detPlano2_cpfDep'   => 'cpfDep',
                                                                        'detPlano2_nmDep'    => 'nmDep',
                                                                        'detPlano2_dtNascto' => 'dtNascto',
                                                                        'detPlano2_vlrPgDep_operadora1',
                                                                        'detPlano2_vlrPgDep_operadora2',
                                                                        'detPlano2_cnpj_operadora1',
                                                                        'detPlano2_cnpj_operadora2',
                                                                    ]
                                                                ]
                                                            ],
                                                            'dependente_3' => [
                                                                'type' => 'array',
                                                                'nome_api' => 'detPlano',
                                                                'items' => [
                                                                    'properties' => [
                                                                        'detPlano3_tpDep'    => 'tpDep',
                                                                        'detPlano3_cpfDep'   => 'cpfDep',
                                                                        'detPlano3_nmDep'    => 'nmDep',
                                                                        'detPlano3_dtNascto' => 'dtNascto',
                                                                        'detPlano3_vlrPgDep_operadora1',
                                                                        'detPlano3_vlrPgDep_operadora2',
                                                                        'detPlano3_cnpj_operadora1',
                                                                        'detPlano3_cnpj_operadora2',
                                                                    ]
                                                                ]
                                                            ],
                                                            'dependente_4' => [
                                                                'type' => 'array',
                                                                'nome_api' => 'detPlano',
                                                                'items' => [
                                                                    'properties' => [
                                                                        'detPlano4_tpDep'    => 'tpDep',
                                                                        'detPlano4_cpfDep'   => 'cpfDep',
                                                                        'detPlano4_nmDep'    => 'nmDep',
                                                                        'detPlano4_dtNascto' => 'dtNascto',
                                                                        'detPlano4_vlrPgDep_operadora1',
                                                                        'detPlano4_vlrPgDep_operadora2',
                                                                        'detPlano4_cnpj_operadora1',
                                                                        'detPlano4_cnpj_operadora2',
                                                                    ]
                                                                ]
                                                            ],
                                                            'dependente_5' => [
                                                                'type' => 'array',
                                                                'nome_api' => 'detPlano',
                                                                'items' => [
                                                                    'properties' => [
                                                                        'detPlano5_tpDep'    => 'tpDep',
                                                                        'detPlano5_cpfDep'   => 'cpfDep',
                                                                        'detPlano5_nmDep'    => 'nmDep',
                                                                        'detPlano5_dtNascto' => 'dtNascto',
                                                                        'detPlano5_vlrPgDep_operadora1',
                                                                        'detPlano5_vlrPgDep_operadora2',
                                                                        'detPlano5_cnpj_operadora1',
                                                                        'detPlano5_cnpj_operadora2',
                                                                    ]
                                                                ]
                                                            ],
                                                            'dependente_6' => [
                                                                'type' => 'array',
                                                                'nome_api' => 'detPlano',
                                                                'items' => [
                                                                    'properties' => [
                                                                        'detPlano6_tpDep'    => 'tpDep',
                                                                        'detPlano6_cpfDep'   => 'cpfDep',
                                                                        'detPlano6_nmDep'    => 'nmDep',
                                                                        'detPlano6_dtNascto' => 'dtNascto',
                                                                        'detPlano6_vlrPgDep_operadora1',
                                                                        'detPlano6_vlrPgDep_operadora2',
                                                                        'detPlano6_cnpj_operadora1',
                                                                        'detPlano6_cnpj_operadora2',
                                                                    ]
                                                                ]
                                                            ],
                                                            'dependente_7' => [
                                                                'type' => 'array',
                                                                'nome_api' => 'detPlano',
                                                                'items' => [
                                                                    'properties' => [
                                                                        'detPlano7_tpDep'    => 'tpDep',
                                                                        'detPlano7_cpfDep'   => 'cpfDep',
                                                                        'detPlano7_nmDep'    => 'nmDep',
                                                                        'detPlano7_dtNascto' => 'dtNascto',
                                                                        'detPlano7_vlrPgDep_operadora1',
                                                                        'detPlano7_vlrPgDep_operadora2',
                                                                        'detPlano7_cnpj_operadora1',
                                                                        'detPlano7_cnpj_operadora2',
                                                                    ]
                                                                ]
                                                            ],
                                                            'dependente_8' => [
                                                                'type' => 'array',
                                                                'nome_api' => 'detPlano',
                                                                'items' => [
                                                                    'properties' => [
                                                                        'detPlano8_tpDep'    => 'tpDep',
                                                                        'detPlano8_cpfDep'   => 'cpfDep',
                                                                        'detPlano8_nmDep'    => 'nmDep',
                                                                        'detPlano8_dtNascto' => 'dtNascto',
                                                                        'detPlano8_vlrPgDep_operadora1',
                                                                        'detPlano8_vlrPgDep_operadora2',
                                                                        'detPlano8_cnpj_operadora1',
                                                                        'detPlano8_cnpj_operadora2',
                                                                    ]
                                                                ]
                                                            ],
                                                            'dependente_9' => [
                                                                'type' => 'array',
                                                                'nome_api' => 'detPlano',
                                                                'items' => [
                                                                    'properties' => [
                                                                        'detPlano9_tpDep'    => 'tpDep',
                                                                        'detPlano9_cpfDep'   => 'cpfDep',
                                                                        'detPlano9_nmDep'    => 'nmDep',
                                                                        'detPlano9_dtNascto' => 'dtNascto',
                                                                        'detPlano9_vlrPgDep_operadora1',
                                                                        'detPlano9_vlrPgDep_operadora2',
                                                                        'detPlano9_cnpj_operadora1',
                                                                        'detPlano9_cnpj_operadora2',
                                                                    ]
                                                                ]
                                                            ],
                                                            'dependente_10' => [
                                                                'type' => 'array',
                                                                'nome_api' => 'detPlano',
                                                                'items' => [
                                                                    'properties' => [
                                                                        'detPlano10_tpDep'    => 'tpDep',
                                                                        'detPlano10_cpfDep'   => 'cpfDep',
                                                                        'detPlano10_nmDep'    => 'nmDep',
                                                                        'detPlano10_dtNascto' => 'dtNascto',
                                                                        'detPlano10_vlrPgDep_operadora1',
                                                                        'detPlano10_vlrPgDep_operadora2',
                                                                        'detPlano10_cnpj_operadora1',
                                                                        'detPlano10_cnpj_operadora2',
                                                                    ]
                                                                ]
                                                            ]
                                                        ]
                                                    ]
                                                ]
                                            ],
                                            'infoPerApur_infoAgNocivo' => [
                                                'nome_api' => 'infoAgNocivo',
                                                'properties' => [
                                                    'infoPerApur_grauExp' => 'grauExp',
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'infoPerAnt' => [
                                'groups' => [
                                    'ideADC' => [
                                        'properties' => [
                                            'dtAcConv',
                                            'tpAcConv',
                                            'compAcConv',
                                            'dtEfAcConv',
                                            'dsc',
                                        ],
                                        'groups' => [
                                            'idePeriodo' => [
                                                'properties' => [
                                                    'perRef'
                                                ],
                                                'groups' => [
                                                    'ideEstabLot' => [
                                                        'properties' => [
                                                            'infoPerAnt_tpInsc' => 'tpInsc',
                                                            'infoPerAnt_nrInsc' => 'nrInsc',
                                                            'infoPerAnt_codLotacao' => 'codLotacao',
                                                        ],
                                                        'groups' => [
                                                            'detVerbas' => [
                                                                'properties' => [
                                                                    'detVerbas_codRubr'    => 'codRubr',
                                                                    'detVerbas_ideTabRubr' => 'ideTabRubr',
                                                                    'detVerbas_qtdRubr'    => 'qtdRubr',
                                                                    'detVerbas_fatorRubr'  => 'fatorRubr',
                                                                    'detVerbas_vrUnit'     => 'vrUnit',
                                                                    'detVerbas_vrRubr'     => 'vrRubr',
                                                                ]
                                                            ],
                                                            'infoPerAnt_infoAgNocivo' => [
                                                                'nome_api' => 'infoAgNocivo',
                                                                'properties' => [
                                                                    'infoPerAnt_grauExp' => 'grauExp'
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
                            'infoTrabInterm' => [
                                'properties' => [
                                    'codConv'
                                ]
                            ],
                        ]
                    ],
                    'procJudTrab' => [
                        'properties' => [
                            'tpTrib',
                            'procJudTrab_nrProcJud' => 'nrProcJud',
                            'codSusp',
                        ],
                    ],
                    'infoMV' => [
                        'properties' => [
                            'indMV',
                        ],
                        'groups' => [
                            'remunOutrEmpr' => [
                                'properties' => [
                                    'remunOutrEmpr_tpInsc' => 'tpInsc',
                                    'remunOutrEmpr_nrInsc' => 'nrInsc',
                                    'codCateg',
                                    'vlrRemunOE',
                                ]
                            ]
                        ]
                    ],
                    'procCS' => [
                        'properties' => [
                           'procCS_nrProcJud' => 'nrProcJud'
                        ]
                    ]
                ]
            ],
            'quarentena' => [
                'properties' => [
                    'dtFimQuar'
                ]
            ],
            'consigFGTS' => [
                'properties' => [
                    'insConsig',
                    'nrContr'
                ]
            ]
        ]
    ],
    'desligamento_rubricas' => [
        'properties' => [
            'desligamento_rubricas_json'
        ]
    ]
];
