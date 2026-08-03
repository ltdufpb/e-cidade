<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \BusinessException;

final class ParcelaRecibo extends LayoutParcelas
{
    /**
     * Construtor de classe
     */ 
    public function __construct ($parcelas)
    {
        if(empty($parcelas)) {
            throw BusinessException('Informe o número de parcelas para o layout');
        }
        
        $this->fields = [
            'VENCIMENTOPARCELA' => [
                'name'           => 'VENCPARC{$nroParcela}'
                ,'description'   => 'VENCIMENTO DA PARCELA{$nroParcela}'
                ,'size'           => 10
            ]
            ,'VALORPARCELA' => [
                'name'           => 'VALPARC{$nroParcela}'
                ,'description'   => 'VALOR DA PARCELA{$nroParcela}'
                ,'size'           => 15
            ]
            ,'VALORJUROPARCELA' => [
                'name'           => 'VALJURPARC{$nroParcela}'
                ,'description'   => 'JUROS POR ATRASO DE 1 MES JA CALCULADOS DA PARCELA{$nroParcela}'
                ,'size'           => 15
            ]
            ,'VALORMULTAPARCELA' => [
                'name'           => 'VALMULPARC{$nroParcela}'
                ,'description'   => 'MULTA POR ATRASO DE 1 MES JA CALCULADOS DA PARCELA{$nroParcela}'
                ,'size'           => 15
            ]
            ,'NUMPREPARCELA' => [
                'name'           => 'NUMPREPARC{$nroParcela}'
                ,'description'   => 'CODIGO DE ARRECADACAO DA PARCELA{$nroParcela}'
                ,'size'           => 11
            ]
            ,'CODIGOBARRASPARCELA' => [
                'name'           => 'BARRASPARC{$nroParcela}'
                ,'description'   => 'CODIGO DE BARRAS DA PARCELA{$nroParcela}'
                ,'size'           => 96
            ]
            ,'PARCELA' => [
                'name'           => 'PARC{$nroParcela}'
                ,'description'   => 'PARCELA{$nroParcela}'
                ,'size'           => 3
            ]
        ];

        parent::__construct($parcelas);
    }
}
