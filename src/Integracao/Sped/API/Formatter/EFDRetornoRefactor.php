<?php

namespace ECidade\Integracao\Sped\API\Formatter;

/**
 * Responsavel por refatorar os dados dos eventos
 * de retorno do EFD-REINF
 */
class EFDRetornoRefactor
{
    /**
     * Dados a serem manipulados
     *
     * @var stdClass
     */
    protected $data;

    /**
     * Contrutor
     *
     * @param string $layout
     * @param \stdClass $data
     */
    public function __construct(/**
     * Tipo de Layout
     */
    protected $layout, \stdClass $data)
    {
        $this->data = $data;
    }

    /**
     * Centralizador das funcoes de formatacao dos dados
     * por tipo de evento
     *
     * @return object
     */
    public function format()
    {
        return match ($this->layout) {
            'R-5001' => $this->formatR5001(),
            'R-5011' => $this->fortmatR5011(),
            default => $this->data,
        };
    }


    /**
     * Formatacao para o evento R-5011
     *
     * @return object
     */
    private function fortmatR5011()
    {
        if (isset($this->data->infoTotalContrib)) {
            $infoTotalContrib = $this->data->infoTotalContrib;

            // R-2010 SERVICOS TOMADOS
            if (isset($infoTotalContrib->RTom)) {
                foreach ($infoTotalContrib->RTom as $item) {
                    $item->CRTom         = $item->infoCRTom->CRTom;
                    $item->VlrCRTom      = $item->infoCRTom->VlrCRTom;
                    $item->VlrCRTomSusp  = $item->infoCRTom->VlrCRTomSusp;

                    $item->VlrCRTom        = $this->formatMoney($item->VlrCRTom);
                    $item->VlrCRTomSusp    = $this->formatMoney($item->VlrCRTomSusp);
                    $item->vlrTotalBaseRet = $this->formatMoney($item->vlrTotalBaseRet);

                    $item->cnpjPrestador = preg_replace(
                        "/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/",
                        "\$1.\$2.\$3/\$4-\$5",
                        (string) $item->cnpjPrestador
                    );

                    unset($item->infoCRTom);
                }
            }

            // R-2055 AQUISICAO PRODUCAO RURAL
            if (isset($infoTotalContrib->RAquis)) {
                foreach ($infoTotalContrib->RAquis as $item) {
                    $item->vlrCRAquis = $this->formatMoney($item->vlrCRAquis);
                }
            }
        }

        return $this->data;
    }

    /**
     * Formatacao para o evento R-5001
     *
     * @return object
     */
    public function formatR5001()
    {
        // R-2010 SERVICOS TOMADOS
        if (isset($this->data->RTom)) {
            $rtom = &$this->data->RTom;

            $rtom->CRTom        = $rtom->infoCRTom->CRTom;
            $rtom->VlrCRTom     = $rtom->infoCRTom->VlrCRTom;
            $rtom->VlrCRTomSusp = $rtom->infoCRTom->VlrCRTomSusp;
            $rtom->VlrCRTom     = $this->formatMoney($rtom->VlrCRTom);
            $rtom->VlrCRTomSusp = $this->formatMoney($rtom->VlrCRTomSusp);

            $rtom->cnpjPrestador = preg_replace(
                "/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/",
                "\$1.\$2.\$3/\$4-\$5",
                (string) $rtom->cnpjPrestador
            );

            unset($rtom->infoCRTom);
            unset($rtom);
        }

        // R-2055 AQUISICAO PRODUCAO RURAL
        if (isset($this->data->RAquis)) {
            foreach ($this->data->RAquis as $item) {
                $item->vlrCRAquis = $this->formatMoney($item->vlrCRAquis);
            }
        }

        return $this->data;
    }

    /**
     * Helper para formatar padrão moeda
     *
     * @return
     */
    private function formatMoney($value)
    {
        if (empty($value)) {
            return '0,00';
        }

        $value = preg_replace('/\,/', '.', (string) $value);
        $value = number_format($value, 2, ',', '.');

        return $value;
    }
}
