<?php
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
            'grauInstr',
            'indPriEmpr',
            'nmSoc',
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
                            'orgaoEmissor',
                            'dtExped'
                        ]
                    ],
                    'RG' => [
                        'properties' => [
                            'nrRg',
                            'orgaoEmissor',
                            'dtExped'
                        ]
                    ],
                    'RNE' => [
                        'properties' => [
                            'nrRne',
                            'orgaoEmissor',
                            'dtExped',
                        ]
                    ],
                    'OC' => [
                        'properties' => [
                            'nrOc',
                            'orgaoEmissor',
                            'dtExped',
                            'dtValid',
                        ]
                    ],
                    'CNH' => [
                        'properties' => [
                            'nrRegCnh',
                            'dtExped',
                            'ufCnh',
                            'dtValid',
                            'dtPriHab',
                            'categoriaCnh',
                        ]
                    ],
                ],
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
                            'codMunic' => [
                                'type' => 'int'
                            ],
                            'uf'
                        ]
                    ],
                    'exterior' => [
                        'properties' => [
                            'paisResid',
                            'dscLograd',
                            'nrLograd',
                            'complemento',
                            'bairro',
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
            'dependente_1' => [
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
                        'incTrab_1' => 'incTrab',
                        'depFinsPrev_1' => 'depFinsPrev'
                    ]
                ]
            ],
            'dependente_2' => [
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
                        'incTrab_2' => 'incTrab',
                        'depFinsPrev_2' => 'depFinsPrev'
                    ]
                ]
            ],
            'dependente_3' => [
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
                        'incTrab_3' => 'incTrab',
                        'depFinsPrev_3' => 'depFinsPrev'
                    ]
                ]
            ],
            'dependente_4' => [
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
                        'incTrab_4' => 'incTrab',
                        'depFinsPrev_4' => 'depFinsPrev'
                    ]
                ]
            ],
            'dependente_5' => [
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
                        'incTrab_5' => 'incTrab',
                        'depFinsPrev_5' => 'depFinsPrev'
                    ]
                ]
            ],
            'dependente_6' => [
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
                        'incTrab_6' => 'incTrab',
                        'depFinsPrev_6' => 'depFinsPrev'
                    ]
                ]
            ],
            'dependente_7' => [
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
                        'incTrab_7' => 'incTrab',
                        'depFinsPrev_7' => 'depFinsPrev'
                    ]
                ]
            ],
            'dependente_8' => [
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
                        'incTrab_8' => 'incTrab',
                        'depFinsPrev_8' => 'depFinsPrev'
                    ]
                ]
            ],
            'dependente_9' => [
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
                        'incTrab_9' => 'incTrab',
                        'depFinsPrev_9' => 'depFinsPrev'
                    ]
                ]
            ],
            'dependente_10' => [
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
                        'incTrab_10' => 'incTrab',
                        'depFinsPrev_10' => 'depFinsPrev'
                    ]
                ]
            ]
        ]
    ],
    'vinculo' => [
        'properties' => [
            'matricula',
            'tpRegTrab' => [
                'type' => 'int'
            ],
            'tpRegPrev' => [
                'type' => 'int'
            ],
            'nrRecInfPrelim',
            'cadIni',
        ],

        'groups' => [

            'infoRegimeTrab' => [

                'groups' => [
                    'infoCeletista' => [
                        'properties' => [
                            "dtAdm",
                            "tpAdmissao" => [
                                "type" => "int"
                            ],
                            "indAdmissao" => [
                                "type" => "int"
                            ],
                            "tpRegJor" => [
                                "type" => "int"
                            ],
                            "natAtividade" => [
                                "type" => "int"
                            ],
                            "dtBase" => [
                                'type' => 'int'
                            ],
                            "cnpjSindCategProf"
                        ],
                        "groups" => [
                            "FGTS" => [
                                "properties" => [
                                    "opcFGTS" => [
                                        'type' => 'int'
                                    ],
                                    "dtOpcFGTS",
                                ]
                            ],
                            "trabTemporario" => [
                                "properties" => [
                                    "hipLeg" => [
                                        "type" => "int"
                                    ],
                                    "justContr",
                                    "tpInclContr" => [
                                        "type" => "int"
                                    ]
                                ],
                                "groups" => [
                                    "ideTomadorServ" => [
                                        "properties" => [
                                            "tpInsc" => [
                                                "type" => "int"
                                            ],
                                            "nrInsc"
                                        ],
                                        "groups" => [
                                            "ideEstabVinc" => [
                                                "properties" => [
                                                    "tpInsc" => [
                                                        "type" => "int"
                                                    ],
                                                    "nrInsc"
                                                ]
                                            ]
                                        ]
                                    ],
                                    "ideTrabSubstituido" => [
                                        'type' => 'array',
                                        'items' => [
                                            'properties' => [
                                                'cpfTrabSubst'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            "aprend" => [
                                'properties' => [
                                    "tpInsc" => [
                                        "type" => "int"
                                    ],
                                    "nrInsc"
                                ]
                            ]
                        ]
                    ],
                    'infoEstatutario' => [
                        'properties' => [
                            'indProvim' => [
                                'type' => 'int'
                            ],
                            'tpProv' => [
                                'type' => 'int'
                            ],
                            'dtNomeacao',
                            'dtPosse',
                            'dtExercicio',
                            'tpPlanRP' => [
                                'type' => 'int'
                            ],
                        ],
                        'groups' => [
                            'infoDecJud' => [
                                'properties' => [
                                    'nrProcJud'
                                ]
                            ]
                        ]
                    ],
                ],

            ],

            "infoContrato" => [
                "properties" => [
                    "codCargo",
                    "codFuncao",
                    "codCateg" => [
                        "type" => "int"
                    ],
                    "codCarreira",
                    "dtIngrCarr"
                ],
                "groups" => [
                    "remuneracao" => [
                        "properties" => [
                            "vrSalFx" => [
                                "type" => "float"
                            ],
                            "undSalFixo" => [
                                "type" => "int"
                            ],
                            "dscSalVar"
                        ]
                    ],
                    "duracao" => [
                        "properties" => [
                            "tpContr" => [
                                "type" => "int"
                            ],
                            "dtTerm",
                            "clauAssec",
                            "objDet"
                        ]
                    ],

                    'localTrabalho' => [
                        'groups' => [
                            "localTrabGeral" => [
                                "properties" => [
                                    "tpInsc" => [
                                        "type" => "int"
                                    ],
                                    "nrInsc",
                                    "descComp"
                                ]
                            ],
                            "localTrabDom" => [
                                "properties" => [
                                    "tpLograd",
                                    "dscLograd",
                                    "nrLograd",
                                    "complemento",
                                    "bairro",
                                    "cep",
                                    "codMunic" => [
                                        "type" => "int"
                                    ],
                                    "uf",
                                ]
                            ],
                        ],
                    ],

                    "horContratual" => [
                        "properties" => [
                            "qtdHrsSem" => [
                                "type" => "int"
                            ],
                            "tpJornada" => [
                                "type" => "int"
                            ],
                            "dscTpJorn",
                            "tmpParc" => [
                                "type" => "int"
                            ],
                        ],
                        'groups' => [
                            'horario_codHorContrat_1' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => "Segunda-Feira",
                                    'properties' => [
                                        'horario_codHorContrat_1' => 'codHorContrat',
                                        'dia_1' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_2' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => "Terça-Feira",
                                    'properties' => [
                                        'horario_codHorContrat_2' => 'codHorContrat',
                                        'dia_2' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_3' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Quarta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_3' => 'codHorContrat',
                                        'dia_3' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_4' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Quinta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_4' => 'codHorContrat',
                                        'dia_4' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_5' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Sexta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_5' => 'codHorContrat',
                                        'dia_5' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_6' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Sábado',
                                    'properties' => [
                                        'horario_codHorContrat_6' => 'codHorContrat',
                                        'dia_6' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_7' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Domingo',
                                    'properties' => [
                                        'horario_codHorContrat_7' => 'codHorContrat',
                                        'dia_7' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_8' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Dia Variável',
                                    'properties' => [
                                        'horario_codHorContrat_8' => 'codHorContrat',
                                        'dia_8' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_9' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => "Segunda-Feira",
                                    'properties' => [
                                        'horario_codHorContrat_9' => 'codHorContrat',
                                        'dia_9' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_10' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => "Terça-Feira",
                                    'properties' => [
                                        'horario_codHorContrat_10' => 'codHorContrat',
                                        'dia_10' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_11' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Quarta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_11' => 'codHorContrat',
                                        'dia_11' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_12' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Quinta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_12' => 'codHorContrat',
                                        'dia_12' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_13' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Sexta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_13' => 'codHorContrat',
                                        'dia_13' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_14' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Sábado',
                                    'properties' => [
                                        'horario_codHorContrat_14' => 'codHorContrat',
                                        'dia_14' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_15' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Domingo',
                                    'properties' => [
                                        'horario_codHorContrat_15' => 'codHorContrat',
                                        'dia_15' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_16' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Dia Variável',
                                    'properties' => [
                                        'horario_codHorContrat_16' => 'codHorContrat',
                                        'dia_16' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_17' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => "Segunda-Feira",
                                    'properties' => [
                                        'horario_codHorContrat_17' => 'codHorContrat',
                                        'dia_17' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_18' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => "Terça-Feira",
                                    'properties' => [
                                        'horario_codHorContrat_18' => 'codHorContrat',
                                        'dia_18' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_19' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Quarta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_19' => 'codHorContrat',
                                        'dia_19' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_20' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Quinta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_20' => 'codHorContrat',
                                        'dia_20' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_21' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Sexta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_21' => 'codHorContrat',
                                        'dia_21' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_22' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Sábado',
                                    'properties' => [
                                        'horario_codHorContrat_22' => 'codHorContrat',
                                        'dia_22' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_23' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Domingo',
                                    'properties' => [
                                        'horario_codHorContrat_23' => 'codHorContrat',
                                        'dia_23' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_24' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Dia Variável',
                                    'properties' => [
                                        'horario_codHorContrat_24' => 'codHorContrat',
                                        'dia_24' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_25' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => "Segunda-Feira",
                                    'properties' => [
                                        'horario_codHorContrat_25' => 'codHorContrat',
                                        'dia_25' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_26' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => "Terça-Feira",
                                    'properties' => [
                                        'horario_codHorContrat_26' => 'codHorContrat',
                                        'dia_26' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_27' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Quarta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_27' => 'codHorContrat',
                                        'dia_27' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_28' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Quinta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_28' => 'codHorContrat',
                                        'dia_28' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_29' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Sexta-Feira',
                                    'properties' => [
                                        'horario_codHorContrat_29' => 'codHorContrat',
                                        'dia_29' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_30' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Sábado',
                                    'properties' => [
                                        'horario_codHorContrat_30' => 'codHorContrat',
                                        'dia_30' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_31' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Domingo',
                                    'properties' => [
                                        'horario_codHorContrat_31' => 'codHorContrat',
                                        'dia_31' => 'dia'
                                    ]
                                ]
                            ],
                            'horario_codHorContrat_32' => [
                                'type' => 'array',
                                'nome_api' => 'horario',
                                'label' => 'Horário',
                                'items' => [
                                    'label' => 'Dia Variável',
                                    'properties' => [
                                        'horario_codHorContrat_32' => 'codHorContrat',
                                        'dia_32' => 'dia'
                                    ]
                                ]
                            ],
                            'filiacaoSindical' => [
                                'type' => 'array',
                                'items' => [
                                    'properties' => [
                                        'cnpjSindTrab'
                                    ]

                                ]
                            ],
                            "alvaraJudicial" => [
                                "properties" => [
                                    "nrProcJud"
                                ]
                            ],
                            'observacoes' => [
                                'type' => 'array',
                                'items' => [
                                    'properties' => [
                                        'observacao'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
                    ],
                    'sucessaoVinc' => [
                        'properties' => [
                            'tpInscAnt',
                            'cnpjEmpregAnt',
                            'matricAnt',
                            'sucessaoVinc_dtTransf' => 'dtTransf',
                            'sucessaoVinc_observacao' => 'observacao'
                        ]
                    ],
                    'transfDom' => [
                        'properties' => [
                            'cpfSubstituido',
                            'transfDom_matricAnt' => 'matricAnt',
                            'dtTransf'
                        ]
                    ],
                    'mudancaCPF' => [
                        'properties' => [
                            'cpfAnt',
                            'matricAnt',
                            'dtAltCPF',
                            'mudancaCPF_observacao' => 'observacao',
                        ]
                    ],
                    'afastamento' => [
                        'properties' => [
                            'dtIniAfast',
                            'codMotAfast'
                        ]
                    ],
                    'desligamento' => [
                        'properties' => [
                            'dtDeslig'
                    ]
            ]
        ]
    ]
];
