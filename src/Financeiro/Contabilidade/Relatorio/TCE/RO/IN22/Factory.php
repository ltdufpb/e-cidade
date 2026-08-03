<?php
/**
 * Created by PhpStorm.
 * User: robson
 * Date: 2020-02-05
 * Time: 16:40
 */

namespace ECidade\Financeiro\Contabilidade\Relatorio\TCE\RO\IN22;

class Factory
{

    /**
     * @param $codigoRelatorio
     * @param $ano
     * @param $periodo
     * @param $instituicoes
     * @param $usuario
     * @return In22
     * @throws \Exception
     */
    public static function getInstance($codigoRelatorio, $ano, $periodo, $instituicoes, $usuario)
    {
        $anexo = null;
        $anexo = match ($codigoRelatorio) {
            Anexo1::CODIGO_RELATORIO => new Anexo1(),
            Anexo2::CODIGO_RELATORIO => new Anexo2(),
            Anexo3::CODIGO_RELATORIO => new Anexo3(),
            Anexo4::CODIGO_RELATORIO => new Anexo4(),
            Anexo5::CODIGO_RELATORIO => new Anexo5(),
            Anexo6::CODIGO_RELATORIO => new Anexo6(),
            Anexo7::CODIGO_RELATORIO => new Anexo7(),
            Anexo8::CODIGO_RELATORIO => new Anexo8(),
            Anexo9::CODIGO_RELATORIO => new Anexo9(),
            Anexo10::CODIGO_RELATORIO => new Anexo10(),
            Anexo10A::CODIGO_RELATORIO => new Anexo10A(),
            Anexo11::CODIGO_RELATORIO => new Anexo11(),
            Anexo11A::CODIGO_RELATORIO => new Anexo11A(),
            Anexo11B::CODIGO_RELATORIO => new Anexo11B(),
            Anexo11C::CODIGO_RELATORIO => new Anexo11C(),
            Anexo12::CODIGO_RELATORIO => new Anexo12(),
            Anexo13::CODIGO_RELATORIO => new Anexo13(),
            Anexo13A::CODIGO_RELATORIO => new Anexo13A(),
            Anexo14::CODIGO_RELATORIO => new Anexo14(),
            Anexo15::CODIGO_RELATORIO => new Anexo15(),
            Anexo16::CODIGO_RELATORIO => new Anexo16(),
            default => throw new \Exception('Relatório não encontrado.'),
        };

        $anexo->setAno($ano);
        $anexo->setPeriodo($periodo);
        $anexo->setInstituicoes($instituicoes);
        $anexo->setUsuario($usuario);
        return $anexo;
    }
}
