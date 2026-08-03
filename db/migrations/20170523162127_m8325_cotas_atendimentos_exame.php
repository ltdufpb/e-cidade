<?php

use Classes\PostgresMigration;

class M8325CotasAtendimentosExame extends PostgresMigration
{

    public function up()
    {
        $this->criarMenu();
        $this->criarDiscionario();
        $this->createTable();
    }

    private function criarMenu()
    {
        $this->execute( 'delete from db_menu where id_item_filho = 8735 AND modulo = 8167' );

        $aColumns = ['id_item', 'descricao', 'help', 'funcao', 'itemativo', 'manutencao', 'desctec', 'libcliente'];
        $aValues  = [
                            [10420 ,'Controle de Cotas' ,'Configurações de controle de quantidade de requisições/exames' ,'' ,'1' ,'1' ,'Controla a quantidade de requisições e/ou exames que poderão ser realizados.' ,'true' ],
                            [10421 ,'Cotas de Atendimentos' ,'Configuração de quantidade de pacientes por dia' ,'lab4_pacientespordia001.php' ,'1' ,'1' ,'Controla a quantidade de pacientes que poderão ser realizados no dia.' ,'false' ],
                         ];
        $table    = $this->table('db_itensmenu', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();


        $aColumns = ['id_item', 'id_item_filho', 'menusequencia', 'modulo'];
        $aValues  = [
                            [ 8173 ,10420 ,10 ,8167 ],
                            [ 10420 ,10421 ,1 ,8167 ],
                            [ 10420 ,8735 ,2 ,8167 ],
                         ];
        $table    = $this->table('db_menu', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();
    }

    private function criarDiscionario()
    {

        // tabela
        $aColumns = ['codarq', 'nomearq', 'descricao', 'sigla', 'dataincl', 'rotulo', 'tipotabela', 'naolibclass', 'naolibfunc', 'naolibprog', 'naolibform'];
        $aValues  = [
            [1010198, 'limiteatendimento', 'Armazena a configuração de limite de atendimentos realizados por dia.', 'la45', '2017-05-23', 'Limite de Atendimentos', 0, 'f', 'f', 'f', 'f'],
            [1010199, 'limiteatendimentoexame', 'Limite de exames que podem ser realizados em um dia.', 'la46', '2017-05-23', 'Limite de Atendimentos por Exame', 0, 'f', 'f', 'f', 'f' ],
            [1010200, 'limiteatendimentousado', 'Armazena a quantidade de atendimentos realizados em um dia.', 'la62', '2017-05-23', 'Limite de Atendimento Usado', 0, 'f', 'f', 'f', 'f' ],
            [1010201, 'limiteatendimentoexameusado', 'Armazena a quantidade de exames realizados em um dia.', 'la63', '2017-05-23', 'Limite de Exame Usado', 0, 'f', 'f', 'f', 'f' ],
        ];
        $table    = $this->table('db_sysarquivo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula modulo
        $aColumns = ['codmod', 'codarq' ];
        $aValues  = [
            [67,1010198],
            [67,1010199],
            [67,1010200],
            [67,1010201],
        ];
        $table    = $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // campos
        $aColumns = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
        $aValues  = [
            [1009290,'la45_sequencial','int4','Código sequencial da tabela','0', 'Sequencial',10,'f','f','f',1,'text','Sequencial'],
            [1009291,'la45_lab_laboratorio','int4','Vínculo com o laboratório.','0', 'Laboratório',10,'f','f','f',1,'text','Laboratório'],
            [1009292,'la45_quantidade','int4','Quantidade de pacientes que podem ser atendidos em um dia.','0', 'Quantidade',10,'f','f','f',1,'text','Quantidade'],
            [1009293,'la46_sequencial','int4','Código sequencial.','0', 'Sequencial',10,'f','f','f',1,'text','Sequencial'],
            [1009294,'la46_lab_setorexame','int4','Vínculo com o exame.','0', 'Exame',10,'f','f','f',1,'text','Exame'],
            [1009295,'la46_quantidade','int4','Quantidade de exames que podem ser realizados em um dia.','0', 'Quantidade',10,'f','f','f',1,'text','Quantidade'],
            [1009296,'la62_sequencial','int4','Código sequencial.','0', 'Sequencial',10,'f','f','f',1,'text','Sequencial'],
            [1009297,'la62_quantidade','int4','Quantidade de atendimentos realizados.','0', 'Quantidade',10,'f','f','f',1,'text','Quantidade'],
            [1009298,'la62_data','date','Data na qual os atendimentos foram marcados.','null', 'Data de Atendimento',10,'f','f','f',1,'text','Data de Atendimento'],
            [1009303,'la62_limiteatendimento','int4','Vínculo com a configuração do limite de atendimento.','0', 'Código do Limite de Atendimento',10,'f','f','f',1,'text','Código do Limite de Atendimento'],
            [1009299,'la63_sequencial','int4','Código sequencial.','0', 'Sequencial',10,'f','f','f',1,'text','Sequencial'],
            [1009300,'la63_quantidade','int4','Quantidade de exames realizados.','0', 'Quantidade',10,'f','f','f',1,'text','Quantidade'],
            [1009301,'la63_data','date','Data na qual os exames foram marcados.','null', 'Data',10,'f','f','f',1,'text','Data'],
            [1009302,'la63_lab_setorexame','int4','Vínculo com o exame.','0', 'Exame',10,'f','f','f',1,'text','Exame'],
        ];
        $table    = $this->table('db_syscampo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os campos as tabelas
        $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
        $aValues  = [
            [1010198,1009290,1,0],
            [1010198,1009291,2,0],
            [1010198,1009292,3,0],
            [1010199,1009293,1,0],
            [1010199,1009295,2,0],
            [1010199,1009294,3,0],
            [1010200,1009296,1,0],
            [1010200,1009297,3,0],
            [1010200,1009298,2,0],
            [1010200,1009303,4,0],
            [1010201,1009299,1,0],
            [1010201,1009300,2,0],
            [1010201,1009301,3,0],
            [1010201,1009302,4,0],
        ];
        $table    = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave primaria
        $aColumns = ['codarq','codcam','sequen','camiden'];
        $aValues  = [
            [1010198,1009290,1,1009290],
            [1010199,1009293,1,1009293],
            [1010200,1009296,1,1009296],
            [1010201,1009299,1,1009299],
        ];
        $table    = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a chave estrangeira
        $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
        $aValues  = [
            [1010198,1009291,1,2753,0],
            [1010199,1009294,1,2759,0],
            [1010201,1009302,1,2759,0],
            [1010200,1009303,1,1010198,0],
        ];
        $table    = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui os indices
        $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
        $aValues  = [
            [1008194,'limiteatendimento_lab_laboratorio_in',1010198,'0'],
            [1008195,'limiteatendimentoexame_lab_setorexame_in',1010199,'0'],
            [1008196,'limiteatendimentoexameusado_lab_setorexame_in',1010201,'0'],
            [1008197,'limiteatendimentousado_limiteatendimento_in',1010200,'0'],
        ];
        $table    = $this->table('db_sysindices', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os indices
        $aColumns = ['codind', 'codcam', 'sequen'];
        $aValues  = [
            [1008194,1009291,1],
            [1008195,1009294,1],
            [1008196,1009302,1],
            [1008197,1009303,1],
        ];
        $table    = $this->table('db_syscadind', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui a sequence
        $aColumns = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
        $aValues  = [
            [1000664, 'limiteatendimento_la45_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
            [1000665, 'limiteatendimentoexame_la46_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
            [1000666, 'limiteatendimentousado_la62_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
            [1000667, 'limiteatendimentoexameusado_la63_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
        ];
        $table    = $this->table('db_syssequencia', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();
    }

    private function createTable()
    {
        $this->execute("CREATE SEQUENCE laboratorio.limiteatendimento_la45_sequencial_seq");
        $tabela = $this->table('limiteatendimento',  ['schema'=>'laboratorio', 'id'=> false, 'primary_key'=>'la45_sequencial', 'constraint'=>'limiteatendimento_la45_sequencial_pk']);
        $tabela->addColumn('la45_sequencial', 'integer')
               ->addColumn('la45_quantidade', 'integer')
               ->addColumn('la45_lab_laboratorio', 'integer')
               ->addForeignKey('la45_lab_laboratorio', 'laboratorio.lab_laboratorio', 'la02_i_codigo', ['constraint'=>'limiteatendimento_la45_lab_laboratorio_fk'])
               ->addIndex(['la45_lab_laboratorio'], ['name' => 'limiteatendimento_lab_laboratorio_in'])
               ->create();
        $this->execute("ALTER TABLE laboratorio.limiteatendimento ALTER COLUMN la45_sequencial SET DEFAULT nextval('laboratorio.limiteatendimento_la45_sequencial_seq')");

        $this->execute("CREATE SEQUENCE laboratorio.limiteatendimentoexame_la46_sequencial_seq");
        $tabela = $this->table('limiteatendimentoexame',  ['schema'=>'laboratorio', 'id'=> false, 'primary_key'=>'la46_sequencial', 'constraint'=>'limiteatendimentoexame_la46_sequencial_pk']);
        $tabela->addColumn('la46_sequencial', 'integer')
               ->addColumn('la46_quantidade', 'integer')
               ->addColumn('la46_lab_setorexame', 'integer')
               ->addForeignKey('la46_lab_setorexame', 'laboratorio.lab_setorexame', 'la09_i_codigo', ['constraint'=>'limiteatendimentoexame_la46_lab_setorexame_fk'])
               ->addIndex(['la46_lab_setorexame'], ['name' => 'limiteatendimentoexame_lab_setorexame_in'])
               ->create();
        $this->execute("ALTER TABLE laboratorio.limiteatendimentoexame ALTER COLUMN la46_sequencial SET DEFAULT nextval('laboratorio.limiteatendimentoexame_la46_sequencial_seq')");

        $this->execute("CREATE SEQUENCE laboratorio.limiteatendimentousado_la62_sequencial_seq");
        $tabela = $this->table('limiteatendimentousado',  ['schema'=>'laboratorio', 'id'=> false, 'primary_key'=>'la62_sequencial', 'constraint'=>'limiteatendimentousado_la62_sequencial_pk']);
        $tabela->addColumn('la62_sequencial', 'integer')
               ->addColumn('la62_quantidade', 'integer')
               ->addColumn('la62_data', 'date')
               ->addColumn('la62_limiteatendimento', 'integer')
               ->addForeignKey('la62_limiteatendimento', 'laboratorio.limiteatendimento', 'la45_sequencial', ['constraint'=>'limiteatendimentousado_la62_limiteatendimento_fk'])
               ->addIndex(['la62_limiteatendimento'], ['name' => 'limiteatendimentousado_limiteatendimento_in'])
               ->create();
        $this->execute("ALTER TABLE laboratorio.limiteatendimentousado ALTER COLUMN la62_sequencial SET DEFAULT nextval('laboratorio.limiteatendimentousado_la62_sequencial_seq')");

        $this->execute("CREATE SEQUENCE laboratorio.limiteatendimentoexameusado_la63_sequencial_seq");
        $tabela = $this->table('limiteatendimentoexameusado',  ['schema'=>'laboratorio', 'id'=> false, 'primary_key'=>'la63_sequencial', 'constraint'=>'limiteatendimentoexameusado_la63_sequencial_pk']);
        $tabela->addColumn('la63_sequencial', 'integer')
               ->addColumn('la63_quantidade', 'integer')
               ->addColumn('la63_data', 'date')
               ->addColumn('la63_lab_setorexame', 'integer')
               ->addForeignKey('la63_lab_setorexame', 'laboratorio.lab_setorexame', 'la09_i_codigo', ['constraint'=>'limiteatendimentoexameusado_la63_lab_setorexame_fk'])
               ->addIndex(['la63_lab_setorexame'], ['name' => 'limiteatendimentoexameusado_lab_setorexame_in'])
               ->create();
        $this->execute("ALTER TABLE laboratorio.limiteatendimentoexameusado ALTER COLUMN la63_sequencial SET DEFAULT nextval('laboratorio.limiteatendimentoexameusado_la63_sequencial_seq')");
    }

    public function down()
    {
        $this->execute('insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 8173 ,8735 ,11 ,8167 )');
        $this->execute('delete from configuracoes.db_menu      where id_item_filho = 10421 and modulo = 8167');
        $this->execute('delete from configuracoes.db_menu      where id_item_filho = 10420 and modulo = 8167');
        $this->execute('delete from configuracoes.db_itensmenu where id_item = 10421');
        $this->execute('delete from configuracoes.db_itensmenu where id_item = 10420');

        $this->execute('delete from configuracoes.db_syscadind  where codind in (1008194, 1008195, 1008196, 1008197) ');
        $this->execute('delete from configuracoes.db_sysindices where codind in (1008194, 1008195, 1008196, 1008197) ');
        $this->execute('delete from configuracoes.db_sysforkey where codarq in (1010198, 1010199, 1010200, 1010201) ');
        $this->execute('delete from configuracoes.db_sysprikey where codarq in (1010198, 1010199, 1010200, 1010201) ');
        $this->execute('delete from configuracoes.db_sysarqcamp where codarq in (1010198, 1010199, 1010200, 1010201) ');

        $this->execute('delete from configuracoes.db_syscampo   where codcam in (1009290, 1009291, 1009292, 1009293, 1009295, 1009294, 1009296, 1009297, 1009298, 1009299, 1009300, 1009301, 1009302, 1009303) ');
        $this->execute('delete from configuracoes.db_syssequencia where codsequencia in (1000664, 1000665, 1000666, 1000667) ');
        $this->execute('delete from configuracoes.db_sysarqmod  where codarq in(1010198, 1010199, 1010200, 1010201)');
        $this->execute('delete from configuracoes.db_sysarquivo where codarq in(1010198, 1010199, 1010200, 1010201)');

        $this->execute('drop table if exists laboratorio.limiteatendimentousado');
        $this->execute('drop sequence if exists laboratorio.limiteatendimentousado_la62_sequencial_seq');
        $this->execute('drop table if exists laboratorio.limiteatendimento');
        $this->execute('drop sequence if exists laboratorio.limiteatendimento_la45_sequencial_seq');
        $this->execute('drop table if exists laboratorio.limiteatendimentoexame');
        $this->execute('drop sequence if exists laboratorio.limiteatendimentoexame_la46_sequencial_seq');
        $this->execute('drop table if exists laboratorio.limiteatendimentoexameusado');
        $this->execute('drop sequence if exists laboratorio.limiteatendimentoexameusado_la63_sequencial_seq');
    }
}
