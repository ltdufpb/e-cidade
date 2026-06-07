<?php

namespace ECidade\Lib\Config;

class DbConn
{
    /**
     * @var DbConn
     */
    public static $instance;

    /**
     * @var null string
     */
    private $senha;

    /**
     * @param string $DB_SERVIDOR
     * @param string $DB_BASE
     * @param string $DB_PORTA
     * @param string $DB_USUARIO
     */
    private function __construct(
        private $servidor = null,
        private $base = null,
        private $porta = null,
        private $usuario = null,
        $DB_SENHA = null
    ) {
        /***
         * Legacy compat
         */
        require_once(modification("libs/db_conn.php"));
        $this->senha = $DB_SENHA;
    }

    /**
     * @return DbConn
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    /**
     * @return string
     */
    public function servidor()
    {
        return $this->servidor;
    }

    /**
     * @return string
     */
    public function base()
    {
        return $this->base;
    }

    /**
     * @return string
     */
    public function porta()
    {
        return $this->porta;
    }

    /**
     * @return string
     */
    public function usuario()
    {
        return $this->usuario;
    }

    /**
     * @return null
     */
    public function senha()
    {
        return $this->senha;
    }
}
