<?php

namespace App\Domain\Patrimonial\Protocolo\Services;

use App\Domain\Patrimonial\Protocolo\Repository\CgmRepository;

class CgmService
{
    public function getByNumcgm($numcgm)
    {
        $cgmRepository = new CgmRepository();
        $oCgm = $cgmRepository->getByNumcgm($numcgm);

        if (empty($oCgm->z01_numcgm)) {
            throw new \Exception("Nenhum contribuinte cadastrado para este CGM");
        }

        if (str_starts_with(trim($oCgm->z01_cgccpf), "0000000") || empty(trim($oCgm->z01_cgccpf))) {
            throw new \Exception("Contribuinte com o cadastro desatualizado, dirija-se a prefeitura.");
        }

        return [
            "numcgm" => $oCgm->z01_numcgm,
            "cpfCnpj" => $oCgm->z01_cgccpf,
            "nome" => $oCgm->z01_nome,
            "sexo" => (!empty($oCgm->z01_sexo) ? strtoupper((string) $oCgm->z01_sexo) : ""),
            "endereco" => $oCgm->z01_ender,
            "numero" => $oCgm->z01_numero,
            "complemento" => $oCgm->z01_compl,
            "caixaPostal" => $oCgm->z01_cxpostal,
            "bairro" => $oCgm->z01_bairro,
            "municipio" => $oCgm->z01_munic,
            "uf" => $oCgm->z01_uf,
            "cep" => $oCgm->z01_cep,
            "email" => $oCgm->z01_email
        ];
    }

    public function getCgmByCpfCnpj($cpfCnpj)
    {
        $cgmRepository = new CgmRepository();
        $aCgm = $cgmRepository->getByCpfCnpj($cpfCnpj)->toArray();

        if (count($aCgm) == 0) {
            $sForma = (strlen((string) $cpfCnpj) == 11 ? "CPF" : "CNPJ");

            throw new \Exception("Nenhum contribuinte cadastrado para este {$sForma}");
        }

        return array_map(fn($aCgm) => [
            "numcgm" => $aCgm["z01_numcgm"],
            "nome" => $aCgm["z01_nome"],
            "sexo" => (!empty($aCgm->z01_sexo) ? strtoupper((string) $aCgm->z01_sexo) : ""),
            "endereco" => $aCgm["z01_ender"],
            "numero" => $aCgm["z01_numero"],
            "complemento" => $aCgm["z01_compl"],
            "caixaPostal" => $aCgm["z01_cxpostal"],
            "bairro" => $aCgm["z01_bairro"],
            "municipio" => $aCgm["z01_munic"],
            "uf" => $aCgm["z01_uf"],
            "cep" => $aCgm["z01_cep"],
            "email" => $aCgm["z01_email"]
        ], $aCgm);
    }
}
