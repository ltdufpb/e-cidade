<?php

namespace ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\RCB80C\Entity;

use ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\Entity\Detalhe as DetalhePadrao;

final class Detalhe extends DetalhePadrao
{
    const string RETORNO_REGISTRO = 'RETORNOREGISTRO';
    const string RCB80C           = 'RCB80C';

    private $retornoRegistro;
    private $numnov;

    /**
     * @return mixed
     */
    public function getRetornoRegistro()
    {
        return $this->retornoRegistro;
    }

    /**
     * @param mixed $retornoRegistro
     */
    public function setRetornoRegistro($retornoRegistro)
    {
        $this->retornoRegistro = $retornoRegistro;
    }

    /**
     * @return string
     */
    #[\Override]
    public function getTipoArquivo()
    {
        return self::RCB80C;
    }

    public function setNumnov($numnov)
    {
        $this->numnov = $numnov;
    }

    public function getNumnov()
    {
        return $this->numnov;
    }
}
