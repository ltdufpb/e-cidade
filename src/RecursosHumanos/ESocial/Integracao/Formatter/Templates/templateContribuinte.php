<?php
return [
    'idePeriodo' => [
        'properties' => [
            'iniValid',
            'fimValid' => [
                'nome_api' => 'fimvalid'
            ]
        ]
    ],
    'infoCadastro' => [
        'nome_api' => 'infocadastro',
        'properties' => [
            'classTrib' => [
                'nome_api' => 'classtrib'
            ],
            'indEscrituracao' => [
                'nome_api' => 'indescrituracao',
                'type' => 'int'
            ],
            'indDesoneracao' => [
                'nome_api' => 'inddesoneracao',
                'type' => 'int'
            ],
            'indAcordoIsenMulta' => [
                'nome_api' => 'indacordoisenmulta',
                'type' => 'int'
            ],
            'indSitPJ' => [
                'nome_api' => 'indsitpj',
                'type' => 'int'
            ]
        ],
        'groups' => [
            'contato' => [
                'properties' => [
                    'nmCtt' => [
                        'nome_api' => 'nmctt'
                    ],
                    'cpfCtt' => [
                        'nome_api' => 'cpfctt'
                    ],
                    'foneFixo' => [
                        'nome_api' => 'fonefixo'
                    ],
                    'foneCel' => [
                        'nome_api' => 'fonecel'
                    ],
                    'email' => [
                        'nome_api' => 'email'
                    ]
                ]
            ]
        ]
    ],
    'grupo-novaValidade' => [
        'nome_api' => 'novavalidade',
        'properties' => [
            'novainiValid' => [
                'nome_api' => 'inivalid'
            ],
            'novafimValid' => [
                'nome_api' => 'fimvalid'
            ]
        ]
    ]
];
