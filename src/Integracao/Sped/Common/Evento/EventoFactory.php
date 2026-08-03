<?php

namespace ECidade\Integracao\Sped\Common\Evento;

use ECidade\Integracao\Sped\EFDReinf\Evento\R1000;
use ECidade\Integracao\Sped\EFDReinf\Evento\R1070;
use ECidade\Integracao\Sped\EFDReinf\Evento\R2010;
use ECidade\Integracao\Sped\EFDReinf\Evento\R2020;
use ECidade\Integracao\Sped\EFDReinf\Evento\R2099;
use ECidade\Integracao\Sped\EFDReinf\Evento\R9000;
use ECidade\Integracao\Sped\ESocial\Evento\S1295;
use ECidade\Integracao\Sped\ESocial\Evento\S1299;
use ECidade\RecursosHumanos\ESocial\Model\Formulario\Tipo;
use Exception;

/**
 * Class EventoFactory
 * @package ECidade\Integracao\Sped\Common\Evento
 */
class EventoFactory
{
    /**
     * @param $tipo
     * @return EventoAbstract
     * @throws Exception
     */
    public static function getInstance($tipo)
    {
        return match ($tipo) {
            Tipo::CONTRIBUINTE => new R1000(),
            Tipo::EFD_PROCESSOS => new R1070(),
            Tipo::TOTALIZACAO_PAGAMENTOS_CONTINGENCIA => new S1295(),
            Tipo::FECHAMENTO_EVENTOS_PERIODICOS => new S1299(),
            Tipo::EFD_RETENCOES_SERVICOS_TOMADOS => new R2010(),
            Tipo::EFD_SERVICOS_PRESTADOS => new R2020(),
            Tipo::EFD_FECHAMENTO_PERIODICOS => new R2099(),
            Tipo::EFD_EXCLUSAO_EVENTOS => new R9000(),
            default => throw new Exception("Evento não encontrado."),
        };
    }
}
