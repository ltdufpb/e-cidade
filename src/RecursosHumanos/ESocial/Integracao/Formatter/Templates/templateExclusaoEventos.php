<?php
return [
    'infoExclusao' => [
        'properties' => [
            'tpEvento' => [
                'type' => 'string',
                'maxLength' => 6,
                'minLength' => 5
            ],
            'nrRecEvt' =>[
                'type' => 'string',
                'maxLength' => 40,
                'minLength' => 1
            ]
        ],
        'groups' => [
            'ideTrabalhador' => [
                'properties' => [
                    'cpfTrab' => [
                        'type' => 'string',
                        'maxLength' => 11,
                        'minLength' => 11
                    ]
                ]
            ],
            'ideFolhaPagto' => [
                'properties' => [
                    'indApuracao' => [
                        'type' => 'int'
                    ],
                    'perApur' => [
                        'type' => 'string'
                    ]
                ]
            ]
        ]
    ],
];
