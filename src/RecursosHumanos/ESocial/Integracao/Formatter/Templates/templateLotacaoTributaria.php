<?php
return [
    "ideLotacao" => [
        'properties' => [
            "codLotacao",
            "iniValid",
            "fimValid",
        ]
    ],
    "dadosLotacao"=> [
        'properties' => [
            "tpLotacao",
            "tpInsc" => [
                "type" => "int"
            ],
            "nrInsc",
        ],
        "groups" => [
            "fpasLotacao" => [
                "properties" => [
                    "fpas" => [
                        "type" => "int"
                    ],
                    "codTercs",
                    "codTercsSusp",
                ],
                "groups" =>  [
                    "procJudTerceiro" => [
                        "type" => "array",
                        "items" => [
                            "properties" => [
                                "codTerc",
                                "nrProcJud",
                                "codSusp",
                            ]
                        ]
                    ]
                ]
            ],
            "infoEmprParcial" =>  [
                "properties" => [

                    "tpInscContrat" => [
                        "type" => "int"
                    ],
                    "nrInscContrat",
                    "tpInscProp" => [
                        "type" => "int"
                    ],
                    "nrInscProp",
                ]
            ],
            "dadosOpPort" => [
                "properties" => [
                    "aliqRat" => [
                        "type" => "int"
                    ],
                    "fap" => [
                        "type" => "float"
                    ],
                ]
            ]
        ]
    ]
];
