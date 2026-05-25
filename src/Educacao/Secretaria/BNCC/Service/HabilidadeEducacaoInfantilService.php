<?php


namespace ECidade\Educacao\Secretaria\BNCC\Service;

use ECidade\Educacao\Escola\Model\HabilidadeDesenvolvida;
use ECidade\Educacao\Secretaria\BNCC\Model\Disciplina;
use ECidade\Educacao\Secretaria\BNCC\Model\HabilidadeEducacaoInfantil;
use ECidade\Educacao\Secretaria\BNCC\Repository\HabilidadeEducacaoInfantilRepository;
use ECidade\Educacao\Secretaria\Models\ParametrosGlobais;
use Exception;

class HabilidadeEducacaoInfantilService
{
    /**
     * @param int $ano
     */
    public function __construct(private ParametrosGlobais $configuracao, private $ano = null)
    {
        if (is_null($this->ano)) {
            $this->ano = date('Y');
        }
    }

    /**
     * @param Disciplina $disciplina
     * @return HabilidadeEducacaoInfantil[]
     * @throws Exception
     */
    public function buscarHabilidades(Disciplina $disciplina)
    {
        $repository = new HabilidadeEducacaoInfantilRepository();

        return $repository->scopeDisciplinaBNCC($disciplina)
            ->scopeAno($this->ano)
            ->get();
    }

    /**
     * @param HabilidadeDesenvolvida $habilidadeDesenvolvida
     * @return HabilidadeEducacaoInfantil[]
     * @throws Exception
     */
    public function getHabilidade(HabilidadeDesenvolvida $habilidadeDesenvolvida)
    {
        $repository = new HabilidadeEducacaoInfantilRepository();
        $habilidades = $repository->scopeHabilidadeDesenvolvida($habilidadeDesenvolvida)
            ->scopeAno($this->ano)
            ->get();

        return array_shift($habilidades);
    }
}
