<?php

namespace App\Domain\Saude\TFD\Relatorios;

use ECidade\File\Csv\Dumper\Dumper;
use App\Domain\Saude\TFD\Contracts\ViagensPorMotorista;

/**
 * Classe responsável por montar um relatório, em CSV, com os dados agrupados por motorista
 * @package App\Domain\Saude\TFD\Relatorios
 */
class ViagensPorMotoristaCSV extends Dumper implements ViagensPorMotorista
{
    public function __construct(private readonly array $dados)
    {
        $this->setCsvControl(';', '"');
    }

    public function emitir($ordem)
    {
        $dadosImprimir = [$this->cabecalho($ordem)];

        foreach ($this->dados as $motorista) {
            foreach ($motorista->viagens as $viagem) {
                $dadosImprimir[] = $this->preparaDados($motorista, $viagem, $ordem);
            }
        }

        return $this->imprimir($dadosImprimir);
    }

    private function cabecalho($ordem)
    {
        return match ($ordem) {
            self::ORDEM_DATA => [
                'id',
                'nome',
                'data',
                'destino',
                'veiculo',
                'placa',
                'passageiros',
                'km'
            ],
            self::ORDEM_VEICULO => [
                'id',
                'nome',
                'veiculo',
                'destino',
                'data',
                'placa',
                'passageiros',
                'km'
            ],
            default => [
                'id',
                'nome',
                'destino',
                'data',
                'veiculo',
                'placa',
                'passageiros',
                'km'
            ],
        };
    }

    private function preparaDados($motorista, $viagem, $ordem)
    {
        return match ($ordem) {
            self::ORDEM_DATA => [
                $motorista->id,
                $motorista->nome,
                $viagem->data,
                $viagem->destino,
                $viagem->veiculo,
                $viagem->placa,
                $viagem->passageiros,
                $viagem->km
            ],
            self::ORDEM_VEICULO => [
                $motorista->id,
                $motorista->nome,
                $viagem->veiculo,
                $viagem->destino,
                $viagem->data,
                $viagem->placa,
                $viagem->passageiros,
                $viagem->km
            ],
            default => [
                $motorista->id,
                $motorista->nome,
                $viagem->destino,
                $viagem->data,
                $viagem->veiculo,
                $viagem->placa,
                $viagem->passageiros,
                $viagem->km
            ],
        };
    }

    private function imprimir($dados)
    {
        $fileName = 'tmp/viagens_por_motorista' . time() . '.csv';
        $this->dumpToFile($dados, $fileName);
        
        return [
            "name" => "Relatório de Viagens por Motorista",
            "path" => $fileName,
            'pathExterno' => ECIDADE_REQUEST_PATH . $fileName
        ];
    }
}
