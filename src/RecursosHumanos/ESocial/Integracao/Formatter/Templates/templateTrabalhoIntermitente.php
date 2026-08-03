<?php
return [
    'ideVinculo' => [
        'properties' => [
            'cpfTrab',
            'nisTrab',
            'matricula'
        ]
    ],
    'infoConvInterm' => [
        'properties' => [
            'codConv',
            'dtInicio',
            'dtFim',
            'dtPrevPgto'
        ],
        'groups' => [
            'jornada' => [
                'properties' => [
                    'codHorContrat',
                    'dscJornada'
                ]
            ],
            'localTrab' => [
                'properties' => [
                    'indLocal' => [
                        'type' => 'int'
                    ]
                ],
                'groups' => [
                    'localTrabInterm' => [
                        'properties' => [
                            'tpLograd',
                            'dscLograd',
                            'nrLograd',
                            'complem',
                            'bairro',
                            'cep',
                            'codMunic' => [
                                'type' => 'int'
                            ],
                            'uf'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
