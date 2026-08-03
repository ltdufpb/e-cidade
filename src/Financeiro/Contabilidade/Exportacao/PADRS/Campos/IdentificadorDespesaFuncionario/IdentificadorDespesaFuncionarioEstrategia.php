<?php

namespace ECidade\Financeiro\Contabilidade\Exportacao\PADRS\Campos\IdentificadorDespesaFuncionario;

class IdentificadorDespesaFuncionarioEstrategia
{
    public function __construct(protected $empenho)
    {
    }

    public function getValor()
    {
        return '';
    }

    public function setValor($valor)
    {
    }

    public function getDescricao()
    {
        return '';
    }
}
