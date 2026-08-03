<?php
return [
    'infoRegPrelim' => [
        'nome_api' => 'infoRegPrelim',
        'properties' => [
            'cpfTrab',
            'dtNascto',
            'dtAdm',
            'matricula',
            'codCateg' => [
                'type' => 'int'
            ],
            'natAtividade' => [
                'type' => 'int'
            ]
        ],
        'groups' => [
            'infoRegCTPS' => [
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'CBOCargo',
                        'vrSalFx' => [
                            'type' => 'float'
                        ],
                        'undSalFixo' => [
                            'type' => 'int'
                        ],
                        'tpContr' => [
                            'type' => 'int'
                        ],
                        'dtTerm'
                    ]
                ]
            ]
        ]
    ]
];
