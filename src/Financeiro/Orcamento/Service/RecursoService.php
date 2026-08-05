<?php


namespace ECidade\Financeiro\Orcamento\Service;

use ECidade\Financeiro\Orcamento\Recurso\Recurso;
use Exception;
use DotacaoRepository;
use RecursoRepository;

class RecursoService
{

    /**
     * @param $codigoDotacao
     * @param $ano
     * @param $complemento
     * @return Recurso
     * @throws Exception
     */
    public static function identificaRecursoComplemento($codigoDotacao, $ano, $complemento)
    {
        $dotacao = DotacaoRepository::getDotacaoPorCodigoAno($codigoDotacao, $ano);
        $recursoDotacao = RecursoRepository::getRecursoPorCodigo($dotacao->getRecurso());
        $recurso = RecursoRepository::getRecursoPorCodigoRecursoAndComplemento(
            $recursoDotacao->getRecurso(),
            $complemento
        );
        return $recurso;
    }
}
