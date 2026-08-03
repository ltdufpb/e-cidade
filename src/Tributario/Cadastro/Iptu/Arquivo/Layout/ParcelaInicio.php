<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \BusinessException;

final class ParcelaInicio extends Layout
{
    public function __construct ()
    {
        $this->fields = [
            'TOTALPARCELAS'  => [
                'name'           => 'TOTPARC'
                ,'description'   => 'QUANTIDADE TOTAL DE PARCELAS'
                ,'size'          => 3
            ]
            ,'EXPRESAOPARCELADOS'  => [
                'name'           => 'EXP_PARCELADOS'
                ,'description'   => 'EXPRESSAO PARCELADOS'
                ,'size'          => 10
            ]
            ,'PERCENTUALMESJUROATRASO'  => [
                'name'           => 'PERCMESJURATRASO'
                ,'description'   => 'PERCENTUAL POR MES DE JUROS POR ATRASO'
                ,'size'          => 15
            ]
            ,'PERCENTUALGERALMULTAATRASO'  => [
                'name'           => 'PERCGERMULATRASO'
                ,'description'   => 'PERCENTUAL GERAL DE MULTA POR ATRASO'
                ,'size'          => 15
            ]
        ];
    }
}
