<?php

use Classes\PostgresMigration;

class M11917SimplesEireli extends PostgresMigration
{
    public function up()
    {
        $aSql = [];

        $aSql[] = " insert into db_syscampodef values (10560, '4', 'EIRELI');";

        foreach ($aSql as $sSql) {
            $this->execute($sSql);
        }
    }

    public function down()
    {
        $aSql = [];

        $aSql[] = "delete from db_syscampodef where codcam = 10560 and defcampo = '4';";

        foreach ($aSql as $sSql) {
            $this->execute($sSql);
        }
    }

}
