<?php
namespace ECidade\Tributario\Arrecadacao\Entity;

class Matricula extends Contribuinte 
{
    public function getMatriculaMunicipal()
    {
        return parent::getIdentificador();
    }

    #[\Override]
    public function getTipo()
    {
        return self::MATRICULA;
    }
}