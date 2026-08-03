<?php

namespace ECidade\Financeiro\Contabilidade\Exportacao\PADRS\Campos\TipoInstrumentoContratual;

class TipoInstrumentoContratualEstrategia
{
    public function __construct(protected $lancamento)
    {
    }

    public function getValor()
    {
        return '';
    }
}
