<?php

namespace ECidade\Patrimonial\Protocolo\Processo\ProcessoEletronico\Parser\Entity;

use \ParameterException;
use \BusinessException;
use \JSON;

class AlvaraMei extends SolicitacaoAlvara
{
    #[\Override]
    public function toJSON($objetoSolicitacaoAlvara)
    {
        $objetoSolicitacaoAlvara = trim((string) $objetoSolicitacaoAlvara->metadados);
        file_put_contents('tmp/solicitacaoAlvaraMEIProcessoEletronico.json', $objetoSolicitacaoAlvara);
        $objetoSolicitacaoAlvara = JSON::create()->parse($objetoSolicitacaoAlvara);

        $solicitacao = (object) [
             "requerente" => $this->objetoSolicitacaoRequerente($objetoSolicitacaoAlvara)
            ,"empresa"    => $this->objetoEmpresa($objetoSolicitacaoAlvara)
            ,"documentos" => $this->objetoSolicitacaoDocumentos($objetoSolicitacaoAlvara)
        ];

        file_put_contents(
            'tmp/solicitacaoAlvaraMEIProcessoEletronico_response.json',
            JSON::create()->stringify($solicitacao)
        );
        return JSON::create()->stringify($solicitacao);
    }

    public function objetoEmpresa($objetoSolicitacaoAlvara)
    {
        $empresa = (object) [
            "tipo_empresa" => (object) [
                 "label" => "Tipo de Empresa"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'tipo_empresa')
            ],
            "cpf_cnpj" => (object) [
                 "label" => "CPF/CNPJ"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'cpf_cnpj')
            ],
            "cpf" => (object) [
                "label" => "CPF"
            ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'cpf')
            ],
            "cnpj" => (object) [
                "label" => "CNPJ"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'cnpj')
            ],
            "razao_social" => (object) [
                 "label" => "Nome/Razão Social"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'razao_social')
            ],
            "nome_fantasia" => (object) [
                 "label" => "Nome Fantasia"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'nome_fantasia')
            ],
            "inscricao_estadual" => (object) [
                 "label" => "Inscrição Estadual"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA,
                    'inscricao_estadual'
                )
            ],
            "data_junta_comercial" => (object)  [
                "label" => "Data Junta"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::OUTROS_DADOS,
                    'data_junta_comercial'
                )
            ],
            "registro_junta" => (object)  [
                "label" => "Registro Junta"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::OUTROS_DADOS,
                    'registro_junta'
                )
            ]
            ,"endereco"        => $this->objetoMEIEndereco($objetoSolicitacaoAlvara)
            ,"outros_dados"    => $this->objetoMEIOutrosDados($objetoSolicitacaoAlvara)
            ,"atividades"      => $this->objetoSolicitacaoAtividades($objetoSolicitacaoAlvara)
            ,"responsavel_mei" => $this->objetoMEIResponsavel($objetoSolicitacaoAlvara)
        ];

        return (object) $empresa;
    }

    public function objetoMEIResponsavel($objetoSolicitacaoAlvara)
    {
        $responsaveis = [];
        $responsavelSolicitacao = new \stdClass();

        $responsaveisInformados  = $this->getInformacaoJSON(
            $objetoSolicitacaoAlvara,
            self::RESPONSAVEL_MEI,
            'resposta'
        );

        $secaoResponsavelMEICampos = $this->getInformacaoJSON(
            $objetoSolicitacaoAlvara,
            self::RESPONSAVEL_MEI,
            'campos'
        );

        $chavesEndereco = [
            'cep',
            'logradouro',
            'numero',
            'complemento',
            'bairro',
            'municipio',
            'estado',
            'pais'
        ];

        foreach ($responsaveisInformados as $key => $socio) {
            foreach ($secaoResponsavelMEICampos as $campoSocioResponsavel) {
                $value = $this->getResposta($campoSocioResponsavel, $socio->{$campoSocioResponsavel->nome});
                $label = $campoSocioResponsavel->label;
                $chave = $campoSocioResponsavel->nome;

                if (in_array($chave, $chavesEndereco) && isset($responsavelSolicitacao->endereco)) {
                    $responsavelSolicitacao->endereco->{$chave} = (object) [
                        "label" => $label
                        ,"value" => $value
                    ];
                } else {
                    $responsavelSolicitacao->{$chave} = (object) [
                        "label" => $label
                        ,"value" => $value
                    ];
                }
            }

            $responsaveis['responsavel_'. ($key+1)] = $responsavelSolicitacao;
        }

        return $responsaveis;
    }

    public function objetoMEIEndereco($objetoSolicitacaoAlvara)
    {
        $matricula  = (object)  [
            'codigo' => $this->getInformacaoJSON(
                $objetoSolicitacaoAlvara,
                self::DADOS_EMPRESA_ENDERECO,
                'matricula_imovel'
            ),
            'descricao' => $this->getInformacaoJSON(
                $objetoSolicitacaoAlvara,
                self::DADOS_EMPRESA_ENDERECO,
                'nome_proprietario'
            )
        ];

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
                 "label" => "CEP"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'cep')
            ],
            "bairro" => (object) [
                 "label" => "Bairro"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'bairro')
            ],
            "logradouro" => (object) [
                 "label" => "Logradouro"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA_ENDERECO,
                    'logradouro'
                )
            ],
            "numero" => (object) [
                 "label" => "Número"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'numero')
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
            "complemento" => (object) [
                 "label" => "Complemento"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA_ENDERECO,
                    'complemento'
                )
            ],
        ];
        $pontoReferencia = $this->getInformacaoJSON(
            $objetoSolicitacaoAlvara,
            self::DADOS_EMPRESA_ENDERECO,
            'ponto_referencia'
        );

        if (!empty($pontoReferencia)) {
            $endereco['ponto_referencia'] = (object) [
                 'label' => "Ponto de Referência"
                ,'value' => $pontoReferencia
            ];
        }

        return (object) $endereco;
    }

    public function objetoMEIOutrosDados($objetoSolicitacaoAlvara)
    {

        $outros_dados = [
            "escritorio_contabil" => (object) [
                 "label" => "Escritório Contábil"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::OUTROS_DADOS,
                    'escritorio_contabil'
                )
            ],
            "porte" => (object)  [
                "label" => "Porte"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'porte')
            ],
            "empregados" => (object)  [
                "label" => "Empregados"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'empregados')
            ],
            "area" => (object)  [
                "label" => "Area"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'area')
            ],
            "zona" => (object) [
                 "label" => "Zonas"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'zona')
            ],
        ];

        return (object) $outros_dados;
    }
}
