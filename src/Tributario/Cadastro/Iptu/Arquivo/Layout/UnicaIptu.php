<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

final class UnicaIptu extends Layout
{
    #[\Override]
    public function get($counter, $unica1 = "", $unica2 = "", $unica3 = "")
    {
        $this->fields = [
            'CODARREIPTU' => [
                'name' => 'CODARREIPTU',
                'description' => 'CODIGO DE ARRECADACAO DO DEBITO DE IPTU',
                'size' => 11
            ],
            'VLRCALCIPTU' => [
                'name' => 'VLRCALCIPTU',
                'description' => 'VALOR DO CALCULO DE IPTU',
                'size' => 11
            ],
            'VLRDESCUNICAIPTU1' => [
                'name' => 'VLRDESCUNICA{$unica1}IPTU',
                'description' => 'VALOR DE DESCONTO NA UNICA DE IPTU {$unica1}',
                'size' => 11
            ],
            'ALIQDESCUNICAIPTU1' => [
                'name' => 'ALIQDESCUNICA{$unica1}IPTU',
                'description' => 'ALIQUOTA DE DESCONTO NA UNICA DE IPTU {$unica1}',
                'size' => 3
            ],
            'VLRUNICAIPTU1' => [
                'name' => 'VLRUNICA{$unica1}IPTU',
                'description' => 'VALOR A SER PAGO DE UNICA DE IPTU {$unica1}',
                'size' => 11
            ],
            'VLRDESCUNICAIPTU2' => [
                'name' => 'VLRDESCUNICA{$unica2}IPTU',
                'description' => 'VALOR DE DESCONTO NA UNICA DE IPTU {$unica2}',
                'size' => 11
            ],
            'ALIQDESCUNICAIPTU2' => [
                'name' => 'ALIQDESCUNICA{$unica2}IPTU',
                'description' => 'ALIQUOTA DE DESCONTO NA UNICA DE IPTU {$unica2}',
                'size' => 3
            ],
            'VLRUNICAIPTU2' => [
                'name' => 'VLRUNICA{$unica2}IPTU',
                'description' => 'VALOR A SER PAGO DE UNICA DE IPTU {$unica2}',
                'size' => 11
            ],
            'VLRDESCUNICAIPTU3' => [
                'name' => 'VLRDESCUNICA{$unica3}IPTU',
                'description' => 'VALOR DE DESCONTO NA UNICA DE IPTU {$unica3}',
                'size' => 11
            ],
            'ALIQDESCUNICAIPTU3' => [
                'name' => 'ALIQDESCUNICA{$unica3}IPTU',
                'description' => 'ALIQUOTA DE DESCONTO NA UNICA DE IPTU {$unica3}',
                'size' => 3
            ],
            'VLRUNICAIPTU3' => [
                'name' => 'VLRUNICA{$unica3}IPTU',
                'description' => 'VALOR A SER PAGO DE UNICA DE IPTU {$unica3}',
                'size' => 11
            ]
        ];
    }
}
