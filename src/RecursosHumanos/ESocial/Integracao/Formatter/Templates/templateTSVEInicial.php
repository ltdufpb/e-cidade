<?php
/* S-2300 - Trabalhador Sem Vínculo de Emprego/Estatutário - Início */
return [
    'trabalhador' => [
        'properties' => [
            'cpfTrab',
            'nisTrab',
            'nmTrab',
            'sexo',
            'racaCor' => [
              'type' => 'int'
            ],
            'estCiv' => [
              'type' => 'int'
            ],
            'grauInstr'
        ],
        'groups' => [
            'nascimento' => [
                'properties' => [
                    'dtNascto',
                    'codMunic',
                    'uf',
                    'paisNascto',
                    'paisNac',
                    'nmMae',
                    'nmPai'
                ]
            ],
            'documentos' => [
                'groups' => [
                    'CTPS' => [
                        'properties' => [
                            'nrCtps',
                            'serieCtps',
                            'ufCtps'
                        ]
                    ],
                    'RIC' => [
                        'properties' => [
                            'nrRic',
                            'orgaoEmissor_Ric' =>'orgaoEmissor',
                            'dtExped_Ric' => 'dtExped'
                        ]
                    ],
                    'RG' => [
                        'properties' => [
                            'nrRg',
                            'orgaoEmissor_RG' => 'orgaoEmissor',
                            'dtExped_RG' => 'dtExped'
                        ]
                    ],
                    'RNE' => [
                        'properties' => [
                            'nrRne',
                            'orgaoEmissor_RNE' => 'orgaoEmissor',
                            'dtExped_RNE' => 'dtExped',
                        ]
                    ],
                    'OC' => [
                        'properties' => [
                            'nrOc',
                            'orgaoEmissor_OC' => 'orgaoEmissor',
                            'dtExped_OC' => 'dtExped',
                            'dtValid_OC' => 'dtValid',
                        ]
                    ],
                    'CNH' => [
                        'properties' => [
                            'nrRegCnh',
                            'dtExped_CNH' =>'dtExped',
                            'ufCnh',
                            'dtValid_CNH' =>'dtValid',
                            'dtPriHab',
                            'categoriaCnh',
                        ]
                    ],
                ],
            ],
            'endereco' => [
                'groups' => [
                    'brasil' => [
                        'properties' => [
                            'tpLograd_brasil' => 'tpLograd',
                            'dscLograd_brasil' => 'dscLograd',
                            'nrLograd_brasil' => 'nrLograd',
                            'complemento_brasil' => 'complemento',
                            'bairro_brasil' => 'bairro',
                            'cep_brasil' => 'cep',
                            'codMunic_brasil' => [
                                'nome_api' => 'codMunic'
                            ],
                            'uf_brasil' => 'uf'
                        ]
                    ],
                    'exterior' => [
                        'properties' => [
                            'paisResid_exterior' => 'paisResid',
                            'dscLograd_exterior' => 'dscLograd',
                            'nrLograd_exterior' => 'nrLograd',
                            'complemento_exterior' => 'complemento',
                            'bairro_exterior' => 'bairro',
                            'nmCid_exterior' => 'nmCid',
                            'codPostal_exterior' => 'codPostal'
                        ]
                    ],
                ],
            ],
            'trabEstrangeiro' => [
                'properties' => [
                    'dtChegada',
                    'classTrabEstrang',
                    'casadoBr',
                    'filhosBr',
                ]
            ],
            'infoDeficiencia' => [
                'properties' => [
                    'defFisica',
                    'defVisual',
                    'defAuditiva',
                    'defMental',
                    'defIntelectual',
                    'reabReadap',
                    'observacao'
                ]
            ],
            'dependente_1' =>  [
                'type' => 'array',
                'nome_api' => 'dependente',
                'items' => [
                    'properties' => [
                        'dependente_1_tpDep' => 'tpDep',
                        'dependente_1_nmDep' => 'nmDep',
                        'dependente_1_dtNascto' => 'dtNascto',
                        'dependente_1_cpfDep' => 'cpfDep',
                        'dependente_1_depIRRF' => 'depIRRF',
                        'dependente_1_depSF' => 'depSF',
                        'dependente_1_incTrab' => 'incTrab'
                    ]
                ]
            ],
            'dependente_2' =>  [
                'type' => 'array',
                'nome_api' => 'dependente',
                'items' => [
                    'properties' => [
                        'dependente_2_tpDep' => 'tpDep',
                        'dependente_2_nmDep' => 'nmDep',
                        'dependente_2_dtNascto' => 'dtNascto',
                        'dependente_2_cpfDep' => 'cpfDep',
                        'dependente_2_depIRRF' => 'depIRRF',
                        'dependente_2_depSF' => 'depSF',
                        'dependente_2_incTrab' => 'incTrab'
                    ]
                ]
            ],
            'dependente_3' =>  [
                'type' => 'array',
                'nome_api' => 'dependente',
                'items' => [
                    'properties' => [
                        'dependente_3_tpDep' => 'tpDep',
                        'dependente_3_nmDep' => 'nmDep',
                        'dependente_3_dtNascto' => 'dtNascto',
                        'dependente_3_cpfDep' => 'cpfDep',
                        'dependente_3_depIRRF' => 'depIRRF',
                        'dependente_3_depSF' => 'depSF',
                        'dependente_3_incTrab' => 'incTrab'
                    ]
                ]
            ],
            'dependente_4' =>  [
                'type' => 'array',
                'nome_api' => 'dependente',
                'items' => [
                    'properties' => [
                        'dependente_4_tpDep' => 'tpDep',
                        'dependente_4_nmDep' => 'nmDep',
                        'dependente_4_dtNascto' => 'dtNascto',
                        'dependente_4_cpfDep' => 'cpfDep',
                        'dependente_4_depIRRF' => 'depIRRF',
                        'dependente_4_depSF' => 'depSF',
                        'dependente_4_incTrab' => 'incTrab'
                    ]
                ]
            ],
            'dependente_5' =>  [
                'type' => 'array',
                'nome_api' => 'dependente',
                'items' => [
                    'properties' => [
                        'dependente_5_tpDep' => 'tpDep',
                        'dependente_5_nmDep' => 'nmDep',
                        'dependente_5_dtNascto' => 'dtNascto',
                        'dependente_5_cpfDep' => 'cpfDep',
                        'dependente_5_depIRRF' => 'depIRRF',
                        'dependente_5_depSF' => 'depSF',
                        'dependente_5_incTrab' => 'incTrab'
                    ]
                ]
            ],
            'dependente_6' =>  [
                'type' => 'array',
                'nome_api' => 'dependente',
                'items' => [
                    'properties' => [
                        'dependente_6_tpDep' => 'tpDep',
                        'dependente_6_nmDep' => 'nmDep',
                        'dependente_6_dtNascto' => 'dtNascto',
                        'dependente_6_cpfDep' => 'cpfDep',
                        'dependente_6_depIRRF' => 'depIRRF',
                        'dependente_6_depSF' => 'depSF',
                        'dependente_6_incTrab' => 'incTrab'
                    ]
                ]
            ],
            'dependente_7' =>  [
                'type' => 'array',
                'nome_api' => 'dependente',
                'items' => [
                    'properties' => [
                        'dependente_7_tpDep' => 'tpDep',
                        'dependente_7_nmDep' => 'nmDep',
                        'dependente_7_dtNascto' => 'dtNascto',
                        'dependente_7_cpfDep' => 'cpfDep',
                        'dependente_7_depIRRF' => 'depIRRF',
                        'dependente_7_depSF' => 'depSF',
                        'dependente_7_incTrab' => 'incTrab'
                    ]
                ]
            ],
            'dependente_8' =>  [
                'type' => 'array',
                'nome_api' => 'dependente',
                'items' => [
                    'properties' => [
                        'dependente_8_tpDep' => 'tpDep',
                        'dependente_8_nmDep' => 'nmDep',
                        'dependente_8_dtNascto' => 'dtNascto',
                        'dependente_8_cpfDep' => 'cpfDep',
                        'dependente_8_depIRRF' => 'depIRRF',
                        'dependente_8_depSF' => 'depSF',
                        'dependente_8_incTrab' => 'incTrab'
                    ]
                ]
            ],
            'dependente_9' =>  [
                'type' => 'array',
                'nome_api' => 'dependente',
                'items' => [
                    'properties' => [
                        'dependente_9_tpDep' => 'tpDep',
                        'dependente_9_nmDep' => 'nmDep',
                        'dependente_9_dtNascto' => 'dtNascto',
                        'dependente_9_cpfDep' => 'cpfDep',
                        'dependente_9_depIRRF' => 'depIRRF',
                        'dependente_9_depSF' => 'depSF',
                        'dependente_9_incTrab' => 'incTrab'
                    ]
                ]
            ],
            'dependente_10' =>  [
                'type' => 'array',
                'nome_api' => 'dependente',
                'items' => [
                    'properties' => [
                        'dependente_10_tpDep' => 'tpDep',
                        'dependente_10_nmDep' => 'nmDep',
                        'dependente_10_dtNascto' => 'dtNascto',
                        'dependente_10_cpfDep' => 'cpfDep',
                        'dependente_10_depIRRF' => 'depIRRF',
                        'dependente_10_depSF' => 'depSF',
                        'dependente_10_incTrab' => 'incTrab'
                    ]
                ]
            ],
            'contato' => [
                'properties' => [
                    'fonePrinc',
                    'foneAlternat',
                    'emailPrinc',
                    'emailAlternat'
                ]
            ]
        ]
    ],
    'infoTSVInicio' => [
        'properties' => [
            'cadIni',
            'codCateg',
            'dtInicio',
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
                    'fgts' => [
                        'properties' => [
                            'opcFGTS' => [
                                'type' => 'int'
                            ],
                            'dtOpcFGTS',
                        ]
                    ],
                    'infoDirigenteSindical' => [
                        'properties' => [
                            'categOrig',
                            'cnpjOrigem',
                            'dtAdmOrig',
                            'matricOrig'
                        ]
                    ],
                    'infoTrabCedido' => [
                        'properties' => [
                            'categOrig',
                            'cnpjCednt',
                            'matricCed',
                            'dtAdmCed',
                            'tpRegTrab' => [
                                'type' => 'int'
                            ],
                            'tpRegPrev' => [
                                'type' => 'int'
                            ],
                            'infOnus' => [
                                'type' => 'int'
                            ]
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
            ],
            'afastamento' => [
                'properties' => [
                    'dtIniAfast',
                    'codMotAfast'
                ]
            ],
            'termino' => [
                'properties' => [
                    'dtTerm'
                ]
            ],
            'mudancaCPF' => [
                'properties' => [
                    'cpfAnt',
                    'dtAltCPF',
                    'mudancaCPF_observacao' => 'observacao'
                ]
            ]
        ]
    ]
];
