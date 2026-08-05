<?php


namespace ECidade\Educacao\Escola\Censo\SituacaoAluno\Dados;

use stdClass;

/**
 * Interface Dados
 * @package ECidade\Educacao\Escola\Censo\SituacaoAluno\Dados
 */
interface DadosInterface
{
    public function popular(stdClass $dados);
    public function validar($iCodigoEscolaINEP = null);
}
