<?php

namespace ECidade\Patrimonial\Protocolo\Processo\AlvaraOnline\Parser\Entity;

use \ParameterException;
use \BusinessException;
use \JSON;

class AlvaraAutonomo extends SolicitacaoAlvara
{
    #[\Override]
    public function toJSON($objetoSolicitacaoAlvara)
    {
        $objetoSolicitacaoAlvara = trim((string) $objetoSolicitacaoAlvara->metadados);
        $objetoSolicitacaoAlvara = JSON::create()->parse($objetoSolicitacaoAlvara);
        file_put_contents('tmp/solicitacaoAlvaraAutonomoJSON', print_r($objetoSolicitacaoAlvara, true));

        $solicitacao = (object) [
             "requerente"  => $this->objetoRequerente($objetoSolicitacaoAlvara)
            ,"responsavel" => $this->objetoDadosResponsavel($objetoSolicitacaoAlvara)
            ,"outros_dados"  => $this->objetoOutrosDados($objetoSolicitacaoAlvara)
            ,"endereco_municipio" => $this->objetoEndereco($objetoSolicitacaoAlvara)
            ,"atividades" => $this->objetoEmpresaAtividades($objetoSolicitacaoAlvara)
            ,"documentos"  => $this->objetoDocumentos($objetoSolicitacaoAlvara)
        ];

        return JSON::create()->stringify($solicitacao);
    }

    public function objetoDadosResponsavel($objetoSolicitacaoAlvara)
    {
        $responsavel = [
            "cpf" => (object) [
                "label" => "CPF"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_RESPONSAVEL,
                    'cpf'
                )
            ],
            "razao_social" => (object)  [
                "label" => "Razão Social"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_RESPONSAVEL,
                    'razao_social'
                )
            ],
            "tipo_empresa" => (object)  [
                "label" => "Tipo Empresa"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_RESPONSAVEL,
                    'tipo_empresa'
                )
            ],
            "porte" => (object)  [
                "label" => "Porte"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_RESPONSAVEL,
                    'porte'
                )
            ]
        ];

        return $responsavel;
    }

    public function objetoOutrosDados($objetoSolicitacaoAlvara)
    {
        $outrosDados = [
            "escritorio_contabil" => (object) [
                "label" => "Escritório Contábil"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::OUTROS_DADOS,
                    'escritorio_contabil'
                )
            ],
        ];

        return $outrosDados;
    }
}
