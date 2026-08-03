<?php

namespace ECidade\Patrimonial\Protocolo\Processo\ProcessoEletronico\Parser\Entity;

use \ParameterException;
use \BusinessException;
use \JSON;

class AlvaraAutonomo extends SolicitacaoAlvara
{
    #[\Override]
    public function toJSON($objetoSolicitacaoAlvara)
    {
        $objetoSolicitacaoAlvara = trim((string) $objetoSolicitacaoAlvara->metadados);
        file_put_contents('tmp/solicitacaoAlvaraAutonomoProcessoEletronico.json', $objetoSolicitacaoAlvara);
        $objetoSolicitacaoAlvara = JSON::create()->parse($objetoSolicitacaoAlvara);

        $solicitacao = (object) [
             "requerente"  => $this->objetoSolicitacaoRequerente($objetoSolicitacaoAlvara)
            ,"responsavel" => $this->objetoDadosResponsavel($objetoSolicitacaoAlvara)
            ,"outros_dados"  => $this->objetoOutrosDados($objetoSolicitacaoAlvara)
            ,"endereco_municipio" => $this->objetoEndereco($objetoSolicitacaoAlvara)
            ,"atividades" => $this->objetoSolicitacaoAtividades($objetoSolicitacaoAlvara)
            ,"documentos"  => $this->objetoSolicitacaoDocumentos($objetoSolicitacaoAlvara)
        ];

        file_put_contents(
            'tmp/solicitacaoAlvaraAutonomoProcessoEletronico_response.json',
            JSON::create()->stringify($solicitacao)
        );
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
            "data_junta_comercial" => (object) [
                "label" => "Data Junta Comercial", "value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::OUTROS_DADOS,
                    'data_junta_comercial'
                )
            ],
            "registro_junta" => (object) [
                "label" => "Registro Junta Comercial", "value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::OUTROS_DADOS,
                    'registro_junta'
                )
            ],
        ];

        return $outrosDados;
    }

    public function objetoEndereco($objetoSolicitacaoAlvara)
    {
        $matricula  = $this->getInformacaoJSON(
            $objetoSolicitacaoAlvara,
            self::DADOS_EMPRESA_ENDERECO,
            'matricula_imovel'
        );

        $aux = $this->getInformacaoJSON(
            $objetoSolicitacaoAlvara,
            self::DADOS_EMPRESA_ENDERECO,
            'nome_proprietario'
        );

        if (!is_null($aux) && $aux != '') {
            $matricula .= " - ";
            $matricula .= $aux;
        }

        $endereco = [
            "matricula" => (object) [
                 "label" => "Matrícula"
                ,"value" => $matricula
            ],
            "telefone" => (object) [
                 "label" => "Telefone"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'telefone')
            ],
            "celular" => (object) [
                 "label" => "Celular"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'celular')
            ],
            "cep" => (object) [
                "label" => "CEP", "value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA_ENDERECO,
                    'cep'
                )
            ],
            "bairro" => (object) [
                "label" => "Bairro", "value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA_ENDERECO,
                    'bairro'
                )
            ],
            "logradouro" => (object) [
                 "label" => "Logradouro"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA_ENDERECO,
                    'logradouro'
                )
            ],
            "municipio" => (object) [
                "label" => "Municipio"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA_ENDERECO,
                    'municipio'
                )
            ],
            "estado" => (object) [
                "label" => "Estado"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'estado')
            ],
            "numero" => (object) [
                 "label" => "Número"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'numero')
            ],
            "complemento" => (object) [
                "label" => "Complemento", "value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA_ENDERECO,
                    'complemento'
                )
            ],
            "zona" => (object) [
                 "label" => "Zona"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'zona')
            ],
            "ponto_referencia" => (object) [
                 "label" => "Pronto de Referencia"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA_ENDERECO,
                    'ponto_referencia'
                )
            ]
        ];

        return (object) $endereco;
    }
}
