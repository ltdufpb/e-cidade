<?php

namespace App\Domain\Patrimonial\Patrimonio\Services;

use App\Domain\Patrimonial\Patrimonio\Contracts\EtiquetaBuilder;
use App\Domain\Patrimonial\Patrimonio\Models\Bem;

class EtiquetaService
{
    public function build(EtiquetaBuilder $builder, Bem $bem)
    {
        $builder->setCodigo($bem->t52_bem);
        $builder->setInstituicao($bem->instituicao->nomeinst);
        $builder->setPlaca($bem->t52_ident);
        $builder->setDescricao(mb_convert_encoding($bem->t52_descr, 'UTF-8', 'ISO-8859-1'));
        $builder->setBarcode($bem->t52_ident);

        $builder->create();

        return $builder->getEtiqueta();
    }
}
