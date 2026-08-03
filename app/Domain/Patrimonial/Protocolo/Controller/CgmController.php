<?php

namespace App\Domain\Patrimonial\Protocolo\Controller;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Patrimonial\Protocolo\Requests\CgmCpfCnpjRequest;
use App\Domain\Patrimonial\Protocolo\Requests\CgmRequest;
use App\Domain\Patrimonial\Protocolo\Services\CgmService;
use App\Http\Controllers\Controller;

class CgmController extends Controller
{
    public function __construct(private readonly CgmService $cgmService)
    {
    }

    public function getByNumcgm(CgmRequest $request)
    {
        $aCgm = $this->cgmService->getByNumcgm($request->numcgm);

        return new DBJsonResponse($aCgm);
    }

    public function getCgmByCpfCnpj(CgmCpfCnpjRequest $request)
    {
        $aCgm = collect($this->cgmService->getCgmByCpfCnpj($request->cpfCnpj))->first();
        return new DBJsonResponse($aCgm);
    }
}
