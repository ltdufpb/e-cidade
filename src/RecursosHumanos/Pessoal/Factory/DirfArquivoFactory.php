<?php

namespace ECidade\RecursosHumanos\Pessoal\Factory;

/**
 * Class DirfFactory
 * @author Augusto Berwaldt <augusto.oliveira@dbseller.com.br>
 * @package ECidade\RecursosHumanos\Pessoal\Factory
 */
class DirfArquivoFactory
{
    /**
     * Metodo responsavel por crear Obejeto geracao do arquiv da dirf
     *
     * @param $year
     * @param $layout
     * @return \ArquivoDirf2012|\ArquivoDirf2015|\ArquivoDirf2018
     */
    public static function create($year, $layout)
    {
        $oDirfArq = match (true) {
            $year >= 2017 => new \ArquivoDirf2018($layout),
            $year < 2017 && $year > 2014 => new \ArquivoDirf2015($layout),
            default => new \ArquivoDirf2012($layout),
        };

        return $oDirfArq;
    }

}