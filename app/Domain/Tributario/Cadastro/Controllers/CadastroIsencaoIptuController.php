<?php

namespace App\Domain\Tributario\Cadastro\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Tributario\Cadastro\Services\CadastroIsencaoIptuService;
use App\Http\Controllers\Controller;

class CadastroIsencaoIptuController extends Controller
{
    public function __construct(private readonly CadastroIsencaoIptuService $CadastroIsencaoIptuService)
    {
    }

    public function getDadosIsencao($request)
    {
        
        $aDadosIsencao = $this->CadastroIsencaoIptuService->getDadosIsencao($request);

        return new DBJsonResponse($aDadosIsencao);
    }
}
