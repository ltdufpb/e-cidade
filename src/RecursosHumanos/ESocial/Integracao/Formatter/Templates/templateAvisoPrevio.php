<?php
/**
 * Template Aviso Previo
 * Layout Registros do evento S-2250 - Aviso Previo
 */
return [
    'ideVinculo' => [
        'required' => true,
        'properties' => [
            'cpfTrab' => [
                'required' => true,
                'type' => 'string',
            ],
            'nisTrab' => [
                'required' => true,
                'type' => 'string',
            ],
            'matricula' => [
                'required' => true,
                'type' =>'string',
            ],
        ]
    ],
    'infoAvPrevio' => [
        'groups' => [
            'detAvPrevio' => [
                'label' => 'Detalha as informações do evento trabalhista',
                'properties' => [
                    'dtAvPrv' => [
                        'required' => true,
                        'type' => 'string',
                        'label' => 'Data em que o trabalhador ou o empregador recebeu o aviso de desligamento',
                    ],
                    'dtPrevDeslig' => [
                        'required' => true,
                        'label' => 'Data prevista para o desligamento do trabalhador',
                        'type' => 'string'
                    ],
                    'tpAvPrevio' => [
                        'required' => true,
                        'label' => 'Tipo de Aviso Prévio',
                        'type' => 'int'
                    ],
                    'detAvPrevio_observacao' => [
                        'nome_api' => 'observacao',
                        'required' => false,
                        'type' => 'string',
                    ]
                ]
            ],
            'cancAvPrevio' => [
                'properties' => [
                    'dtCancAvPrv' => [
                        'required' => true,
                        'type' => 'string',
                    ],
                    'cancAvPrevio_observacao' => [
                        'nome_api' => 'observacao',
                        'required' => false,
                        'type' => 'string',
                    ],
                    'mtvCancAvPrevio' => [
                        'required' => true,
                        'type' => 'int',
                    ]
                ]
            ]
        ]
    ]
];
