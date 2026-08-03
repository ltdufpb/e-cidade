<?php


namespace ECidade\Educacao\Escola\Factory;

use ECidade\Educacao\Escola\FormulaAvaliacao\AprovacaoTodosPeriodos;
use ECidade\Educacao\Escola\FormulaAvaliacao\Atribuido;
use ECidade\Educacao\Escola\FormulaAvaliacao\Formula;
use ECidade\Educacao\Escola\FormulaAvaliacao\MaiorNivel;
use ECidade\Educacao\Escola\FormulaAvaliacao\MediaAritmetica;
use ECidade\Educacao\Escola\FormulaAvaliacao\Soma;
use ECidade\Enum\Educacao\Escola\FormaObtencaoEnum;
use Exception;

/**
 * Class FormulaCalculoAreaFactory
 * @package ECidade\Educacao\Escola\Factory
 */
class FormulaCalculoAreaFactory
{
    /**
     * @param FormaObtencaoEnum $formaObtencao
     * @return Formula
     * @throws Exception
     */
    public static function get(FormaObtencaoEnum $formaObtencao)
    {
        return match ($formaObtencao->value()) {
            FormaObtencaoEnum::ATRIBUIDO => new Atribuido(),
            FormaObtencaoEnum::SOMA => new Soma(),
            FormaObtencaoEnum::MEDIA_ARITMETICA => new MediaAritmetica(),
            FormaObtencaoEnum::MAIOR_NIVEL => new MaiorNivel(),
            FormaObtencaoEnum::APROVACAO_PERIODOS => new AprovacaoTodosPeriodos(),
            default => throw new Exception("Fórmula de cálculo da área de conhecimento não implementada."),
        };
    }
}
