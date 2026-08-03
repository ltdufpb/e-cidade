<?php

namespace App\Domain\Saude\TFD\Repositories;

use App\Domain\Core\Base\Repository\BaseRepository;

/**
 * Classe responsável por buscar os dados relacionados a tabela tfd_agendasaida
 * @package App\Domain\Saude\TFD\Repositories
 */
class AgendaSaidaRepository extends BaseRepository
{
    public function __construct($modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * Retorna as viagens realizadas
     * @param string|array|\Closure $where
     * @return \Illuminate\Database\Eloquent\Collection|\App\Domain\Saude\TFD\Model\AgendaSaida
     */
    public function getViagens($where = null, $ordem = '')
    {
        $ordem = match ($ordem) {
            1 => 'tf18_d_datasaida',
            2 => 've22_descr',
            default => 'tf03_c_descr',
        };

        $query = $this->newQuery()
            ->select('tfd_agendasaida.*')
            ->join('tfd_pedidotfd', 'tf01_i_codigo', '=', 'tf17_i_pedidotfd')
            ->join('tfd_situacaopedidotfd', 'tf28_i_pedidotfd', '=', 'tf01_i_codigo')
            ->join('tfd_passageiroveiculo', 'tf19_i_pedidotfd', '=', 'tf01_i_codigo')
            ->join('tfd_veiculodestino', 'tf18_i_codigo', '=', 'tf19_i_veiculodestino')
            ->join('tfd_destino', 'tf03_i_codigo', 'tf18_i_destino')
            ->join('veiculos', 've01_codigo', 'tf18_i_veiculo')
            ->join('veiccadmodelo', 've22_codigo', 've01_veiccadmodelo')
            ->where('tf28_i_situacao', '=', 2);

        if ($where != null) {
            $query = $query->where($where);
        }

        if ($ordem != 1) {
            $query = $query->groupBy($ordem)->orderBy($ordem);
        }

        return $query->groupBy(['tf17_i_codigo', 'tf18_d_datasaida'])->orderByDesc('tf18_d_datasaida')->get();
    }
}
