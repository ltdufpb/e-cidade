<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \BusinessException;

final class ImovelAnterior extends Layout
{
    public function __construct ()
    {
        $this->fields = [
            'TESTADALOTE' => [
                 'name'         => 'TESTADALOTE'
                ,'description'  => 'TESTADA PRINCIPAL DO LOTE'
                ,'size'         => 20
            ]
            ,'AREALOTE' => [
                 'name'         => 'AREALOTE'
                ,'description'  => 'AREA DO LOTE'
                ,'size'         => 20
            ]
            ,'AREATOTALCONSTRUIDA' => [
                 'name'         => 'AREATOTCONSTR'
                ,'description'  => 'AREA TOTAL CONSTRUIDA'
                ,'size'         => 20
            ]
            ,'REFERENCIAANTERIOR' => [
                 'name'         => 'REFERENCIAANTERIOR'
                ,'description'  => 'REFERENCIA ANTERIOR'
                ,'size'         => 20
            ]
            ,'AREALOTECALCULO' => [
                 'name'         => 'AREADOLOTE'
                ,'description'  => 'AREA DO LOTE CONSIDERADA NO CALCULO'
                ,'size'         => 18
            ]
            ,'VALORM2CALCULO' => [
                 'name'         => 'VALORM2CALCULO'
                ,'description'  => 'VALOR DO METRO QUADRADO DO TERRENO DO CALCULO'
                ,'size'         => 18
            ]
        ];
    }
}
