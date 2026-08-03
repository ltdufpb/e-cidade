<?php
/**
 * Created by PhpStorm.
 * User: dbseller
 * Date: 18/02/19
 * Time: 17:17
 */

namespace ECidade\Tributario\Arrecadacao\Arquivo\Autoatendimento\RCB800\Converter;

use ECidade\Tributario\Library\Entity;
abstract class Converter
{
    public function __construct(protected $layout, protected $format = null)
    {
    }

    abstract public function build(Entity $entity);
}
