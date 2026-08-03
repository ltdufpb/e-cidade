<?php
namespace ECidade\Tributario\Arrecadacao\Entity\Repository;

use ECidade\Tributario\Library\DataBase;
use ECidade\Tributario\Library\DataBaseRepository;
use ECidade\Tributario\Caixa\Entity\Debito;
use ECidade\Tributario\Caixa\Repository\ArrematricRepository;
use ECidade\Tributario\Caixa\Repository\ArreinscrRepository;
use ECidade\Tributario\Caixa\Repository\ArrenumcgmRepository;
use ECidade\Tributario\Arrecadacao\Entity\Matricula;
use ECidade\Tributario\Arrecadacao\Entity\Inscricao;
use ECidade\Tributario\Arrecadacao\Entity\Contribuinte;
use ECidade\Tributario\Cadastro\Repository\IptubaseRepository;
use ECidade\Tributario\Issqn\Repository\IssbaseRepository;

use \CgmFactory;
use \endereco;

class ContribuinteRepository extends DataBaseRepository
{
    public function __construct(
        Database $database, 
        private readonly ArrematricRepository $arrematricRepository, 
        private readonly ArreinscrRepository $arreinscrRepository,
        private readonly ArrenumcgmRepository $arrenumcgmRepository,
        private readonly IptubaseRepository $iptubaseRepository,
        private readonly IssbaseRepository $issbaseRepository
    ) {
        $this->database = $database;
    }

    public function findByDebito(Debito $debito)
    {
        $arrematric = $this->arrematricRepository->findAll("k00_numpre = {$debito->getNumpre()}");
        $arreinscr  = $this->arreinscrRepository->findAll("k00_numpre = {$debito->getNumpre()}");
        $arrenumcgm = $this->arrenumcgmRepository->findAll("k00_numpre = {$debito->getNumpre()}");

        if (empty($arrenumcgm)) {
            return null;
        }

        $numcgm = $arrenumcgm[0]->getNumcgm();

        if (!empty($arreinscr)) {
            $issbase = $this->issbaseRepository->find($arreinscr[0]->getInscr());
            $numcgm = $issbase->getNumcgm();

            $contribuinte = new Inscricao();
            $contribuinte->setIdentificador($issbase->getInscr());

        } elseif (!empty($arrematric)) {
            $iptubase = $this->iptubaseRepository->find($arrematric[0]->getMatric());
            $numcgm = $iptubase->getNumcgm();

            $contribuinte = new Matricula();
            $contribuinte->setIdentificador($iptubase->getMatric());

        } else {
            $contribuinte = new Contribuinte();
            $contribuinte->setIdentificador($numcgm);
        }

        $cgm = CgmFactory::getInstanceByCgm($numcgm);
        $contribuinte->setCgm($cgm);
        $contribuinte->setEndereco(new endereco($cgm->getEnderecoPrimario()));

        return $contribuinte;
    }
}
