<?php
/**
 * Arquivo S - 2205 - Alteração dos Dados do Servidor
 */
return [
    'ideTrabalhador' => [
        'properties' => [
            'cpfTrab'
        ]
    ],
    'alteracao' => [
        'properties' => [
            'dtAlteracao'
        ],
        'groups' => [
            'dadosTrabalhador' => [
                'properties' => [
                    'nisTrab',
                    'nmTrab',
                    'sexo',
                    'racaCor',
                    'estCiv',
                    'grauInstr',
                    'nmSoc'
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
                                    'RIC_nrRic' => 'nrRic',
                                    'RIC_orgaoEmissor' => 'orgaoEmissor',
                                    'RIC_dtExped' => 'dtExped'
                                ]
                            ],
                            'RG' => [
                                'properties' => [
                                    'RG_nrRg' => 'nrRg',
                                    'RG_orgaoEmissor' => 'orgaoEmissor',
                                    'RG_dtExped' => 'dtExped'
                                ]
                            ],
                            'RNE' => [
                                'properties' => [
                                    'RNE_nrRne' => 'nrRne',
                                    'RNE_orgaoEmissor' => 'orgaoEmissor',
                                    'RNE_dtExped' => 'dtExped',
                                ]
                            ],
                            'OC' => [
                                'properties' => [
                                    'OC_nrOc' => 'nrOc',
                                    'OC_orgaoEmissor' => 'orgaoEmissor',
                                    'OC_dtExped' => 'dtExped',
                                    'OC_dtValid' => 'dtValid',
                                ]
                            ],
                            'CNH' => [
                                'properties' => [
                                    'CNH_nrRegCnh' => 'nrRegCnh',
                                    'CNH_dtExped' => 'dtExped',
                                    'CNH_ufCnh' => 'ufCnh',
                                    'CNH_dtValid' => 'dtValid',
                                    'CNH_dtPriHab' => 'dtPriHab',
                                    'CNH_categoriaCnh' => 'categoriaCnh',
                                ]
                            ],
                        ]
                    ],

                    'endereco' => [
                        'label' => 'Endereços',
                        'groups' => [
                            'brasil' => [
                                'properties' => [
                                    'tpLograd',
                                    'dscLograd',
                                    'nrLograd',
                                    'complemento',
                                    'bairro',
                                    'cep',
                                    'brasil_codMunic' => [
                                        'type' => 'int',
                                        'nome_api' => 'codMunic'
                                    ],
                                    'brasil_uf' => 'uf'
                                ]
                            ],
                            'exterior' => [
                                'properties' => [
                                    'paisResid',
                                    'exterior_dscLograd' => 'dscLograd',
                                    'exterior_nrLograd' => 'nrLograd',
                                    'exterior_complemento' => 'complemento',
                                    'exterior_bairro' => 'bairro',
                                    'nmCid',
                                    'codPostal'
                                ]
                            ],
                        ],
                    ],

                    'trabEstrangeiro' => [
                        'properties' => [
                            'dtChegada',
                            'classTrabEstrang' => [
                                'type' => 'int'
                            ],
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
                            'infoCota',
                            'observacao'
                        ]
                    ],

                    'aposentadoria' => [
                        'properties' => [
                            'trabAposent'
                        ]
                    ],
                    'contato' => [
                        'properties' => [
                            'fonePrinc',
                            'foneAlternat',
                            'emailPrinc',
                            'emailAlternat',
                        ]
                    ],

                    'dependente_1' =>  [
                        'type' => 'array',
                        'nome_api' => 'dependente',
                        'label' => 'Dependentes',
                        'items' => [
                            'properties' => [
                                'tpDep_1' => 'tpDep',
                                'nmDep_1' => 'nmDep',
                                'dtNascto_1' => 'dtNascto',
                                'cpfDep_1' => 'cpfDep',
                                'depIRRF_1' => 'depIRRF',
                                'depSF_1' => 'depSF',
                                'incTrab_1' => 'incTrab'
                            ]
                        ]
                    ],

                    'dependente_2' =>  [
                        'type' => 'array',
                        'nome_api' => 'dependente',
                        'items' => [
                            'properties' => [
                                'tpDep_2' => 'tpDep',
                                'nmDep_2' => 'nmDep',
                                'dtNascto_2' => 'dtNascto',
                                'cpfDep_2' => 'cpfDep',
                                'depIRRF_2' => 'depIRRF',
                                'depSF_2' => 'depSF',
                                'incTrab_2' => 'incTrab'
                            ]
                        ]
                    ],
                    'dependente_3' =>  [
                        'type' => 'array',
                        'nome_api' => 'dependente',
                        'items' => [
                            'properties' => [
                                'tpDep_3' => 'tpDep',
                                'nmDep_3' => 'nmDep',
                                'dtNascto_3' => 'dtNascto',
                                'cpfDep_3' => 'cpfDep',
                                'depIRRF_3' => 'depIRRF',
                                'depSF_3' => 'depSF',
                                'incTrab_3' => 'incTrab'
                            ]
                        ]
                    ],
                    'dependente_4' =>  [
                        'type' => 'array',
                        'nome_api' => 'dependente',
                        'items' => [
                            'properties' => [
                                'tpDep_4' => 'tpDep',
                                'nmDep_4' => 'nmDep',
                                'dtNascto_4' => 'dtNascto',
                                'cpfDep_4' => 'cpfDep',
                                'depIRRF_4' => 'depIRRF',
                                'depSF_4' => 'depSF',
                                'incTrab_4' => 'incTrab'
                            ]
                        ]
                    ],
                    'dependente_5' =>  [
                        'type' => 'array',
                        'nome_api' => 'dependente',
                        'items' => [
                            'properties' => [
                                'tpDep_5' => 'tpDep',
                                'nmDep_5' => 'nmDep',
                                'dtNascto_5' => 'dtNascto',
                                'cpfDep_5' => 'cpfDep',
                                'depIRRF_5' => 'depIRRF',
                                'depSF_5' => 'depSF',
                                'incTrab_5' => 'incTrab'
                            ]
                        ]
                    ],
                    'dependente_6' =>  [
                        'type' => 'array',
                        'nome_api' => 'dependente',
                        'items' => [
                            'properties' => [
                                'tpDep_6' => 'tpDep',
                                'nmDep_6' => 'nmDep',
                                'dtNascto_6' => 'dtNascto',
                                'cpfDep_6' => 'cpfDep',
                                'depIRRF_6' => 'depIRRF',
                                'depSF_6' => 'depSF',
                                'incTrab_6' => 'incTrab'
                            ]
                        ]
                    ],
                    'dependente_7' =>  [
                        'type' => 'array',
                        'nome_api' => 'dependente',
                        'items' => [
                            'properties' => [
                                'tpDep_7' => 'tpDep',
                                'nmDep_7' => 'nmDep',
                                'dtNascto_7' => 'dtNascto',
                                'cpfDep_7' => 'cpfDep',
                                'depIRRF_7' => 'depIRRF',
                                'depSF_7' => 'depSF',
                                'incTrab_7' => 'incTrab'
                            ]
                        ]
                    ],
                    'dependente_8' =>  [
                        'type' => 'array',
                        'nome_api' => 'dependente',
                        'items' => [
                            'properties' => [
                                'tpDep_8' => 'tpDep',
                                'nmDep_8' => 'nmDep',
                                'dtNascto_8' => 'dtNascto',
                                'cpfDep_8' => 'cpfDep',
                                'depIRRF_8' => 'depIRRF',
                                'depSF_8' => 'depSF',
                                'incTrab_8' => 'incTrab'
                            ]
                        ]
                    ],
                    'dependente_9' =>  [
                        'type' => 'array',
                        'nome_api' => 'dependente',
                        'items' => [
                            'properties' => [
                                'tpDep_9' => 'tpDep',
                                'nmDep_9' => 'nmDep',
                                'dtNascto_9' => 'dtNascto',
                                'cpfDep_9' => 'cpfDep',
                                'depIRRF_9' => 'depIRRF',
                                'depSF_9' => 'depSF',
                                'incTrab_9' => 'incTrab'
                            ]
                        ]
                    ],
                    'dependente_10' =>  [
                        'type' => 'array',
                        'nome_api' => 'dependente',
                        'items' => [
                            'properties' => [
                                'tpDep_10' => 'tpDep',
                                'nmDep_10' => 'nmDep',
                                'dtNascto_10' => 'dtNascto',
                                'cpfDep_10' => 'cpfDep',
                                'depIRRF_10' => 'depIRRF',
                                'depSF_10' => 'depSF',
                                'incTrab_10' => 'incTrab'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

