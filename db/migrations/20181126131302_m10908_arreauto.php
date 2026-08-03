<?php

use Classes\PostgresMigration;

class M10908Arreauto extends PostgresMigration
{
    public function up()
    {
        $this->table('arreauto',
          ['schema' => 'caixa', 'id' => false])
          ->addColumn('k00_numpre', 'integer', ['null' => true])
          ->addColumn('k00_auto', 'integer', ['null' => true])
          ->addIndex(['k00_numpre', 'k00_auto'], ['name' => 'arreauto_auto_numpre_in'])
          ->create();
    }

    public function down()
    {
        $this->table('arreauto', ['schema' => 'caixa'])->drop();
    }
}
