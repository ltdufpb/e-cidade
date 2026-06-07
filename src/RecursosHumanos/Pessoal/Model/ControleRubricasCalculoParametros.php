<?php


namespace ECidade\RecursosHumanos\Pessoal\Model;

use DBCompetencia;
use Instituicao;
use Rubrica;
use Servidor;

class ControleRubricasCalculoParametros
{
    /**
     * @var DBCompetencia
     */
    private $competencia;

    /**
     * ControleHorasExtrasCalculoParametros constructor.
     * @param Instituicao $instituicao
     * @param DBCompetencia $competencia
     * @param Servidor $servidor
     * @param Rubrica $rubrica
     * @param float $quantidadeAdicionada
     * @param bool $isAlteracao
     * @param string $tabela
     */
    public function __construct(
        private Instituicao $instituicao,
        DBCompetencia $competencia,
        private Servidor $servidor,
        private Rubrica $rubrica,
        private $quantidadeAdicionada,
        private $isAlteracao,
        private $tabela
    ) {
        $this->competencia = $competencia;
    }

    /**
     * @return Instituicao
     */
    public function getInstituicao()
    {
        return $this->instituicao;
    }

    /**
     * @param Instituicao $instituicao
     */
    public function setInstituicao($instituicao)
    {
        $this->instituicao = $instituicao;
    }

    /**
     * @return DBCompetencia
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * @param DBCompetencia $competencia
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
    }

    /**
     * @return Servidor
     */
    public function getServidor()
    {
        return $this->servidor;
    }

    /**
     * @param Servidor $servidor
     */
    public function setServidor($servidor)
    {
        $this->servidor = $servidor;
    }

    /**
     * @return Rubrica
     */
    public function getRubrica()
    {
        return $this->rubrica;
    }

    /**
     * @param Rubrica $rubrica
     */
    public function setRubrica($rubrica)
    {
        $this->rubrica = $rubrica;
    }

    /**
     * @return float
     */
    public function getQuantidadeAdicionada()
    {
        return $this->quantidadeAdicionada;
    }

    /**
     * @param float $quantidadeAdicionada
     */
    public function setQuantidadeAdicionada($quantidadeAdicionada)
    {
        $this->quantidadeAdicionada = $quantidadeAdicionada;
    }

    /**
     * @return bool
     */
    public function isAlteracao()
    {
        return $this->isAlteracao;
    }

    /**
     * @param bool $isAlteracao
     */
    public function setIsAlteracao($isAlteracao)
    {
        $this->isAlteracao = $isAlteracao;
    }

    /**
     * @return string
     */
    public function getTabela()
    {
        return $this->tabela;
    }

    /**
     * @param string $tabela
     */
    public function setTabela($tabela)
    {
        $this->tabela = $tabela;
    }

    /**
     * @return int|null
     */
    public function getMatriculaServidor()
    {
        if (empty($this->servidor)) {
            return null;
        }
        return $this->servidor->getMatricula();
    }

    /**
     * @return string|null
     */
    public function getCodigoRubrica()
    {
        if (empty($this->rubrica)) {
            return null;
        }

        return $this->rubrica->getCodigo();
    }
}
