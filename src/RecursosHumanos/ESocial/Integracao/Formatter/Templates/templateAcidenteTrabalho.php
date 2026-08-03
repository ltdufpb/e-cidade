<?php
return [
    'ideVinculo' => [
        'required' => true,
        'properties' => [
            'cpfTrab' => [
                'required' => true,
                'label' => 'Código pessoa física do trabalhador',
                'type' => 'string',
            ],
            'matricula' => [
                'required' => false,
                'label' => 'Matrícula atribuída ao trabalhador',
                'type' => 'string',
            ],
            'codCateg' => [
                'required' => false,
                'label' => 'Categoria do trabalhador',
                'type' => 'int'
            ],
        ]
    ],
    'cat' => [
        'required' => true,
        'label' => 'Comunicação de Acidente de Trabalho - CAT.',
        'properties' => [
            'dtAcid' => [
                'required' => true,
                'label' => 'Data do acidente.',
                'type' => 'string',
            ],
            'tpAcid' => [
                'required' => true,
                'label' => 'Tipo de acidente de trabalho.',
                'type' => 'int',
            ],
            'hrAcid' => [
                'required' => false,
                'label' => 'Hora do acidente, no formato HHMM.',
                'type' => 'string'
            ],
            'hrsTrabAntesAcid' => [
                'required' => false,
                'label' => 'Horas trabalhadas antes da ocorrência do acidente, no formato HHMM.',
                'type' => 'string'
            ],
            'tpCat' => [
                'required' => true,
                'label' => 'Tipo de CAT',
                'type' => 'int'
            ],
            'indCatObito' => [
                'required' => true,
                'label' => 'Houve óbito?',
                'type' => 'string'
            ],
            'dtObito' => [
                'required' => false,
                'label' => 'Data do óbito.',
                'type' => 'string'
            ],
            'indComunPolicia' => [
                'required' => true,
                'label' => 'Houve comunicação à autoridade policial?',
                'type' => 'string'
            ],
            'codSitGeradora' => [
                'required' => true,
                'label' => 'Código da situação geradora do acidente ou da doença profissional.',
                'type' => 'int'
            ],
            'iniciatCAT' => [
                'required' => true,
                'label' => 'Iniciativa da CAT.',
                'type' => 'int'
            ],
            'obsCAT' => [
                'required' => false,
                'label' => 'Observação.',
                'type' => 'string'
            ]
        ],
        'groups' => [
            'localAcidente' => [
                'required' => true,
                'label' => 'Local do acidente.',
                'properties' => [
                    'tpLocal' => [
                        'required' => true,
                        'label' => 'Tipo de local do acidente.',
                        'type' => 'int'
                    ],
                    'dscLocal' => [
                        'required' => false,
                        'label' => 'Especificação do local do acidente (pátio, rampa de acesso, etc.).',
                        'type' => 'string'
                    ],
                    'tpLograd' => [
                        'required' => false,
                        'label' => 'Tipo de logradouro.',
                        'type' => 'string'
                    ],
                    'dscLograd' => [
                        'required' => true,
                        'label' => 'Descrição do logradouro.',
                        'type' => 'string'
                    ],
                    'nrLograd' => [
                        'required' => true,
                        'label' => 'Número do logradouro.',
                        'type' => 'string'
                    ],
                    'complemento' => [
                        'required' => false,
                        'label' => 'Complemento do logradouro.',
                        'type' => 'string'
                    ],
                    'bairro' => [
                        'required' => false,
                        'label' => 'Nome do bairro/distrito.',
                        'type' => 'string'
                    ],
                    'cep' => [
                        'required' => false,
                        'label' => 'Código de Endereçamento Postal - CEP.',
                        'type' => 'string'
                    ],
                    'codMunic' => [
                        'required' => false,
                        'label' => 'código do município, conforme tabela do IBGE.',
                        'type' => 'int'
                    ],
                    'uf' => [
                        'required' => false,
                        'label' => 'Sigla da Unidade da Federação - UF.',
                        'type' => 'string'
                    ],
                    'pais' => [
                        'required' => false,
                        'label' => 'Preencher com o código do país.',
                        'type' => 'string'
                    ],
                    'codPostal' => [
                        'required' => false,
                        'label' => 'Código de Endereçamento Postal.',
                        'type' => 'string'
                    ]
                ],
                'groups' => [
                    'ideLocalAcid' => [
                        'required' => false,
                        'label' => 'Identificação do local onde ocorreu o acidente.',
                        'properties' => [
                            'tpInsc' => [
                                'required' => true,
                                'label' => 'Código correspondente ao tipo de inscrição do local.',
                                'type' => 'int'
                            ],
                            'nrInsc' => [
                                'required' => true,
                                'label' => 'Informar o número de inscrição do estabelecimento.',
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ],
            'parteAtingida' => [
                'required' => true,
                'label' => 'Detalhamento da parte atingida pelo acidente de trabalho.',
                'properties' => [
                    'codParteAting' => [
                        'required' => true,
                        'label' => 'Preencher com o código correspondente à parte atingida.',
                        'type' => 'int'
                    ],
                    'lateralidade' => [
                        'required' => true,
                        'label' => 'PLateralidade da(s) parte(s) atingida(s).',
                        'type' => 'int'
                    ]
                ]
            ],
            'agenteCausador' => [
                'required' => true,
                'label' => 'Detalhamento do agente causador do acidente de trabalho.',
                'properties' => [
                    'codAgntCausador' => [
                        'required' => true,
                        'label' => 'Preencher com o código correspondente ao agente causador do acidente.',
                        'type' => 'int'
                    ]
                ]
            ],
            'atestado' => [
                'required' => true,
                'label' => 'Atestado médico.',
                'properties' => [
                    'dtAtendimento' => [
                        'required' => true,
                        'label' => 'Data do atendimento.',
                        'type' => 'string'
                    ],
                    'hrAtendimento' => [
                        'required' => true,
                        'label' => 'Hora do atendimento, no formato HHMM.',
                        'type' => 'string'
                    ],
                    'indInternacao' => [
                        'required' => true,
                        'label' => 'Indicativo de internação.',
                        'type' => 'string'
                    ],
                    'durTrat' => [
                        'required' => true,
                        'label' => 'Duração estimada do tratamento, em dias.',
                        'type' => 'int'
                    ],
                    'indAfast' => [
                        'required' => true,
                        'label' => 'Indicativo de afastamento do trabalho durante o tratamento.',
                        'type' => 'string'
                    ],
                    'dscLesao' => [
                        'required' => true,
                        'label' => 'Preencher com a descrição da natureza da lesão.',
                        'type' => 'int'
                    ],
                    'dscCompLesao' => [
                        'required' => false,
                        'label' => 'Descrição complementar da lesão.',
                        'type' => 'string'
                    ],
                    'diagProvavel' => [
                        'required' => false,
                        'label' => 'Diagnóstico provável.',
                        'type' => 'string'
                    ],
                    'codCID' => [
                        'required' => true,
                        'label' => 'Classificação Internacional de Doenças - CID.',
                        'type' => 'string'
                    ],
                    'observacao' => [
                        'required' => false,
                        'label' => 'Observação.',
                        'type' => 'string'
                    ]
                ],
                'groups' => [
                    'emitente' => [
                        'required' => true,
                        'label' => 'Médico/Dentista que emitiu o atestado.',
                        'properties' => [
                            'nmEmit' => [
                                'required' => true,
                                'label' => 'Nome do médico/dentista que emitiu o atestado.',
                                'type' => 'string'
                            ],
                            'ideOC' => [
                                'required' => true,
                                'label' => 'Órgão de classe.',
                                'type' => 'int'
                            ],
                            'nrOC' => [
                                'required' => true,
                                'label' => 'Número de inscrição no órgão de classe.',
                                'type' => 'string'
                            ],
                            'ufOC' => [
                                'required' => true,
                                'label' => 'Sigla da UF do órgão de classe.',
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ],
            'catOrigem' => [
                'required' => false,
                'label' => 'Grupo que indica a CAT anterior, caso de CAT de reabertura ou de comunicação de óbito.',
                'properties' => [
                    'nrRecCatOrig' => [
                        'required' => true,
                        'label' => 'Informar o número do recibo da última CAT',
                        'type' => 'string'
                    ]
                ]
            ]
        ]
    ]
];
