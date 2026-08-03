<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \BusinessException;

final class Banco extends Layout
{
    public function __construct()
    {
        $this->fields = [
            'TOTALBOMPAGADOR'  => [
                 'name'        => 'VALTOTALBOMPAGADOR'
                ,'description' => 'VALOR TOTAL DO BOM PAGADOR'
                ,'size'        => 18
            ],
            'AGENCIA'          => [
                 'name'        => 'AGENCIA'
                ,'description' => 'AGENCIA DO CONVENIO'
                ,'size'        => 5
            ],
            'DIGITOAGENCIA'    => [
                 'name'        => 'DG_AGENCIA'
                ,'description' => 'DIGITO DA AGENCIA'
                ,'size'        => 1
            ],
            'OPERACAO'         => [
                 'name'        => 'OPERACAO'
                ,'description' => 'OPERACAO DO CONVENIO'
                ,'size'        => 3
            ],
            'CEDENTE'          => [
                 'name'        => 'CEDENTE'
                ,'description' => 'CEDENTE DO CONVENIO'
                ,'size'        => 6
            ],
            'DIGITOCEDENTE'    => [
                 'name'        => 'DG_CEDENTE'
                ,'description' => 'DIGITO DO CEDENTE'
                ,'size'        => 1
            ],
            'CARTEIRA'         => [
                 'name'        => 'CARTEIRA'
                ,'description' => 'CARTEIRA DO CONVENIO'
                ,'size'        => 6
            ],
            'CONVENIO'         => [
                 'name'        => 'CONVENIO'
                ,'description' => 'CONVENIO'
                ,'size'        => 4
            ],
            'DATAPROCESSAMENTO'=> [
                 'name'        => 'DATA_PROCESSAMENTO'
                ,'description' => 'DATA DO PROCESSAMENTO'
                ,'size'        => 10
            ],
            'DESCRICAOCONVENIO'=> [
                 'name'        => 'DESCRICAO_CONVENIO'
                ,'description' => 'DESCRICAO DO CONVENIO'
                ,'size'        => 50
            ],
        ];
    }
}
