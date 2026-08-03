<?php

use Classes\PostgresMigration;

class M7689ConveniocobrancaAddResponsavelnossonumero extends PostgresMigration
{

    public function up()
    {

        $this->table('conveniocobranca',    ['schema'=>'arrecadacao'])
                ->addColumn('ar13_responsavelnossonumero', 'boolean', ['null' => false, 'default' => 't'])
                ->save();

        $this->table('db_syscampo', ['schema' => 'configuracoes'])
                ->insert(['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'],
                             [[22251,'ar13_responsavelnossonumero','bool','Identifica se a instituição é responsável pela geração do nosso número nos recibos.',
                                               'true', 'Responsável pela numeração',1,'f','f','f',5,'text','Responsável pela numeração']]
                             )
                ->saveData();

        $this->table('db_sysarqcamp', ['schema' => 'configuracoes'])
                ->insert(['codarq', 'codcam', 'seqarq', 'codsequencia'],
                             [[2186,22251,12,0]]
                         )
                ->saveData();

    }

    public function down()
    {

        $this->execute('DELETE FROM db_sysarqcamp WHERE codarq = 2186 AND codcam = 22251');

        $this->execute('DELETE FROM db_syscampo WHERE codcam = 22251');

        $this->table('conveniocobranca', ['schema' => 'arrecadacao'])
                ->removeColumn('ar13_responsavelnossonumero')
                ->save();
    }
}
