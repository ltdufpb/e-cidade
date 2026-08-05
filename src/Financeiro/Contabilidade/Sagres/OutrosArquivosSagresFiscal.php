<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

namespace ECidade\Financeiro\Contabilidade\Sagres;

use DOMDocument;
use Instituicao;

/**
 * Class OutrosArquivosSagresFiscal
 * @package ECidade\Financeiro\Contabilidade\Sagres
 */
abstract class OutrosArquivosSagresFiscal
{
    /**
     * @var array
     */
    protected $codigoInstituicoes = [];
    protected $linhas;
    protected $nameFile;

    /**
     * @param int $ano
     * @param object $params
     * @param int $codigoTCE
     */
    public function __construct(protected $params, array $codigoInstituicoes, protected $ano, protected $codigoTCE)
    {
        $this->codigoInstituicoes = $codigoInstituicoes;

        $oInstituicao = new Instituicao(db_getsession("DB_instit"));

        $codUG = $oInstituicao->getTribInst();

        if ($this->params->periodo === "diario") {
            $dDataGeracao = $this->params->dataSQL->dia.$this->params->dataSQL->mes.$this->params->dataSQL->ano;
            $this->nameFile = $codUG.$dDataGeracao.static::TAG;
        } elseif ($this->params->periodo === "anual") {
            $this->nameFile = $codUG.$this->params->dataSQL->ano.static::TAG;
        } else {
            $this->nameFile = $codUG.$this->params->dataSQL->mes.$this->params->dataSQL->ano.static::TAG;
        }
    }

    abstract protected function processar();


    public function emitirXML()
    {
        $xml = new DOMDocument("1.0", "UTF-8");
        $principalNode = $xml->createElement(static::TAG);
        foreach ($this->linhas as $linha) {
            $elementoLinha = $xml->createElement('Elem' . static::TAG);
            foreach ($this->colunasTemplate as $tag) {
                $linha = (array)$linha;

                if (array_key_exists($tag, $linha)) {
                    $elementoColuna = $xml->createElement($tag, htmlspecialchars((string) $linha[$tag]));
                } else {
                    $elementoColuna = $xml->createElement($tag, '---');
                }
                $elementoLinha->appendChild($elementoColuna);
            }
            $principalNode->appendChild($elementoLinha);
        }

        $xml->appendChild($principalNode);
        header("Content-type: text/xml");
        $filePath = 'tmp' . DS . $this->nameFile . '.xml';
        file_put_contents($filePath, $xml->saveXML());

        return $filePath;
    }

    public function emitirTXT()
    {
        $nomedoarquivo = 'tmp' . DS . $this->nameFile . '.txt';
        $fp = fopen($nomedoarquivo, "w");

        foreach ($this->linhas as $linha) {
            foreach ($this->colunasTemplate as $tag) {
                $linha = (array)$linha;
                if (array_key_exists($tag, $linha)) {
                    $linhaLimpa = str_replace(
                        "?",
                        " ",
                        mb_convert_encoding(($this->corrigeString($linha[$tag])), "Windows-1252", "UTF-8")
                    );
                    fputs($fp, "$linhaLimpa");
                } else {
                    $sLinha = mb_convert_encoding("---", 'UTF-8', 'ISO-8859-1');
                    fputs($fp, "$sLinha");
                }
            }
            fputs($fp, "\n");
        }

        fclose($fp);
        return $nomedoarquivo;
    }

    public function emitirCSV()
    {
        $nomedoarquivo = 'tmp' . DS . $this->nameFile . '.csv';
        $fp = fopen($nomedoarquivo, "w");
        fputs($fp, implode(';', $this->colunasTemplate)."\n");

        foreach ($this->linhas as $linha) {
            foreach ($this->colunasTemplate as $tag) {
                $linha = (array)$linha;
                if (array_key_exists($tag, $linha)) {
                    fputs($fp, "$linha[$tag];");
                } else {
                    fputs($fp, "---;");
                }
            }
            fputs($fp, "\n");
        }

        fclose($fp);
        return $nomedoarquivo;
    }

    public function emitirArquivos($formatos)
    {
        $files = [];
        $this->linhas = $this->processar();

        if ($formatos['xml']) {
            $files[$this->nameFile.'.xml'] = $this->emitirXML();
        }
        if ($formatos['csv']) {
            $files[$this->nameFile.'.csv'] = $this->emitirCSV();
        }
        if ($formatos['txt']) {
            $files[$this->nameFile.'.txt'] = $this->emitirTXT();
        }
        return $files;
    }

    public function corrigeString($string)
    {
        return preg_replace(
            ["/(á|à|ã|â|ä|ã)/",
                "/(Á|À|Â|Ä|Ã)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/",
                "/(ó|ò|õ|ô|ö)/",
                "/(Ó|Ò|Õ|Ô|Ö)/",
                "/(ú|ù|û|ü)/",
                "/(Ú|Ù|Û|Ü)/",
                "/(ñ)/",
                "/(Ñ)/",
                "/(ç)/",
                "/(Ç)/"],
            explode(" ", "a A e E i I o O u U n N c C"),
            (string) $string
        );
    }
}
