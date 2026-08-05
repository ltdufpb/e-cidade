<?php

namespace ECidade\Configuracao\Formulario\Arquivo;

use Avaliacao;

interface DumperInterface
{

  /**
     * @param Avaliacao $avaliacao
     */
    public function __construct(Avaliacao $avaliacao);

  /**
   * @return string
   */
    public function dump();
}
