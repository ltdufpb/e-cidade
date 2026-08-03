<?php

namespace ECidade\Tributario\Juridico;

use ECidade\Tributario\Library\Container as ContainerAbstract;

final class Container extends ContainerAbstract
{
    public function charge()
    {
        $this->content = [
            'InicialRepository' => fn($container) => (new \ECidade\Tributario\Juridico\Inicial\Repository\Inicial())->getInstance(),
            'InicialMovRepository' => function ($container) {

                $dataBase = $container->get('DataBase');
                $dao = new \cl_inicialmov();

                return new \ECidade\Tributario\Juridico\Inicial\Repository\InicialMov($dataBase, $dao);
            },
            'InicialCertRepository' => function ($container) {

                $dataBase = $container->get('DataBase');
                $dao = new \cl_inicialcert();

                return new \ECidade\Tributario\Juridico\Inicial\Repository\InicialCert($dataBase, $dao);
            },
            'InicialNumpreRepository' => fn($container) => new \ECidade\Tributario\Juridico\Inicial\Repository\InicialNumpreRepository()
        ];
    }
}
