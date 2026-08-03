<?php
namespace App\Domain\RecursosHumanos\Pessoal\Model\Jetom;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoSessao
 * @package App\Domain\RecursosHumanos\Pessoal\Model\Jetom
 * @property int rh240_sequencial
 * @property string rh240_descricao
 * @property boolean rh240_ativo
 */
class TipoSessao extends Model
{

    const NORMAL = 1;
    const EXTRAORDINARIA = 2;
    const URGENTE = 3;

    protected $table = 'pessoal.jetomtiposessao';

    /**
     * @return int
     */
    public function getSequencial()
    {
        return $this->rh240_sequencial;
    }

    /**
     * @param int $rh240_sequencial
     */
    public function setSequencial($rh240_sequencial)
    {
        $this->rh240_sequencial = $rh240_sequencial;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->rh240_descricao;
    }

    /**
     * @param string $rh240_descricao
     */
    public function setDescricao($rh240_descricao)
    {
        $this->rh240_descricao = $rh240_descricao;
    }

    /**
     * @return bool
     */
    public function isAtivo()
    {
        return $this->rh240_ativo;
    }

    /**
     * @param bool $rh240_ativo
     */
    public function setAtivo($rh240_ativo)
    {
        $this->rh240_ativo = $rh240_ativo;
    }

    public static function all($columns = ['*'])
    {
        return self::where('rh240_ativo', '=', 'true')->orderBy('rh240_descricao')
            ->get(['rh240_sequencial', 'rh240_descricao']);
    }

    public static function getTipoSessao($descricao)
    {
        return self::where('rh240_descricao', '=', $descricao)
        ->get([
            'rh240_sequencial as sequencial',
            'rh240_descricao as descricao',
            'rh240_ativo as ativo'
        ])->first();
    }

    public static function getDescricaoByTipo($tipo)
    {
        return match ($tipo) {
            self::NORMAL => "normal",
            self::EXTRAORDINARIA => "extraordinaria",
            self::URGENTE => "urgente",
            default => "normal",
        };
    }

    public static function getTipoByDescricao($descricao)
    {
        $descricao = strtolower((string) $descricao);
        return match ($descricao) {
            "normal" => self::NORMAL,
            "extraordinaria" => self::EXTRAORDINARIA,
            "urgente" => self::URGENTE,
            default => self::NORMAL,
        };
    }
}
