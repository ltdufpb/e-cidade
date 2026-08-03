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

namespace ECidade\Saude\Ambulatorial\Service;

use DateTime;
use ECidade\Saude\Ambulatorial\Repository\ProntuarioRepository;
use ECidade\Saude\Ambulatorial\Model\Prontuario;
use Exception;
use Cgs;

/**
 * Class ProntuarioService
 * @package ECidade\RecursosHumanos\Pessoal\Service
 */
class ProntuarioService
{
    /**
     * ProntuarioService constructor.
     * @param ProntuarioRepository $repositorio
     */
    public function __construct(private readonly ProntuarioRepository $repositorio)
    {
    }

    /**
     * Salva os dados do prontuário
     */
    public function salvar($parametros)
    {

        $prontuario = new Prontuario();
        $prontuario->setCodigo($parametros->sd24_i_codigo ?? '');
        $prontuario->setAno($parametros->sd24_i_ano ?? '');
        $prontuario->setMes($parametros->sd24_i_mes ?? '');
        $prontuario->setSequencia($parametros->sd24_i_seq ?? '');
        $prontuario->setUnidade($parametros->sd24_i_unidade ?? '');
        $prontuario->setMotivo('');
        $prontuario->setDataCadastro($parametros->sd24_d_cadastro ?? '');
        $prontuario->setHoraCadastro($parametros->sd24_c_cadastro ?? '');
        $prontuario->setCid($parametros->sd24_i_cid ?? '');
        $prontuario->setPressao($parametros->sd24_v_pressao ?? '');
        $prontuario->setPeso($parametros->sd24_f_peso ?? '');
        $prontuario->setTemperatura($parametros->sd24_f_temperatura ?? '');
        $prontuario->setProfissional($parametros->sd24_i_profissional ?? '');
        $prontuario->setDiagnostico($parametros->sd24_t_diagnostico ?? '');
        $prontuario->setSiasih($parametros->sd24_i_siasih ?? '');
        $prontuario->setDigitada($parametros->sd24_c_digitada ?? '');
        $prontuario->setLogin($parametros->sd24_i_login ?? '');
        $prontuario->setMotivoAtendimento($parametros->sd24_i_motivo ?? '');
        $prontuario->setTipo($parametros->sd24_i_tipo ?? '');
        $prontuario->setAcaoProgramatica(
            isset($parametros->sd24_i_sd24_i_acaoprogtipo) ? $parametros->sd24_i_acaoprog : ''
        );
        $prontuario->setSetorAmbulatorial(
            $parametros->sd24_setorambulatorial ?? ''
        );
        $prontuario->setIdadeGestacional($parametros->sd24_idadegestacional);
        $prontuario->setDum($parametros->sd24_dum);
        $prontuario->setFinalizado(
            isset($parametros->sd24_c_digitada) ? ($parametros->sd24_c_digitada == 'S' ? 'S' : 'N') : ''
        );
        
        if (!is_null($parametros->sd24_i_numcgs)) {
            $prontuario->setCgs(new Cgs($parametros->sd24_i_numcgs));
        }

        $prontuario = $this->repositorio->salvar($prontuario);

        return $prontuario;
    }

    /**
     * @param $codigo
     * @return bool|Prontuario
     * @throws Exception
     */
    public function buscaDadosGestante($codigo)
    {
        return $this->repositorio->buscaDadosGestante($codigo);
    }

    /**
     * @param $codigo
     * @return bool|Prontuario
     * @throws Exception
     */
    public function buscaProntuario($codigo)
    {
        return $this->repositorio->buscaProntuario($codigo);
    }

    /**
     * @param integer $idProntuario
     * @param DateTime $dum
     * @return Prontuario
     */
    public static function salvarDadosGestante($idProntuario, DateTime $dum)
    {
        $self = new self(new ProntuarioRepository(new \cl_prontuarios()));
        $prontuario = (object)$self->buscaProntuario($idProntuario)[0];
        
        $prontuario->sd24_dum = $dum->format('Y-m-d');

        $dias = date_diff($dum, new \DateTime($prontuario->sd24_d_cadastro))->days;
        $prontuario->sd24_idadegestacional = (int)($dias / 7);

        return $self->salvar($prontuario);
    }
}
