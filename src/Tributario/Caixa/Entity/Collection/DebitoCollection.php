<?php

namespace ECidade\Tributario\Caixa\Entity\Collection;

use Override;
use ECidade\Tributario\Library\ArrayCollection;

final class DebitoCollection extends ArrayCollection
{
    #[Override]
    public function add($debito)
    {
        parent::add($debito);
    }
}
