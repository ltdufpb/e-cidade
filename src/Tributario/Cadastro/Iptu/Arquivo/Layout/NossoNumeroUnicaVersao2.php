<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \BusinessException;

final class NossoNumeroUnicaVersao2 extends LayoutParcelas
{
    public function __construct ($parcelas)
    {
        $this->fields = [
            'NOSSONUMEROUNICAVERSAO2'  => [
                'name'           => 'NOSSO_NUMERO_VERSAO2_UNICA{$nroParcela}'
                ,'description'   => 'NOSSO NUMERO VERSAO 2 UNICA {$nroParcela}'
                ,'size'          => 17
            ]
            ,'DIGITONOSSONUMEROUNICAVERSAO2'  => [
                'name'           => 'DG_NOSSO_NUMERO_VERSAO2_UNICA{$nroParcela}'
                ,'description'   => 'DIGITO DO NOSSO NUMERO VERSAO 2 UNICA {$nroParcela}'
                ,'size'          => 1
            ]
        ];

        parent::__construct($parcelas);
    }
}
