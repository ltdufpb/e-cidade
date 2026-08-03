<?php
require_once(modification('model/tceEstruturaBasica.php'));

class tceFolhaPagamentoPosterior extends tceEstruturaBasica
{
    const NOME_ARQUIVO = 'PAGTO_POS.TXT';
    const CODIGO_ARQUIVO = 308;

    private $oLeiaute = null;

    public function __construct(public $iInstit, public $sCodRemessa, public $sDataIni, public $sDataFim, $oData, $oLeiaute = null, public $sInstituicoes = null, public $iCodigoArquivo = 308)
    {
        try {
            parent::__construct(self::CODIGO_ARQUIVO, self::NOME_ARQUIVO);
        } catch (Exception $e) {
            throw $e;
        }

        if ($oLeiaute != null) {
            $this->oLeiaute = $oLeiaute;
        }
    }

    /**
     * @return string
     */
    public function getNomeArquivo()
    {
        return self::NOME_ARQUIVO;
    }

    /**
     * @return int
     */
    public function getCodigoArquivo()
    {
        return self::CODIGO_ARQUIVO;
    }


    public function geraArquivo()
    {
        db_criatermometro('tceFolhaPagamentoPosterior', 'Arquivo PAGTO_POS...', 'blue', 1);

        $this->oTxtLayout->setByLineOfDBUtils(
            $this->cabecalhoPadrao(
                $this->iInstit,
                $this->sDataIni,
                $this->sDataFim,
                $this->sCodRemessa
            ),
            1
        );

        $rsPagamentosPosteriores = db_query($this->buscaInformacoesPagamentoPosterior());
        $iNumRows = $rsPagamentosPosteriores === false || $rsPagamentosPosteriores === null ? 0 : pg_num_rows($rsPagamentosPosteriores);
        $iTotalRegistros = 0;
        $iQuant = 0;

        for ($i = 0; $i < $iNumRows; $i++) {
            $iNew = intval($i * 100 / $iNumRows);

            if ($iNew > $iQuant) {
                $iQuant = $iNew;
                db_atutermometro($i, $iNumRows, "terTCE4820");
            }

            $pagamentoPosterior = db_utils::fieldsMemory($rsPagamentosPosteriores, $i);
            $this->oTxtLayout->setByLineOfDBUtils($pagamentoPosterior, 3);
            $iTotalRegistros++;
        }

        $this->oTxtLayout->setByLineOfDBUtils($this->rodapePadrao($iTotalRegistros), 5);
        unset($rsPagamentosPosteriores);
    }

    private function buscaInformacoesPagamentoPosterior()
    {
        [$iAnoUsuFim, $iMesUsuFim, $iDiaUsuFim] = explode("-", (string) $this->sDataFim);
        [$iAnoUsuIni, $iMesUsuIni, $iDiaUsuIni] = explode("-", (string) $this->sDataIni);

        $sql = "
            SELECT
                rh237_identificador AS idfolha,
                rh237_matricula AS codigoregistrofuncionario,
                rh237_datapagamento AS datapagamento,
                round(sum(
                    CASE WHEN rh237_identificacaovalor = 'D'
                    THEN rh237_valor * - 1
                        ELSE rh237_valor END
                ), 2) AS valorpago,
                rh237_banco AS codigobanco,
                rh237_agencia AS codigoagencia,
                rh237_contacorrente AS codigocontacorrente,
                'S' AS ultimopagamento
            FROM padpagamentoposterior
            WHERE rh237_ano >= {$iAnoUsuIni} AND rh237_mes >= {$iMesUsuIni}
              AND rh237_ano <= {$iAnoUsuFim} AND rh237_mes <= {$iMesUsuFim}
              AND rh237_instituicao IN ({$this->sInstituicoes})
            GROUP BY rh237_identificador,
                rh237_matricula,
                rh237_ano,
                rh237_mes,
                rh237_datapagamento,
                rh237_tipofolha,
                rh237_banco,
                rh237_agencia,
                rh237_contacorrente
            ORDER BY rh237_ano, rh237_mes
        ";

        return $sql;
    }
}
