<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \DateTime;
use \BusinessException;

final class TotalUnica extends Layout
{
    public function __construct ()
    {
        $this->fields = [
            'TTOTAL_UNICAS' => [
                'name'         => 'TOTUNICAS'
                ,'description' => 'TOTAL DE PARCELA UNICA'
                ,'size'        => 3
            ]
        ];
    }
}
