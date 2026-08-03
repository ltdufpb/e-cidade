<?php
/**
 * Template para o arquivo S-2306
 * Alteração de Contrato de Trabalhador Sem Vinculo Empregaticio
 */
return [

    'ideTrabSemVinculo' => [
        'properties' => [
            'cpfTrab',
            'nisTrab',
            'codCateg'
        ]
    ],
    'infoTSVAlteracao' => [
        'properties' => [
            'dtAlteracao',
            'natAtividade'
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
                            'vrSalFx',
                            'undSalFixo',
                            'dscSalVar'
                        ]
                    ],
                    'infoEstagiario' => [
                        'properties' => [
                            'natEstagio',
                            'nivEstagio',
                            'areaAtuacao',
                            'nrApol',
                            'vlrBolsa',
                            'dtPrevTerm'
                        ],
                        'groups' => [
                            'instEnsino' => [
                                'instEnsino_cnpjInstEnsino' => 'cnpjInstEnsino',
                                'instEnsino_nmRazao' => 'nmRazao',
                                'instEnsino_dscLograd' => 'dscLograd',
                                'instEnsino_nrLograd' => 'nrLograd',
                                'instEnsino_bairro' => 'bairro',
                                'instEnsino_cep' => 'cep',
                                'instEnsino_codMunic' => 'codMunic',
                                'instEnsino_uf' => 'uf'
                            ],
                            'ageIntegracao' => [
                                'ageIntegracao_cnpjAgntInteg' => 'cnpjAgntInteg',
                                'ageIntegracao_nmRazao' => 'nmRazao',
                                'ageIntegracao_dscLograd' => 'dscLograd',
                                'ageIntegracao_nrLograd' => 'nrLograd',
                                'ageIntegracao_bairro' => 'bairro',
                                'ageIntegracao_cep' => 'cep',
                                'ageIntegracao_codMunic' => 'codMunic',
                                'ageIntegracao_uf' => 'uf'
                            ],
                            'supervisorEstagio' => [
                                'cpfSupervisor',
                                'nmSuperv'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];