<?php

namespace ECidade\Patrimonial\Protocolo\Processo\ProcessoEletronico\Parser\Entity;

use stdClass;
use \JSON;

class AlvaraEmpresa extends SolicitacaoAlvara
{
    public function toJSON($objetoSolicitacaoAlvara)
    {
        $objetoSolicitacaoAlvara = trim((string) $objetoSolicitacaoAlvara->metadados);
        file_put_contents('tmp/solicitacaoAlvaraEmpresaProcessoEletronico.json', $objetoSolicitacaoAlvara);
        $objetoSolicitacaoAlvara = JSON::create()->parse($objetoSolicitacaoAlvara);

        $solicitacao = (object) [
             "requerente" => $this->objetoSolicitacaoRequerente($objetoSolicitacaoAlvara)
            ,"empresa"    => $this->objetoEmpresa($objetoSolicitacaoAlvara)
            ,"documentos" => $this->objetoSolicitacaoDocumentos($objetoSolicitacaoAlvara)
        ];

        file_put_contents(
            'tmp/solicitacaoAlvaraEmpresaProcessoEletronico_response.json',
            JSON::create()->stringify($solicitacao)
        );
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
            ,"endereco"     => $this->objetoEmpresaEndereco($objetoSolicitacaoAlvara)
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
            ],
            "protocolo_junta" => (object)  [
                "label" => "Protocolo Junta"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA,
                    'protocolo_junta'
                )
            ],
            "email" => (object)  [
                "label" => "E-mail"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA,
                    'emailempresa'
                )
            ]
            ,"outros_dados" => $this->objetoEmpresaOutrosDados($objetoSolicitacaoAlvara)
            ,"simples"      => $this->objetoEmpresaSimples($objetoSolicitacaoAlvara)
            ,"atividades"   => $this->objetoSolicitacaoAtividades($objetoSolicitacaoAlvara)
            ,"socios"       => $this->objetoEmpresaSocios($objetoSolicitacaoAlvara)
        ];

        return (object) $empresa;
    }

    public function objetoEmpresaOutrosDados($objetoSolicitacaoAlvara)
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
            "porte" => (object) [
                 "label" => "Porte"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'porte')
            ],
            "empregados" => (object) [
                 "label" => "Empregados"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'empregados')
            ],
            "area" => (object) [
                 "label" => "Área"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'area')
            ],
            "zona" => (object) [
                 "label" => "Zona"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'zona')
            ],
        ];

        return (object) $outros_dados;
    }

    public function objetoEmpresaSimples($objetoSolicitacaoAlvara)
    {
        $optanteSimples = $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA, 'optante_simples');

        $simples = [
            "optante_simples" => (object) [
                 "label" => "Optante Simples"
                ,"value" => $optanteSimples
            ],
        ];

        if ((int)$optanteSimples->codigo === 1) { //Significa que eh optante pelo simples
            $simples['data_opcao_simples'] = (object) [
                 "label" => "Data da Opção pelo Simples"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA,
                    'data_opcao_simples'
                )
            ];

            $categoriaSimples = $this->getInformacaoJSON(
                $objetoSolicitacaoAlvara,
                self::DADOS_EMPRESA,
                'categoria_simples'
            );
            $simples['categoria_simples']  = (object) [
                 "label" => "Categoria no Simples"
                ,"value" => $categoriaSimples
            ];
        }

        return (object) $simples;
    }

    public function objetoEmpresaSocios($objetoSolicitacaoAlvara)
    {
        $socios = [];

        $sociosInformados  = $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::SOCIOS, 'resposta');
        $secaoSociosCampos = $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::SOCIOS, 'campos');

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

        foreach ($sociosInformados as $key => $socio) {
            $socioSolicitacao = new stdClass();

            foreach ($secaoSociosCampos as $campoSocio) {
                $value = $this->getResposta($campoSocio, $socio->{$campoSocio->nome});
                $label = $campoSocio->label;
                $chave = $campoSocio->nome;

                if (in_array($chave, $chavesEndereco) && isset($socioSolicitacao->endereco)) {
                    $socioSolicitacao->endereco->{$chave} = (object) [
                        "label" => $label
                        ,"value" => $value
                    ];
                } else {
                    $socioSolicitacao->{$chave} = (object) [
                        "label" => $label
                        ,"value" => $value
                    ];
                }
            }

            $socios['socio_'. ($key+1)] = $socioSolicitacao;
        }

        return $socios;
    }

    public function objetoEmpresaEndereco($objetoSolicitacaoAlvara)
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
            "estado" => (object) [
                "label" => "Estado"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'estado')
            ],
            "municipio" => (object) [
                "label" => "Municipio"
                ,"value" => $this->getInformacaoJSON(
                    $objetoSolicitacaoAlvara,
                    self::DADOS_EMPRESA_ENDERECO,
                    'municipio'
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
            "numero" => (object) [
                 "label" => "Número"
                ,"value" => $this->getInformacaoJSON($objetoSolicitacaoAlvara, self::DADOS_EMPRESA_ENDERECO, 'numero')
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

        if (!empty($pontoReferencia) && !empty($pontoReferencia->codigo)) {
            $endereco['ponto_referencia'] = (object) [
                 'label' => "Ponto de Referência"
                ,'value' => $pontoReferencia
            ];
        }

        return (object) $endereco;
    }
}
