<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \BusinessException;

final class Localizacao extends Layout
{
    public function __construct ()
    {
        $this->fields = [
            'SEQUENCIALSETORLOCALIZACAO' => [
                'name'            => 'SEQUENCIALSETORLOCALIZACAO'
                ,'description'     => 'SEQUENCIAL DO SETOR DE LOCALIZACAO'
                ,'size'            => 10
            ]
            ,'CODIGOPROPRIOSETORLOCALIZACAO' => [
                'name'            => 'CODPROPRIOSETORLOCALIZACAO'
                ,'description'     => 'CODIGO PROPRIO DO SETOR DE LOCALIZACAO'
                ,'size'            => 10
            ]
            ,'DESCRICAOSETORLOCALIZACAO' => [
                'name'            => 'DESCRSETORLOCALIZACAO'
                ,'description'     => 'DESCRICAO DO SETOR DE LOCALIZACAO'
                ,'size'            => 40
            ]
            ,'QUADRALOCALIZACAO' => [
                'name'            => 'QUADRALOCALIZACAO'
                ,'description'     => 'QUADRA DE LOCALIZACAO'
                ,'size'            => 10
            ]
            ,'LOTELOCALIZACAO' => [
                'name'            => 'LOTELOCALIZACAO'
                ,'description'     => 'LOTE DE LOCALIZACAO'
                ,'size'            => 10
            ]
        ];
    }
}
