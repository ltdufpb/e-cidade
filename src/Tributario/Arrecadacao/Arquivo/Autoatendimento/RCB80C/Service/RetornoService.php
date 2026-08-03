<?php

namespace ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\RCB80C\Service;

use ECidade\Tributario\Library\Service;

class RetornoService extends Service
{
    public function __construct(private readonly DetalheService $detalheService)
    {
    }

    public function execute($path)
    {
        $this->detalheService->execute($path);
    }
}