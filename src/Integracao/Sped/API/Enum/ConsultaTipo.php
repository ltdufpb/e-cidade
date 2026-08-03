<?php

namespace ECidade\Integracao\Sped\API\Enum;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\Tipo;

final class ConsultaTipo
{
    const string ES_RETORNO_CONTRIBUICOES_SOCIAIS_TRABALHADOR = 'S5001';
    const string ES_RETORNO_IMPOSTO_RENDA_FONTE = 'S5002';
    const string ES_RETORNO_FGTS_TRABALHADOR = 'S5003';
    const string ES_RETORNO_CONTRIBUICOES_SOCIAIS_CONTRIBUINTE = 'S5011';
    const string ES_RETORNO_IRRF_CONTRIBUINTE = 'S5012';
    const string ES_RETORNO_FGTS_CONSOLIDADAS = 'S5013';

    const string EFD_RETORNO_TRIBUTO_POR_EVENTO = 'R5001';
    const string EFD_RETORNO_TRIBUTO_POR_PERIODO = 'R5011';

    public static function tipos($tipo = null, $integracao = null)
    {
        $tiposESocial = [
            self::ES_RETORNO_CONTRIBUICOES_SOCIAIS_TRABALHADOR => 'S-5001 - Informações das contribuições sociais por trabalhador',
            self::ES_RETORNO_IMPOSTO_RENDA_FONTE => 'S-5002 - Imposto de Renda Retido na Fonte',
            self::ES_RETORNO_FGTS_TRABALHADOR => 'S-5003 - Informações do FGTS por Trabalhador',
            self::ES_RETORNO_CONTRIBUICOES_SOCIAIS_CONTRIBUINTE => 'S-5011 - Informações das contribuições sociais consolidadas por contribuinte',
            self::ES_RETORNO_IRRF_CONTRIBUINTE => 'S-5012 - Informações do IRRF consolidadas por contribuinte',
            self::ES_RETORNO_FGTS_CONSOLIDADAS => 'S-5013 - Informações do FGTS consolidadas por contribuinte'
        ];
        $tiposEFD = [
            self::EFD_RETORNO_TRIBUTO_POR_EVENTO => 'R-5001 - Informações de bases e tributos por evento',
            self::EFD_RETORNO_TRIBUTO_POR_PERIODO => 'R-5011 - Informações de bases e tributos consolidadas por período de apuração'
        ];
        $tipos = [];
        if (!empty($integracao)) {
            if ($integracao == Tipo::EFD_REINF) {
                $tipos = $tiposEFD;
            } else if ($integracao == Tipo::ESOCIAL) {
                $tipos = $tiposESocial;
            }
        }
        if (count($tipos) == 0) {
            $tipos = array_merge($tiposESocial, $tiposEFD);
        }

        if (!empty($tipo) && !empty($tipos[$tipo])) {
            $tipos = $tipos[$tipo];
        }

        return $tipos;
    }

    public static function getDeParaEventosRetorno($strRetorno)
    {
        return match ($strRetorno) {
            'S-5001', 'S-5003' => 'S-1200, S-2299, S-2399',
            'S-5002' => 'S-1210',
            'S-5011', 'S-5012', 'S-5013' => 'S-1295, S-1299',
            'R-5011' => 'R-2099',
            'R-5001' => 'R-2010, R-2020, R-2030, R-2040, R-2050, R-2060, R-3010',
            default => false,
        };
    }
}
