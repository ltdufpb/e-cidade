<?php

namespace ECidade\Patrimonial\Protocolo\Modelo;

/**
 * Class Processo
 * @package ECidade\Patrimonial\Protocolo\Modelo
 */
class Processo
{
    private $iPrazoDiasEnvio;


    /**
     * Processo constructor.
     * @param $codigo
     * @param $dataCriacao
     * @param $data
     * @param $hora
     * @param $departamento
     * @param $usuario
     * @param $login
     * @param $assunto
     * @param $codigoDepartamento
     * @param $codigoUsuario
     * @param $iNumero
     * @param $iAno
     * @param null $iPrazoDiasEnvio
     * @param int $codigo
     * @param string $dataCriacao
     * @param string $data
     * @param string $hora
     * @param string $departamento
     * @param string $usuario
     * @param string $login
     * @param string $assunto
     * @param int $codigoDepartamento
     * @param int $codigoUsuario
     * @param int $iNumero
     * @param int $iAno
     */
    public function __construct(
        private $codigo,
        private $dataCriacao,
        private $data,
        private $hora,
        private $departamento,
        private $usuario,
        private $login,
        private $assunto,
        private $codigoDepartamento,
        private $codigoUsuario,
        private $iNumero,
        private $iAno,
        $iPrazoDiasEnvio = null
    ) {
        $this->iPrazoDiasEnvio = $iPrazoDiasEnvio;
    }

    /**
     * @return mixed
     */
    public function getIPrazoDiasEnvio()
    {
        return $this->iPrazoDiasEnvio;
    }

    /**
     * @param mixed $iPrazoDiasEnvio
     */
    public function setIPrazoDiasEnvio($iPrazoDiasEnvio)
    {
        $this->iPrazoDiasEnvio = $iPrazoDiasEnvio;
    }



    /**
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return \DBDate
     */
    public function getDataCriacao()
    {
        return new \DBDate($this->dataCriacao);
    }

    /**
     * @param $dataCriacao
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;
    }

    /**
     * @return \DBDate
     */
    public function getData()
    {
        return new \DBDate($this->data);
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @param $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    /**
     * @return string
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param $departamento
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * @param $assunto
     */
    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;
    }

    /**
     * @return int
     */
    public function getCodigoDepartamento()
    {
        return $this->codigoDepartamento;
    }

    /**
     * @param $codigoDepartamento
     */
    public function setCodigoDepartamento($codigoDepartamento)
    {
        $this->codigoDepartamento = $codigoDepartamento;
    }

    /**
     * @return int
     */
    public function getCodigoUsuario()
    {
        return $this->codigoUsuario;
    }

    /**
     * @param $codigoUsuario
     */
    public function setCodigoUsuario($codigoUsuario)
    {
        $this->codigoUsuario = $codigoUsuario;
    }

    /**
     * @return int
     */
    public function getNumero()
    {
        return $this->iNumero;
    }

    /**
     * @param $iNumero
     */
    public function setNumero($iNumero)
    {
        $this->iNumero = $iNumero;
    }

    /**
     * @return int
     */
    public function getAno()
    {
        return $this->iAno;
    }

    /**
     * @param $iAno
     */
    public function setAno($iAno)
    {
        $this->iAno = $iAno;
    }
}
