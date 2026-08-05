<?php

namespace ECidade\Patrimonial\Protocolo\Processo\AlvaraOnline\Parser\Entity;

use \JSON;

class AlvaraMei extends SolicitacaoAlvara
{
    public function toJSON($objetoSolicitacaoAlvara)
    {
        $objetoSolicitacaoAlvara = trim((string) $objetoSolicitacaoAlvara->metadados);
        $objetoSolicitacaoAlvara = JSON::create()->parse($objetoSolicitacaoAlvara);
        file_put_contents('tmp/solicitacaoAlvaraMeiJSON', print_r($objetoSolicitacaoAlvara, true));

        $solicitacao = (object) [
             "requerente" => $this->objetoRequerente($objetoSolicitacaoAlvara)
            ,"empresa"    => $this->objetoEmpresa($objetoSolicitacaoAlvara)
            ,"documentos" => $this->objetoDocumentos($objetoSolicitacaoAlvara)
        ];

        return JSON::create()->stringify($solicitacao);
    }

    public function objetoEmpresa($objetoSolicitacaoAlvara)
    {
        $empresa = [
            "tipo_empresa" => (object) [
                 "label" => "Tipo de Empresa"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'tipo_empresa')
            ],
            "cnpj" => (object) [
                 "label" => "CPF/CNPJ"
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
            ]
            ,"data_junta_comercial" => (object)  [
                "label" => "Data Junta"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA,
                    'data_junta_comercial'
                )
            ],
            "registro_junta" => (object)  [
                "label" => "Registro Junta"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA,
                    'registro_junta'
                )
            ]
            ,"endereco"        => $this->objetoEmpresaEndereco($objetoSolicitacaoAlvara)
            ,"outros_dados"    => $this->objetoEmpresaOutrosDados($objetoSolicitacaoAlvara)
            ,"atividades"      => $this->objetoEmpresaAtividades($objetoSolicitacaoAlvara)
            ,"responsavel_mei" => $this->objetoEmpresaResponsavelMei($objetoSolicitacaoAlvara)
        ];

        return (object) $empresa;
    }

    public function objetoEmpresaResponsavelMei($objetoSolicitacaoAlvara)
    {
        $responsavel = null;

        if (isset($objetoSolicitacaoAlvara->socios)) {
            foreach ($objetoSolicitacaoAlvara->socios as $key => $socio) {
                $socioSolicitacao = (object) [
                    "cpf" => (object) [
                         "label" => "CPF"
                        ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'cpf')
                    ],
                    "tipo_socio" => (object) [
                         "label" => "Tipo de Sócio"
                        ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'tipo_socio')
                    ],
                    "valor_capital" => (object) [
                         "label" => "Valor do Capital"
                        ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'valor_capital')
                    ],
                    "nome" => (object) [
                         "label" => "Nome"
                        ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'nome')
                    ],
                    "nascimento" => (object) [
                         "label" => "Data de Nascimento"
                        ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'nascimento')
                    ],
                    "sexo" => (object) [
                         "label" => "Sexo"
                        ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'sexo')
                    ],
                    "telefone" => (object) [
                         "label" => "Telefone"
                        ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'telefone')
                    ],
                    "celular" => (object) [
                         "label" => "Celular"
                        ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'celular')
                    ],
                    "estado_civil" => (object) [
                         "label" => "Estado Civil"
                        ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'estado_civil')
                    ],
                    "nacionalidade" => (object) [
                         "label" => "Nacionalidade"
                        ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'nacionalidade')
                    ],
                    "endereco" => (object) [
                        "cep" => (object) [
                             "label" => "CEP"
                            ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'cep')
                        ],
                        "logradouro" => (object) [
                             "label" => "Endereço"
                            ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'logradouro')
                        ],
                        "numero" => (object) [
                             "label" => "Número"
                            ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'numero')
                        ],
                        "complemento" => (object) [
                             "label" => "Compl"
                            ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'complemento')
                        ],
                        "bairro" => (object) [
                             "label" => "Bairro"
                            ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'bairro')
                        ],
                        "municipio" => (object) [
                             "label" => "Município"
                            ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'municipio')
                        ],
                        "estado" => (object) [
                             "label" => "Estado"
                            ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'estado')
                        ],
                        "pais" => (object) [
                             "label" => "País"
                            ,"value" => $this->getInformacaoJSON($socio, self::SOCIOS, 'pais')
                        ],
                    ],
                ];

                $responsavel = (object)$socioSolicitacao;
            }
        }

        return $responsavel;
    }
}
