<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

return [
    'ideEstabPrest' => [
        'properties' => [
            'tpInscEstabPrest'=> [
                'type' => 'int'
            ],
            'nrInscEstabPrest',
            'perApur',
        ],
        'groups' => [
            'ideTomador' => [
                'properties' => [
                    'tpInscTomador' => [
                        'type' => 'int'
                    ],
                    'nrInscTomador',
                    'indObra',
                    'vlrTotalBruto' => [
                        'type' => 'float'
                    ],
                    'vlrTotalBaseRet' => [
                        'type' => 'float'
                    ],
                    'vlrTotalRetPrinc' => [
                        'type' => 'float'
                    ],
                    'vlrTotalRetAdic' => [
                        'type' => 'float'
                    ],
                    'vlrTotalNRetPrinc' => [
                        'type' => 'float'
                    ],
                    'vlrTotalNRetAdic' => [
                        'type' => 'float'
                    ],
                ],
                'groups' => [
                    'nfs' => [
                        'properties' => [
                            'serie',
                            'numDocto',
                            'dtEmissaoNF',
                            'vlrBruto' => [
                                'type' => 'float'
                            ],
                            'obs',
                        ],
                        'groups' => [
                            'infoTpServ' => [
                                'type' => 'array',
                                'nome_api' => 'infoTpServ',
                                'items' => [
                                    'properties' => [
                                        'tpServico' => [
                                            'type' => 'int'
                                        ],
                                        'vlrBaseRet' => [
                                            'type' => 'float'
                                        ],
                                        'vlrRetencao' => [
                                            'type' => 'float'
                                        ],
                                        'vlrRetSub' => [
                                            'type' => 'float'
                                        ],
                                        'vlrNRetPrinc' => [
                                            'type' => 'float'
                                        ],
                                        'vlrServicos15' => [
                                            'type' => 'float'
                                        ],
                                        'vlrServicos20' => [
                                            'type' => 'float'
                                        ],
                                        'vlrServicos25' => [
                                            'type' => 'float'
                                        ],
                                        'vlrAdicional' => [
                                            'type' => 'float'
                                        ],
                                        'vlrNRetAdic' => [
                                            'type' => 'float'
                                        ],
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'infoProcRetPr' => [
                        'type' => 'array',
                        'nome_api' => 'infoProcRetPr',
                        'items' => [
                            'properties' => [
                                'tpProcRetPrinc' => [
                                    'type' => 'int'
                                ],
                                'nrProcRetPrinc',
                                'codSuspPrinc' => [
                                    'type' => 'int'
                                ],
                                'valorPrinc' => [
                                    'type' => 'float'
                                ]
                            ]
                        ]
                    ],
                    'infoProcRetAd' => [
                        'type' => 'array',
                        'nome_api' => 'infoProcRetAd',
                        'items' => [
                            'properties' => [
                                'tpProcRetAdic' => [
                                    'type' => 'int'
                                ],
                                'nrProcRetAdic',
                                'codSuspAdic' => [
                                    'type' => 'int'
                                ],
                                'valorAdic' => [
                                    'type' => 'float'
                                ]
                            ]
                        ]
                    ],
                ]
            ]
        ]
    ]
];