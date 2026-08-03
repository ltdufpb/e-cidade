<?php

namespace App\Domain\Patrimonial\Protocolo\Transformers\Processo\AndamentoPadrao;

use App\Domain\Patrimonial\Protocolo\Model\Processo\AndamentoPadrao\CamposDinamicos as CamposDinamicosModel;

use League\Fractal\TransformerAbstract;

class CamposDinamicos extends TransformerAbstract
{
    public function transform($campos)
    {

        if ($campos === null) {
            return $campos;
        }

        if ($campos instanceof CamposDinamicosModel) {
            return $this->parseResponseObject($campos);
        }

        $campos = collect($campos)->groupBy(fn($campo) => $campo->p110_sequencial)->toArray();

        return collect($campos)->flatMap(function ($campo, $index) {

            $campoAtual = (object)current($campo);
            $opcoes = [];

            if (!empty($campoAtual->defcampo) && !empty($campoAtual->defdescr)) {
                $opcoes = array_map(fn($opcao) => (object) [
                    'id'        => $opcao['defcampo'],
                    'descricao' => $opcao['defdescr']
                ], $campo);
            }

            return [
                $index => $this->parseResponseObject($campoAtual, $opcoes)
            ];
        });
    }

    protected function parseResponseObject($object, $opcoes = [])
    {
        $object->conteudo = preg_replace('/\(.*\)/', '', (string) $object->conteudo);

        switch (trim($object->conteudo)) {
            case 'bool':
            case 'boolean':
                $tipo = 'boolean';
                $opcoes = [
                    (object) [
                        'id' => 0,
                        'descricao' => "Não"
                    ],
                    (object) [
                        'id' => 1,
                        'descricao' => "Sim"
                    ],
                ];
                break;

            case 'date':
                $tipo = 'date';
                break;

            case 'text':
                $tipo = 'textarea';
                break;

            default:
                $tipo = 'text';
                break;
        }

        return [
            'codigo'           => $object->p110_sequencial,
            'idTipoProcesso'   => $object->p110_andpadrao_codigo,
            'ordem'            => $object->p110_andpadrao_ordem,
            'obrigatorio'      => (bool)$object->p110_obrigatorio,
            'campo' =>[
                'codcam'           => $object->p110_codcam,
                'nomecam'          => !empty($object->nomecam) ? trim((string) $object->nomecam) : '',
                'label'            => !empty($object->rotulo) ? $object->rotulo : '',
                'descricao'        => !empty($object->descricao) ? $object->descricao : '',
                'tipo'             => $tipo,
                'opcoes'           => $opcoes
            ]
        ];
    }
}
