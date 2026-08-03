<?php

namespace App\Domain\SIM\Controllers;

use App\Domain\Patrimonial\Protocolo\Model\Cgm;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PessoasController extends Controller
{
    private $queryCgm;

    public function __construct()
    {
        $this->queryCgm = Cgm::query()
            ->orderBy('z01_nomecomple')
            ->limit(200);
    }

    /**
     * @param $nome
     * @param int $tp_pesquisa
     * @return JsonResponse
     * @throws Exception
     */
    public function pesquisaPorNome($nome, $tp_pesquisa = 0)
    {
        $nome = mb_convert_encoding($nome, 'ISO-8859-1');

        if (strlen($nome) < 2) {
            return response()->json([
                "error" => true,
                "message" => mb_convert_encoding("Nome deve ter no mínimo 2 caracteres", 'UTF-8', 'ISO-8859-1'),
                "status" => 400,
            ], 400);
        }

        match ($tp_pesquisa) {
            1 => $this->queryCgm->whereRaw("to_ascii(z01_nomecomple) ilike to_ascii('{$nome}%')"),
            2 => $this->queryCgm->whereRaw("to_ascii(z01_nomecomple) ilike to_ascii('%{$nome}%')"),
            default => $this->queryCgm->whereRaw("z01_nomecomple = '{$nome}'"),
        };
        $this->queryCgm->whereRaw("length(z01_cgccpf) <= 11");

        $response = $this->makeResponse($this->queryCgm->get());

        return response()->json($response);
    }

    public function pesquisaPorCpf($cpf)
    {
        $this->queryCgm->whereRaw("z01_cgccpf = '{$cpf}'");
        $response = $this->makeResponse($this->queryCgm->get());

        return response()->json($response);
    }

    public function pesquisaPorRg($rg)
    {
        $this->queryCgm->whereRaw("z01_ident = '{$rg}'");
        $response = $this->makeResponse($this->queryCgm->get());

        return response()->json($response);
    }

    public function pesquisaEndereco($numcgm)
    {
        $response = (object)[
            "enderecospessoa" => [],
            "qtd_registro" => 0
        ];

        $cgm = Cgm::find($numcgm);
        $data_atualizacao = $cgm->z01_ultalt?date('Y-m-d H:i:s', strtotime((string) $cgm->z01_ultalt)):date('Y-m-d H:i:s');
        $response->enderecospessoa[] = (object)[
            "data_endereco" => $data_atualizacao,
            "tp_endereco" => "PRINCIPAL",
            "txt_endereco" => sprintf(
                "%s %s %s %s %s %s %s",
                mb_convert_encoding(trim((string) $cgm->z01_ender), 'UTF-8', 'ISO-8859-1'),
                mb_convert_encoding(trim((string) $cgm->z01_numero), 'UTF-8', 'ISO-8859-1'),
                mb_convert_encoding(trim((string) $cgm->z01_compl), 'UTF-8', 'ISO-8859-1'),
                mb_convert_encoding(trim((string) $cgm->z01_bairro), 'UTF-8', 'ISO-8859-1'),
                mb_convert_encoding(trim((string) $cgm->z01_munic), 'UTF-8', 'ISO-8859-1'),
                mb_convert_encoding(trim((string) $cgm->z01_uf), 'UTF-8', 'ISO-8859-1'),
                mb_convert_encoding(trim((string) $cgm->z01_cep), 'UTF-8', 'ISO-8859-1')
            )
        ];

        DB::table("proprietario")
            ->select('*')
            ->where('z01_numcgm', '=', $numcgm)
            ->limit(200)
            ->get()
            ->map(function ($endereco) use (&$response) {
                $response->enderecospessoa[] = (object)[
                    "data_endereco" => date('Y-m-d H:i:s'),
                    "tp_endereco" =>mb_convert_encoding("Carnê IPTU", 'UTF-8', 'ISO-8859-1'),
                    "txt_endereco" => sprintf(
                        "%s %s %s %s %s %s %s",
                        mb_convert_encoding(trim((string) $endereco->z01_ender), 'UTF-8', 'ISO-8859-1'),
                        mb_convert_encoding(trim((string) $endereco->z01_numero), 'UTF-8', 'ISO-8859-1'),
                        mb_convert_encoding(trim((string) $endereco->z01_compl), 'UTF-8', 'ISO-8859-1'),
                        mb_convert_encoding(trim((string) $endereco->z01_bairro), 'UTF-8', 'ISO-8859-1'),
                        mb_convert_encoding(trim((string) $endereco->z01_munic), 'UTF-8', 'ISO-8859-1'),
                        mb_convert_encoding(trim((string) $endereco->z01_uf), 'UTF-8', 'ISO-8859-1'),
                        mb_convert_encoding(trim((string) $endereco->z01_cep), 'UTF-8', 'ISO-8859-1')
                    )
                ];
            });

        $response->qtd_registro = count($response->enderecospessoa);
        return response()->json($response);
    }

    /**
     * @param $pessoas
     * @return object
     */
    private function makeResponse($pessoas)
    {
        $response = (object)[
            "pessoas" => [],
            "qtd_registros" => 0
        ];

        $response->pessoas = $pessoas->map(function ($cgm) {
            $nro_rg = null;
            if (!empty(trim((string) $cgm->z01_ident))) {
                $nro_rg = trim((string) $cgm->z01_ident);
            }

            $nro_cpf = null;
            if ($cgm->z01_cgccpf != '99999999999' && $cgm->z01_cgccpf != '00000000000') {
                $nro_cpf = $cgm->z01_cgccpf;
            }

            $observacoes = [];
//            if (!empty(trim($cgm->z01_obs))) {
//                $observacoes[] = utf8_encode($cgm->z01_obs);
//            }
            if (!empty(trim((string) $cgm->z01_telcel))) {
                $observacoes[] = trim((string) $cgm->z01_telcel);
            }
            if (!empty(trim((string) $cgm->z01_telef))) {
                $observacoes[] = trim((string) $cgm->z01_telef);
            }

            return (object)[
                "cod_pessoa" => $cgm->z01_numcgm,
                "nro_cpf" => $nro_cpf,
                "nro_rg" => $nro_rg,
                "uf_rg" => $cgm->z01_identorgao,
                "nome_pessoa" => mb_convert_encoding($cgm->z01_nomecomple, 'UTF-8', 'ISO-8859-1'),
                "dt_nascimento" => date('Y-m-d H:i:s', strtotime((string) $cgm->z01_nasc)),
                "nome_mae" => mb_convert_encoding($cgm->z01_mae, 'UTF-8', 'ISO-8859-1'),
                "nome_pai" => mb_convert_encoding($cgm->z01_pai, 'UTF-8', 'ISO-8859-1'),
                "txt_observacao" => implode(" - ", $observacoes)
            ];
        });

        $response->qtd_registros = count($response->pessoas);
        return $response;
    }
}
