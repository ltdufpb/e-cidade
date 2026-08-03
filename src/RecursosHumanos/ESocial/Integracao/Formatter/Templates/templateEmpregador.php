<?php
return [
    'ideEstab' => [
        'nome_api' => 'ideEstab',
        'properties' => [
            'iniValid' => 'iniValid',
            'fimValid' => 'fimValid'
        ]
    ],
    'idePeriodo' => [
        'label' => 'Identificação do periodo',
        'properties' => [
            'iniValid' => [
                'type' => 'string',
                'label' => 'Data inicial',
            ],
            'fimValid' => [
                'type' => 'string',
                'label' => 'Data final',
            ],
        ],
    ],
    'infoCadastro' => [
        'properties' => [
            'classTrib',
            'indCoop' => [
                'type' => 'int'
            ],
            'indConstr' => [
                'type' => 'int'
            ],
            'indDesFolha' => [
                'type' => 'int'
            ],
            'indOpcCP' => [
                'type' => 'int'
            ],
            'indPorte',
            'indOptRegEletron' => [
                'type' => 'int'
            ],
            'cnpjEFR' => 'cnpjEFR',
            'iniValid1000',
            'fimValid1000'
        ]
    ],
    'dadosIsencao' => [
        'properties' => [
            'ideMinLei' => 'ideMinLei',
            'nrCertif' => 'nrCertif',
            'dtEmisCertif' => 'dtEmisCertif',
            'dtVencCertif' => 'dtVencCertif',
            'nrProtRenov' => 'nrProtRenov',
            'dtProtRenov' => 'dtProtRenov',
            'dtDou' => 'dtDou',
            'pagDou' => [
                'nome_api' => 'pagDou',
                'type' => 'int'
            ]
        ]
    ],
    'infoOrgInternacional' => [
        'properties' => [
            'indAcordoIsenMulta' => [
                'nome_api' => 'indAcordoIsenMulta',
                'type' => 'int'
            ]
        ]
    ]
];
