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
    'ideProcesso' => [
        'properties' => [
            'tpProc' => [
                'type' => 'int'
            ],
            'nrProc',
            'iniValid',
            'fimValid' => [
                'nome_api' => 'fimvalid'
            ],
            'indAutoria'=> [
                'type' => 'int',
                'nome_api' => 'indautoria'
            ]
        ],
        'groups' => [
            'infoSusp_1' => [
                'nome_api' => 'infosusp',
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'infoSusp_1_codSusp'=> [
                            'nome_api' => 'codsusp',
                            'type' => 'string'
                        ],
                        'infoSusp_1_indSusp' => 'indsusp',
                        'infoSusp_1_dtDecisao' => 'dtdecisao',
                        'infoSusp_1_indDeposito' =>'inddeposito'
                    ]
                ]
            ],
            'infoSusp_2' => [
                'nome_api' => 'infosusp',
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'infoSusp_2_codSusp' => [
                            'nome_api' => 'codsusp',
                            'type' => 'string'
                        ],
                        'infoSusp_2_indSusp' => 'indsusp',
                        'infoSusp_2_dtDecisao' => 'dtdecisao',
                        'infoSusp_2_indDeposito' =>'inddeposito'
                    ]
                ]
            ],
            'infoSusp_3' => [
                'nome_api' => 'infosusp',
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'infoSusp_3_codSusp' => [
                            'nome_api' => 'codsusp',
                            'type' => 'string'
                        ],
                        'infoSusp_3_indSusp' => 'indsusp',
                        'infoSusp_3_dtDecisao' => 'dtdecisao',
                        'infoSusp_3_indDeposito' =>'inddeposito'
                    ]
                ]
            ],
            'infoSusp_4' => [
                'nome_api' => 'infosusp',
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'infoSusp_4_codSusp' => [
                            'nome_api' => 'codsusp',
                            'type' => 'string'
                        ],
                        'infoSusp_4_indSusp' => 'indsusp',
                        'infoSusp_4_dtDecisao' => 'dtdecisao',
                        'infoSusp_4_indDeposito' =>'inddeposito'
                    ]
                ]
            ],
            'infoSusp_5' => [
                'nome_api' => 'infosusp',
                'type' => 'array',
                'items' => [
                    'properties' => [
                        'infoSusp_5_codSusp' => [
                            'nome_api' => 'codsusp',
                            'type' => 'string'
                        ],
                        'infoSusp_5_indSusp' => 'indsusp',
                        'infoSusp_5_dtDecisao' => 'dtdecisao',
                        'infoSusp_5_indDeposito' =>'inddeposito'
                    ]
                ]
            ],
            'dadosProcJud' => [
                'nome_api' => 'dadosprocjud',
                'properties' => [
                    'ufVara' => [
                        'nome_api' => 'ufvara'
                    ],
                    'codMunic' => [
                        'nome_api' => 'codmunic',
                        'type' => 'string'
                    ],
                    'idVara' => [
                        'nome_api' => 'idvara'
                    ]
                ]
            ]
        ]
    ],
];
