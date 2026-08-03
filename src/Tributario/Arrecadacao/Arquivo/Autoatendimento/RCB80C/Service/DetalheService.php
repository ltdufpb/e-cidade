<?php

namespace ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\RCB80C\Service;

use ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\Repository\Detalhe as DetalheRepository;
use ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\RCB80C\Converter\DetalheConverter;
use ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\RCB80C\Layout\Detalhe as DetalheLayout;
use ECidade\Tributario\Library\Service;

final class DetalheService extends Service
{
    public function __construct(private readonly ArquivoTxtService $arquivoTxtService, private readonly DetalheRepository $detalheRepository)
    {
    }

    public function execute($path)
    {
        $detalheLayout    = new DetalheLayout();
        $detalheConverter = new DetalheConverter($detalheLayout);
        $linhasArquivo    = $this->arquivoTxtService->path($path)->toArray();
        $totalLinhas      = count($linhasArquivo) - 1;
        $detalhes         = [];

        foreach ($linhasArquivo as $indice => $linha) {
            if ($indice === 0) {
                continue;
            }

            if ($indice == $totalLinhas) {
                continue;
            }

            $linha = $detalheConverter->build($linha);
            $this->atualizarLinha($linha);
        }

        return;
    }

    public function atualizarLinha($linha)
    {
        $dadosRegistro = $this->detalheRepository->findByNumnov($linha->getNumnov());
        $this->detalheRepository->persist($dadosRegistro);

        return;
    }
}
