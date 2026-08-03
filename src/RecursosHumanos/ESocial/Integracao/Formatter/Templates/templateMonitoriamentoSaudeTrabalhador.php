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
    'exMedOcup' => [
        'required' => true,
        'label' => 'Informações do exame médico ocupacional.',
        'properties' => [
            'tpExameOcup' => [
                'required' => true,
                'label' => 'Tipo do exame médico ocupacional.',
                'type' => 'int',
            ]
        ],
        'groups' => [
            'aso' => [
                'required' => true,
                'label' => 'Detalhamento das informações do Atestado de Saúde Ocupacional - ASO.',
                'properties' => [
                    'dtAso' => [
                        'required' => true,
                        'label' => 'Data de emissão do ASO.',
                        'type' => 'string'
                    ],
                    'resAso' => [
                        'required' => false,
                        'label' => 'Resultado do ASO.',
                        'type' => 'int'
                    ]
                ],
                'groups' => [
                    'exame' => [
                        'required' => true,
                        'label' => 'Grupo que detalha as avaliações clínicas e os exames complementares porventura 
                            realizados pelo trabalhador. ',
                        'properties' => [
                            'dtExm' => [
                                'required' => true,
                                'label' => 'Data do exame realizado.',
                                'type' => 'string'
                            ],
                            'procRealizado' => [
                                'required' => true,
                                'label' => 'Código do procedimento diagnóstico.',
                                'type' => 'int'
                            ],
                            'obsProc' => [
                                'required' => false,
                                'label' => 'Observação sobre o procedimento diagnóstico realizado.',
                                'type' => 'string'
                            ],
                            'ordExame' => [
                                'required' => false,
                                'label' => 'Ordem do exame.',
                                'type' => 'int'
                            ],
                            'indResult' => [
                                'required' => false,
                                'label' => 'Indicação dos resultados.',
                                'type' => 'int'
                            ]
                        ]
                    ],
                    'medico' => [
                        'required' => true,
                        'label' => 'Informações sobre o médico emitente do ASO.',
                        'properties' => [
                            'nmMed' => [
                                'required' => true,
                                'label' => 'Preencher com o nome do médico emitente do ASO.',
                                'type' => 'string'
                            ],
                            'nrCRM' => [
                                'required' => true,
                                'label' => 'Número de inscrição do médico emitente do ASO no Conselho Regional de 
                                    Medicina - CRM.',
                                'type' => 'string'
                            ],
                            'ufCRM' => [
                                'required' => true,
                                'label' => 'Preencher com a sigla da Unidade da Federação - UF de expedição do CRM.',
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ],
            'respMonit' => [
                'required' => false,
                'label' => 'Informações sobre o médico responsável/coordenador do PCMSO.',
                'properties' => [
                    'cpfResp' => [
                        'required' => false,
                        'label' => 'Preencher com o CPF do médico responsável/coordenador do PCMSO.',
                        'type' => 'string'
                    ],
                    'nmResp' => [
                        'required' => true,
                        'label' => 'Preencher com o nome do médico responsável/coordenador do PCMSO.',
                        'type' => 'string'
                    ],
                    'nrCRM' => [
                        'required' => true,
                        'label' => 'Número de inscrição do médico responsável/coordenador do PCMSO no CRM.',
                        'type' => 'string'
                    ],
                    'ufCRM' => [
                        'required' => true,
                        'label' => 'Preencher com a sigla da UF de expedição do CRM..',
                        'type' => 'string'
                    ]

                ]
            ]
        ]
    ]
];
