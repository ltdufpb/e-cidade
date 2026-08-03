<?php
return [
    'ideHorContratual' => [
        'properties' => [
            'codHorContrat' => [
                'required' => true,
                'type' => 'string',
                'maxLength' => 30,
                'pattern' => '^(?!eSocial)',
            ],
            'iniValid' => [
                'required' => true,
                'type' => 'string',
                'pattern' => '^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])$',
            ],
            'fimValid' => [
                'required' => false,
                'type' => [
                    0 => 'string',
                    1 => 'null',
                ],
                'pattern' => '^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])$',
            ],

        ]
    ],
    'dadosHorContratual' => [
        'required' => true,
        'type' => 'object',
        'properties' => [
            'hrEntr' =>
                [
                    'required' => true,
                    'type' => 'string',
                    'pattern' => '^(?:2[0-3]|[0-1]?[0-9])[0-5]?[0-9]$',
                ],
            'hrSaida' =>
                [
                    'required' => true,
                    'type' => 'string',
                    'pattern' => '^(?:2[0-3]|[0-1]?[0-9])[0-5]?[0-9]$',
                ],
            'durJornada' =>
                [
                    'required' => true,
                    'type' => 'integer',
                    'minimum' => 1,
                    'maximum' => 9999,
                ],
            'perHorFlexivel' => [
                'required' => true,
                'type' => 'string',
                'pattern' => 'S|N',
            ]
        ],
        'groups' => [
            'horarioIntervalo' => [
                'required' => false,
                'type' => 'array',
                'minItems' => 0,
                'maxItems' => 99,
                'items' => [
                    'type' => 'object',
                    'properties' => [
                        'tpInterv' => [
                            'required' => true,
                            'type' => 'integer',
                            'minimum' => 1,
                            'maximum' => 2,
                        ],
                        'durInterv' => [
                            'required' => true,
                            'type' => 'integer',
                            'minimum' => 1,
                            'maximum' => 999,
                        ],
                        'iniInterv' => [
                            'required' => false,
                            'type' => 'string',
                            'pattern' => '^[0-2][0-3][0-5][0-9]$',
                        ],
                        'termInterv' => [
                            'required' => false,
                            'type' => 'string',
                            'pattern' => '^[0-2][0-3][0-5][0-9]$',
                        ]
                    ]
                ]
            ]
        ]
    ]
];
