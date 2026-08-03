<?php

namespace ECidade\Tributario\Cadastro\Iptu\Arquivo\Layout;

use \DateTime;
use \BusinessException;

final class Generico extends Layout
{
    /**
     * @var integer|null
     *
     * Variável contem o tamanho do campo
     */
    private $size;

    /**
     * @param string|null $name
     * @param string|null $description
     */
    public function __construct (/**
     * @var string|null
     *
     * Nome do layout
     */
    private $name, /**
     * @var string|null
     *
     * Descrição do layout
     */
    private $description, $size)
    {
        if(empty($size)) {
            throw BusinessException("Informe o tamanho do campo.");
        }
        $this->size        = $size;

        $this->fields = [
            'DEFAULT' => [
                'name'         => $this->name
                ,'description' => $this->description
                ,'size'        => $this->size
            ]
        ];
    }
}
