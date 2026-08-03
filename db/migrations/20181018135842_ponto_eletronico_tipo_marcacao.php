<?php

use Classes\PostgresMigration;

class PontoEletronicoTipoMarcacao extends PostgresMigration
{
    public function up()
    {
        $sqls = [
            "CREATE TYPE tipo_marcacao AS ENUM (
                 'R' --Relogio
                ,'G' --Gerada
            );",
            "ALTER TABLE pontoeletronicoarquivodataregistro ADD COLUMN rh198_origem_marcacao tipo_marcacao NOT NULL DEFAULT 'R';",
        ];

        $this->executaSql($sqls);
        $this->upDicionarioDados();
    }

    public function upDicionarioDados()
    {
        $sqls = [
            "INSERT INTO db_syscampo
                VALUES(1010030,'rh198_origem_marcacao','char(1)','Define se a marcação veio do relógio ou se foi gerada pelo sistema.','','Origem da Marcação',1,'f','t','f',0,'text','Origem da Marcação');",
            "INSERT INTO db_syscampodef 
                VALUES(1010030,'R','');",
            "INSERT INTO db_sysarqcamp
                VALUES(4015,1010030,7,0);"
        ];

        $this->executaSql($sqls);
    }

    public function executaSql($sqls)
    {
        if(is_array($sqls) && !empty($sqls)) {
            foreach ($sqls as $sql) {
                $this->execute($sql);
            }
        }
    }

    public function down()
    {
        $this->downDicionarioDados();

        $this->table('pontoeletronicoarquivodataregistro', ['schema'=>'recursoshumanos'])
             ->removeColumn('rh198_origem_marcacao')
             ->save();

        $this->executaSql(["DROP TYPE tipo_marcacao"]);
    }

    public function downDicionarioDados()
    {
        $sqls = [
            "DELETE FROM db_sysarqcamp WHERE codarq = 4015 AND codcam = 1010030;",
            "DELETE FROM db_syscampodef WHERE codcam = 1010030;",
            "DELETE FROM db_syscampo WHERE codcam = 1010030;",
        ];

        $this->executaSql($sqls);
    }
}
