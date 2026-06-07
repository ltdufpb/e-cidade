<?php

namespace ECidade\Tributario\Caixa\Entity\Collection;

use ECidade\Tributario\Library\ArrayCollection;

final class ReceitaCollection extends ArrayCollection
{
    #[\Override]
    public function add($receita)
    {
        parent::add($receita);
    }
}
