<?php

namespace App\Domain\Patrimonial\Ouvidoria\HelperServices;

class MenuHelper
{

    public static function converterMenusParaObjeto($menusResult)
    {

        $instituicoes = collect($menusResult)->groupBy(fn($menu) => $menu->instituicao_codigo)->toArray();

        return collect($instituicoes)->flatMap(function ($instituicao, $index) {

            $itens_menu = array_map(fn($item) => (object)[
                'codigo' => $item->orgao_codigo
                , 'nome' => mb_convert_encoding(urldecode((string) $item->orgao_nome), 'UTF-8', 'ISO-8859-1')
                , 'estrutura' => 'secretaria'
                , 'tipoprocesso_codigo' => $item->tipoprocesso_codigo
                , 'tipoprocesso_descricao' => mb_convert_encoding(urldecode((string) $item->tipoprocesso_descricao), 'UTF-8', 'ISO-8859-1')
                , 'tipoprocesso_depto_id' => mb_convert_encoding(urldecode((string) $item->tipoprocesso_depto_id), 'UTF-8', 'ISO-8859-1')
                , 'tipoprocesso_depto_descricao' => mb_convert_encoding(urldecode((string) $item->tipoprocesso_depto_descricao), 'UTF-8', 'ISO-8859-1')
                , 'tipoprocesso_formareclamacao' => mb_convert_encoding(urldecode((string) $item->tipoprocesso_formareclamacao), 'UTF-8', 'ISO-8859-1')
                , 'linksaibamais' => mb_convert_encoding(urldecode((string) $item->linksaibamais), 'UTF-8', 'ISO-8859-1')
                , 'item_menu' => mb_convert_encoding(urldecode((string) $item->item_menu), 'UTF-8', 'ISO-8859-1')
                , 'rota' => mb_convert_encoding(urldecode((string) $item->rota), 'UTF-8', 'ISO-8859-1')
                , 'identificado' => $item->identificado == 't' ? 'sim' : 'nao'
            ], $instituicao);

            $itens_menu = collect($itens_menu)->groupBy(fn($item_menu) => $item_menu->item_menu)->toArray();

            $items_menu_com_filhos = collect($itens_menu)->flatMap(function ($item_menu, $index) {

                $tiposProcessos = array_map(fn($item) => (object)[
                    'id' => $item->tipoprocesso_codigo
                    , 'descricao' => $item->tipoprocesso_descricao
                    , 'nome' => $item->tipoprocesso_descricao
                    , 'depto_id' => $item->tipoprocesso_depto_id
                    , 'depto_descricao' => $item->tipoprocesso_depto_descricao
                    , 'formareclamacao' => $item->tipoprocesso_formareclamacao
                    , 'linksaibamais' => $item->linksaibamais
                    , 'rota' => mb_convert_encoding(urldecode((string) $item->rota), 'UTF-8', 'ISO-8859-1')
                    , 'identificado' => $item->identificado
                ], $item_menu);


                if ($index == "") {
                    return $tiposProcessos;
                }
                return [
                    (object)[
                        'id' => $index
                        , 'codigo' => $item_menu[0]->codigo
                        , 'nome' => $item_menu[0]->item_menu
                        , 'estrutura' => 'item_menu'
                        , 'children' => $tiposProcessos
                    ]
                ];
            });

            return [
                $index => (object)[
                    'id' => $index
                    , 'codigo' => mb_convert_encoding(urldecode((string) $instituicao[0]->instituicao_codigo), 'UTF-8', 'ISO-8859-1')
                    , 'nome' => mb_convert_encoding(urldecode((string) $instituicao[0]->instituicao_nome), 'UTF-8', 'ISO-8859-1')
                    , 'estrutura' => 'instituicao'
                    , 'children' => $items_menu_com_filhos
                ]
            ];
        })->values();
    }

    public static function coverterMenuPrimeiroAcesso($menusResult)
    {
        $instituicoes = collect($menusResult)->groupBy(fn($grupo) => $grupo->instituicao_codigo)->toArray();

        return collect($instituicoes)->flatMap(function ($instituicao, $index) {

            $secretarias = array_map(fn($item) => (object)[
                'codigo' => $item->orgao_codigo
                , 'nome' => mb_convert_encoding(urldecode((string) $item->orgao_nome), 'UTF-8', 'ISO-8859-1')
                , 'estrutura' => 'secretaria'
                , 'tipoprocesso_codigo' => $item->tipoprocesso_codigo
                , 'tipoprocesso_descricao' => mb_convert_encoding(urldecode((string) $item->tipoprocesso_descricao), 'UTF-8', 'ISO-8859-1')
                , 'tipoprocesso_depto_id' => mb_convert_encoding(urldecode((string) $item->tipoprocesso_depto_id), 'UTF-8', 'ISO-8859-1')
                , 'tipoprocesso_depto_descricao' => mb_convert_encoding(urldecode((string) $item->tipoprocesso_depto_descricao), 'UTF-8', 'ISO-8859-1')
                , 'tipoprocesso_formareclamacao' => mb_convert_encoding(urldecode((string) $item->tipoprocesso_formareclamacao), 'UTF-8', 'ISO-8859-1')
                , 'linksaibamais' => mb_convert_encoding(urldecode((string) $item->linksaibamais), 'UTF-8', 'ISO-8859-1')
                , 'rota' => mb_convert_encoding(urldecode((string) $item->rota), 'UTF-8', 'ISO-8859-1')
            ], $instituicao);

            $secretarias = collect($secretarias)->groupBy(fn($secreataria) => $secreataria->codigo)->toArray();


            $secretariasComTiposDeProcessos = collect($secretarias)->flatMap(function ($secretaria, $index) {
                $tiposProcessos = array_map(fn($item) => (object)[
                    'id' => $item->tipoprocesso_codigo
                    , 'descricao' => $item->tipoprocesso_descricao
                    , 'nome' => $item->tipoprocesso_descricao
                    , 'depto_id' => $item->tipoprocesso_depto_id
                    , 'depto_descricao' => $item->tipoprocesso_depto_descricao
                    , 'formareclamacao' => $item->tipoprocesso_formareclamacao
                    , 'linksaibamais' => $item->linksaibamais
                    , 'rota' => mb_convert_encoding(urldecode((string) $item->rota), 'UTF-8', 'ISO-8859-1')
                ], $secretaria);

                return [
                    $index => (object)[
                        'id' => $index
                        , 'codigo' => $secretaria[0]->codigo
                        , 'nome' => $secretaria[0]->nome
                        , 'estrutura' => 'orgao'
                        , 'children' => $tiposProcessos
                    ]
                ];
            });

            return [
                $index => (object)[
                    'id' => $index
                    , 'codigo' => mb_convert_encoding(urldecode((string) $instituicao[0]->instituicao_codigo), 'UTF-8', 'ISO-8859-1')
                    , 'nome' => mb_convert_encoding(urldecode((string) $instituicao[0]->instituicao_nome), 'UTF-8', 'ISO-8859-1')
                    , 'estrutura' => 'instituicao'
                    , 'children' => $secretariasComTiposDeProcessos
                ]
            ];
        })->values();
    }
}
