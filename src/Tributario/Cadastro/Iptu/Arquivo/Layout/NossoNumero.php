<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \BusinessException;

final class NossoNumero extends LayoutParcelas
{
    public function __construct ($parcelas)
    {
        $this->fields = [
            'NOSSONUMEROPARCELA'  => [
                'name'           => 'NOSSO_NUMERO_PARC{$nroParcela}'
                ,'description'   => 'NOSSO NUMERO PARCELA {$nroParcela}'
                ,'size'          => 10
            ]
            ,'DIGITONOSSONUMEROPARCELA'  => [
                'name'           => 'DG_NOSSO_NUMERO_PARC{$nroParcela}'
                ,'description'   => 'DIGITO DO NOSSO NUMERO PARCELA {$nroParcela}'
                ,'size'          => 1
            ]
        ];

        parent::__construct($parcelas);
    }
}
