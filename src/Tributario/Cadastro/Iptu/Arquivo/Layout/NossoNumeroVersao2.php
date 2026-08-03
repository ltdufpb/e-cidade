<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \BusinessException;

final class NossoNumeroVersao2 extends LayoutParcelas
{
    public function __construct ($parcelas)
    {
        $this->fields = [
            'NOSSONUMEROPARCELAVERSAO2'  => [
                'name'           => 'NOSSO_NUMERO_VERSAO2_PARC{$nroParcela}'
                ,'description'   => 'NOSSO NUMERO VERSAO 2 PARCELA{$nroParcela}'
                ,'size'          => 17
            ]
            ,'DIGITONOSSONUMEROPARCELAVERSAO2'  => [
                'name'           => 'DG_NOSSO_NUMERO_VERSAO2_PARC{$nroParcela}'
                ,'description'   => 'DIGITO DO NOSSO NUMERO VERSAO 2 PARCELA{$nroParcela}'
                ,'size'          => 1
            ]
        ];

        parent::__construct($parcelas);
    }
}
