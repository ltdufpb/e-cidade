<?php


namespace ECidade\Financeiro\Contabilidade\Relatorio\Razao\PorConta;

class RelatorioRazaoPorConta
{

    const PDF = 1;
    const  EXCEL = 2;
    const TYPES = [
        self::EXCEL,
        self::PDF
    ];

    private $relatorio;

    /**
     * @return PDF|Excel
     */
    public function getRelatorio()
    {
        return $this->relatorio;
    }

    /**
     * @param $relatorio
     */
    public function setRelatorio($relatorio)
    {
        $this->relatorio = $relatorio;
    }


    public function __construct($tipo)
    {
        match ($tipo) {
            self::PDF => $this->setRelatorio(new PDF()),
            self::EXCEL => $this->setRelatorio(new Excel()),
            default => throw new \Exception("Opção inválida!"),
        };
    }
}
