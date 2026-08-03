<?php
return [
    'ideCargo' => [
        'properties' => [
            'codCargo',
            'iniValid',
            'fimValid'
        ]
    ],
    'dadosCargo' => [
        'properties' => [
            'nmCargo' => [
                'type' => 'string',
                'minLength' => 8,
                'maxLength' => 100,
            ],
            'codCBO' => [
                'type' => 'string',
                'minLength' => 6,
                'maxLength' => 6,
                'pattern' => '^[0-9]',
            ],
        ],
        'groups' => [
            'cargoPublico' => [
                'properties' => [
                    'acumCargo' => [
                        'required' => true,
                        'type' => 'integer',
                        'minimum' => 1,
                        'maximum' => 4,
                    ],
                    'contagemEsp' => [
                        'required' => true,
                        'type' => 'integer',
                        'minimum' => 1,
                        'maximum' => 4,
                    ],
                    'dedicExcl' => [
                        'required' => true,
                        'type' => 'string',
                        'pattern' => 'S|N',
                    ],

                ],
                'groups' => [
                    'leiCargo' => [
                        'required' => true,
                        'properties' => [
                            'nrLei' => [
                                'required' => true,
                                'type' => 'string',
                                'minLength' => 3,
                                'maxLength' => 12,
                            ],
                            'dtLei' => [
                                'required' => true,
                                'type' => 'string',
                                'pattern' => '^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$',
                            ],
                            'sitCargo' => [
                                'required' => true,
                                'type' => 'integer',
                                'minimum' => 1,
                                'maximum' => 3,
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

