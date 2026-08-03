<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

final class Exercicio extends Layout
{
    public function __construct()
    {
        $this->fields = [
            'BRANCOS1' => [
                'name'            => 'BRANCOS'
                ,'description'    => 'BRANCOS'
                ,'size'           => 3
            ]
            ,'BRANCOS2' => [
                'name'            => 'BRANCOS'
                ,'description'    => 'BRANCOS'
                ,'size'           => 5
            ]
            ,'DESCRICAOISENCAO' => [
                'name'            => 'DESCRISEN'
                ,'description'    => 'DESCRICAO DO TIPO DE ISENCAO'
                ,'size'           => 40
            ]
            ,'LANCAMENTOISENCAO' => [
                'name'            => 'LANCISEN'
                ,'description'    => 'DATA DE LANCAMENTO DA ISENCAO'
                ,'size'           => 10
            ]
            ,'TOTALLANCADO' => [
                'name'            => 'TOTREGLANC'
                ,'description'    => 'TOTAL DOS VALORES LANCADOS (IMPOSTO + TAXAS)'
                ,'size'           => 15
            ]
            ,'QUANTIDADELANCADO' => [
                'name'            => 'QUANTREGLANC'
                ,'description'    => 'QUANTIDADE DE LANCAMENTOS (IMPOSTO + TAXAS)'
                ,'size'           => 3
            ]
            ,'TOTALLANCADOTAXAS' => [
                'name'            => 'TOTREGLANCTAXAS'
                ,'description'    => 'TOTAL DOS VALORES LANCADOS (TAXAS)'
                ,'size'           => 15
            ]
            ,'QUANTIDADELANCADOTAXAS' => [
                'name'            => 'QUANTREGLANCTAXAS'
                ,'description'    => 'QUANTIDADE DE LANCAMENTOS (TAXAS)'
                ,'size'           => 3
            ]
            ,'VALORCORRIGIDOIPTU' => [
                'name'            => 'VALORCORRIGIDOIPTU2018'
                ,'description'    => 'VALOR CORRIGIDO DA IPTU DESTA MATRICULA NO ANO 2018'
                ,'size'           => 15
            ]
            ,'VALORJUROSIPTU' => [
                'name'            => 'VALORJUROSIPTU2018'
                ,'description'    => 'VALOR DOS JUROS DA IPTU DESTA MATRICULA NO ANO 2018'
                ,'size'           => 15
            ]
            ,'VALORMULTAIPTU' => [
                'name'            => 'VALORMULTAIPTU2018'
                ,'description'    => 'VALOR DA MULTA DA IPTU DESTA MATRICULA NO ANO 2018'
                ,'size'           => 15
            ]
            ,'VALORDESCONTOIPTU' => [
                'name'            => 'VALORDESCONTOIPTU2018'
                ,'description'    => 'VALOR DO DESCONTO DA IPTU DESTA MATRICULA NO ANO 2018'
                ,'size'           => 15
            ]
            ,'VALORTOTALIPTU' => [
                'name'            => 'VALORTOTALIPTU2018'
                ,'description'    => 'VALOR TOTAL DA IPTU DESTA MATRICULA NO ANO 2018'
                ,'size'           => 15
            ]
            ,'CODIGOFACE' => [
                'name'            => 'CODIGOFACE'
                ,'description'    => 'CODIGO DA FACE'
                ,'size'           => 10
            ]
            ,'VALORM2TERRENOFACE' => [
                'name'            => 'VALORM2TERRENOFACE'
                ,'description'    => 'VALOR DO M2 DO TERRENO BASEADO NA FACE'
                ,'size'           => 20
            ]
            ,'VALORM2CONSTRUCAOFACE' => [
                'name'            => 'VALORM2CONSTRFACE'
                ,'description'    => 'VALOR DO M2 DAS EDIFICACOES BASEADO NA FACE'
                ,'size'           => 20
            ]
            ,'VALORVENALTERRENO' => [
                'name'            => 'VLRVENALTER'
                ,'description'    => 'VALOR VENAL TERRENO'
                ,'size'           => 15
            ]
            ,'VALORVENALEDIFICACAO' => [
                'name'            => 'VLRVENALEDI'
                ,'description'    => 'VALOR VENAL EDIFICACOES'
                ,'size'           => 15
            ]
            ,'VALORVENALTOTAL' => [
                'name'            => 'VLRVENALTOTAL'
                ,'description'    => 'VALOR VENAL TOTAL (TERRENO + EDIFICACOES)'
                ,'size'           => 15
            ]
            ,'ALIQUOTA' => [
                'name'            => 'ALIQ'
                ,'description'    => 'ALIQUOTA'
                ,'size'           => 6
            ]
        ];
    }
}
