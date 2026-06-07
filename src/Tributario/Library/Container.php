<?php

namespace ECidade\Tributario\Library;

use ECidade\V3\Extension\Container as ContainerAbstract;

abstract class Container extends ContainerAbstract
{
    protected $content;

    public function __construct(protected $container)
    {
        $this->charge();
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    #[\Override]
    public function has($index)
    {
        return $this->content[$index] != null;
    }

    public abstract function charge();
}
