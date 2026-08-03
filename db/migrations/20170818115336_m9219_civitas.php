<?php

use Classes\PostgresMigration;

class M9219Civitas extends PostgresMigration
{

    public function up()
    {
        $this->criarMenu();
        $this->addDicionarioDados();
        $this->criarTabela();
    }

    public function down()
    {
        $this->removeritensMenu();
        $this->removerDicionarioDados();
        $this->removerTabela();
    }

    private function criarMenu()
    {
        // Cria o item de MENU
        $aColumns   =  ['id_item' ,'descricao' ,'help' ,'funcao' ,'itemativo' ,'manutencao' ,'desctec' ,'libcliente'];
        $aValues    =  [
            [10436 ,'Importação' ,'Importação' ,'cad4_importacaorecadastramento.php' ,'1' ,'1' ,'Importação dos dados atuais das matrículas' ,'true'],
            [10437 ,'Recadastramento' ,'Recadastramento' ,'' ,'1' ,'1' ,'Recadastramento das matrículas' ,'true'],
            [10438 ,'Processar' ,'Processamento dos dados importados do recadastramento' ,'cad4_processarrecadastramento.php' ,'1' ,'1' ,'Processamento dos dados importados do recadastramento.' ,'true'],
        ];
        $table      = $this->table('db_itensmenu', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();


        // Víncula item de menu
        $aColumns   =    ['id_item', 'id_item_filho', 'menusequencia', 'modulo'];
        $aValues    =    [
            [32 ,10437 ,486 ,578],
            [10437 ,10436 ,1 ,578],
            [10437 ,10438 ,2 ,578],
        ];
        $table      =  $this->table('db_menu', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        $this->execute("update db_itensmenu set id_item = 10437 , descricao = 'Recadastramento' , help = 'Recadastramento' , itemativo = '1' , manutencao = '1' , desctec = 'Recadastramento das matrículas' , libcliente = 'false' where id_item = 10437");
    }

    private function addDicionarioDados()
    {
        // Cadastro de Tabelas
        $aColumns  = ['codarq', 'nomearq', 'descricao', 'sigla', 'dataincl', 'rotulo', 'tipotabela', 'naolibclass', 'naolibfunc', 'naolibprog', 'naolibform'];
        $aValues   = [
            [1010217, 'atualizacaoiptuschema', 'Guarda a informação da importação dos dados dos imóveis e em qual schema estão as informações.', 'j142', '2017-08-18', 'Atualização do IPTU', 0, 'f', 'f', 'f', 'f' ],
            [1010218, 'atualizacaoiptuschemaarquivo', 'Arquivos importados para atualização de cadastros imobiliários.', 'j143', '2017-08-22', 'Arquivo Importado', 0, 'f', 'f', 'f', 'f'  ],
            [1010219, 'atualizacaoiptuschemamatricula', 'Guarda as matrículas que foram atualizadas o cadastro imobiliário.', 'j144', '2017-08-22', 'Matrículas Atualizadas', 0, 'f', 'f', 'f', 'f' ],
        ];
        $table     = $this->table('db_sysarquivo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Vínculo da tabela com o módulo
        $aColumns  =  ['codmod', 'codarq'];
        $aValues   =  [
            [2,1010217],
            [2,1010218],
            [2,1010219],
        ];
        $table     =  $this->table('db_sysarqmod', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Cadastro de campos
        $aColumns  = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
        $aValues   = [
            [1009394,'j142_sequencial','int4','Sequencial da tabela.','0', 'Sequencial',10,'f','f','f',1,'text','Sequencial'],
            [1009396,'j142_schema','varchar(255)','Nome do local onde os dados importados estão.','', 'Dados Importados',255,'f','t','f',0,'text','Dados Importados'],
            [1009398,'j142_dataarquivo','date','Data dos dados do arquivo de importação de quando eles foram gerados.','null', 'Data do Arquivo',10,'f','f','f',1,'text','Data do Arquivo'],

            [1009397,'j143_dataimportacao','date','Data da importação.','null', 'Data da Importação',10,'f','f','f',1,'text','Data da Importação'],
            [1009395,'j143_arquivo','varchar(255)','Nome do arquivo importado.','', 'Nome do Arquivo',255,'f','t','f',0,'text','Nome do Arquivo'],
            [1009399,'j143_atualizacaoiptuschema','int4','Vínculo com o nome do schema com os dados de IPTU atualizados.','0', 'Atualização IPTU',10,'f','f','f',1,'text','Atualização IPTU'],
            [1009400,'j143_sequencial','int4','Código da tabela.','0', 'Sequencial',10,'f','f','f',1,'text','Sequencial'],

            [1009401,'j144_matricula','int4','Matrícula','0', 'Matrícula',10,'f','f','f',1,'text','Matrícula'],
            [1009402,'j144_atualizacaoiptuschema','int4','Vínculo com o schema.','0', 'Dados de Importação',10,'f','f','f',1,'text','Dados de Importação'],
            [1009403,'j144_situacao','int4','Situação que a matrícula se encontra (Nova/Atualizada/Rejeitada).','0', 'Situação',10,'f','f','f',1,'text','Situação'],
            [1009408,'j144_sequencial','int4','Sequencial','0', 'Sequencial',10,'f','f','f',1,'text','Sequencial'],
        ];
        $table     = $this->table('db_syscampo', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Vínculo dos campos com a tabela
        $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
        $aValues  = [
            [1010217,1009394,1,0],
            [1010217,1009396,3,0],
            [1010217,1009398,5,0],
            [1010218,1009400,1,0],
            [1010218,1009399,2,0],
            [1010218,1009395,3,0],
            [1010218,1009397,4,0],
            [1010219,1009401,1,0],
            [1010219,1009402,2,0],
            [1010219,1009403,3,0],
            [1010219,1009408,4,0],
        ];
        $table    = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Cadastro da PK
        $aColumns = ['codarq', 'codcam','sequen', 'camiden'];
        $aValues  = [
          [1010217,1009394,1,1009396],
          [1010218,1009400,1,1009395],
          [1010219,1009408,1,1009403],
        ];
        $table    = $this->table('db_sysprikey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Cadastro da FK
        $aColumns = ['codarq', 'codcam', 'sequen', 'referen', 'tipoobjrel'];
        $aValues  = [
            [1010218,1009399,1,1010217,0],
            [1010219,1009402,1,1010217,0],
        ];
        $table    = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // inclui os indices
        $aColumns = ['codind', 'nomeind', 'codarq', 'campounico'];
        $aValues  = [
            [1008217,'atualizacaoiptuschemaarquivo_atualizacaoiptuschema_in',1010218,'0'],
            [1008221,'atualizacaoiptuschemamatricula_matricula_atualizacaoiptuschema_in',1010219,'1'],
        ];
        $table    = $this->table('db_sysindices', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // vincula os indices
        $aColumns = ['codind', 'codcam', 'sequen'];
        $aValues  = [
            [1008217,1009399,1],
            [1008221,1009401,1],
            [1008221,1009402,2],
        ];
        $table    = $this->table('db_syscadind', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Cadastro de sequências
        $aColumns   = ['codsequencia', 'nomesequencia', 'incrseq', 'minvalueseq', 'maxvalueseq', 'startseq', 'cacheseq'];
        $aValues    = [
          [1000681, 'atualizacaoiptuschema_j142_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
          [1000682, 'atualizacaoiptuschemaarquivo_j143_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
          [1000685, 'atualizacaoiptuschemamatricula_j144_sequencial_seq', 1, 1, 9223372036854775807, 1, 1],
        ];
        $table      =  $this->table('db_syssequencia', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();
        $this->execute("update db_sysarqcamp set codsequencia = 1000681 where codarq = 1010217 and codcam = 1009394");
        $this->execute("update db_sysarqcamp set codsequencia = 1000682 where codarq = 1010218 and codcam = 1009400");
        $this->execute("update db_sysarqcamp set codsequencia = 1000685 where codarq = 1010219 and codcam = 1009408");
    }

    private function criarTabela()
    {
        $this->execute("CREATE SEQUENCE cadastro.atualizacaoiptuschema_j142_sequencial_seq");
        $atualizacaoiptuschema = $this->table('atualizacaoiptuschema', ['schema' => 'cadastro', 'id' => false, 'primary_key' => 'j142_sequencial', 'constraint' => 'cadastro.j142_sequencial_pk']);
        $atualizacaoiptuschema->addColumn('j142_sequencial',     'integer' )
                        ->addColumn('j142_schema',         'string', ['limit' => 255] )
                        ->addColumn('j142_dataarquivo',    'date' )
                        ->create();
        $this->execute("ALTER TABLE cadastro.atualizacaoiptuschema ALTER COLUMN j142_sequencial SET DEFAULT nextval('cadastro.atualizacaoiptuschema_j142_sequencial_seq')");

        $this->execute("CREATE SEQUENCE cadastro.atualizacaoiptuschemaarquivo_j143_sequencial_seq");
        $atualizacaoiptuschema = $this->table('atualizacaoiptuschemaarquivo', ['schema' => 'cadastro', 'id' => false, 'primary_key' => 'j143_sequencial', 'constraint' => 'cadastro.j143_sequencial_pk']);
        $atualizacaoiptuschema->addColumn('j143_sequencial',     'integer' )
                        ->addColumn('j143_arquivo',        'string', ['limit' => 255] )
                        ->addColumn('j143_dataimportacao', 'date' )
                        ->addColumn('j143_atualizacaoiptuschema', 'integer' )
                        ->addForeignKey('j143_atualizacaoiptuschema', 'cadastro.atualizacaoiptuschema', 'j142_sequencial', ['constraint'=>'atualizacaoiptuschemaarquivo_ed143_atualizacaoiptuschema_fk'])
                        ->addIndex(['j143_atualizacaoiptuschema'], ['name' => 'atualizacaoiptuschemaarquivo_atualizacaoiptuschema_in'])
                        ->create();
        $this->execute("ALTER TABLE cadastro.atualizacaoiptuschemaarquivo ALTER COLUMN j143_sequencial SET DEFAULT nextval('cadastro.atualizacaoiptuschemaarquivo_j143_sequencial_seq')");

        $this->execute("CREATE SEQUENCE cadastro.atualizacaoiptuschemamatricula_j144_sequencial_seq");
        $atualizacaoiptuschema = $this->table('atualizacaoiptuschemamatricula', ['schema' => 'cadastro', 'id' => false, 'primary_key' => ['j144_sequencial'], 'constraint' => 'cadastro.j144_sequencial_pk']);
        $atualizacaoiptuschema->addColumn('j144_sequencial',     'integer' )
                        ->addColumn('j144_matricula',     'integer' )
                        ->addColumn('j144_atualizacaoiptuschema', 'integer' )
                        ->addForeignKey('j144_atualizacaoiptuschema', 'cadastro.atualizacaoiptuschema', 'j142_sequencial', ['constraint'=>'atualizacaoiptuschemamatricula_ed144_atualizacaoiptuschema_fk'])
                        ->addIndex([ 'j144_matricula', 'j144_atualizacaoiptuschema'], ['unique' => true, 'name' => 'atualizacaoiptuschemamatricula_matricula_atualizacaoiptuschema_in'])
                        ->addColumn('j144_situacao', 'integer' )
                        ->create();
        $this->execute("ALTER TABLE cadastro.atualizacaoiptuschemamatricula ALTER COLUMN j144_sequencial SET DEFAULT nextval('cadastro.atualizacaoiptuschemamatricula_j144_sequencial_seq')");

        $this->execute("insert into cgm (z01_numcgm, z01_nome) values(nextval('cgm_z01_numcgm_seq'), 'RECADASTRAMENTO CIVITAS')");
    }

    private function removeritensMenu()
    {
        $this->execute("delete from configuracoes.db_menu where id_item_filho in (10436,10437,10438) AND modulo = 578");
        $this->execute("delete from configuracoes.db_itensmenu where id_item in (10436,10437,10438)");
    }

    public function removerDicionarioDados()
    {
        $this->execute('delete from configuracoes.db_syscadind  where codind in (1008217, 1008221) ');
        $this->execute('delete from configuracoes.db_sysindices where codind in (1008217, 1008221) ');
        $this->execute('delete from configuracoes.db_sysforkey where codarq in (1010218, 1010219) ');
        $this->execute("delete from configuracoes.db_sysarqcamp where codcam in (1009394, 1009395, 1009396, 1009397, 1009398, 1009400, 1009399, 1009401, 1009402, 1009403, 1009408)");
        $this->execute('delete from configuracoes.db_sysprikey where codarq in(1010217, 1010218, 1010219)');
        $this->execute('delete from configuracoes.db_sysarqmod where codarq in(1010217, 1010218, 1010219)');
        $this->execute('delete from configuracoes.db_sysarquivo where codarq in(1010217, 1010218, 1010219)');
        $this->execute('delete from configuracoes.db_syssequencia where codsequencia in(1000681, 1000682, 1000685)');
        $this->execute("delete from configuracoes.db_syscampo where codcam in (1009394, 1009395, 1009396, 1009397, 1009398, 1009400, 1009399, 1009401, 1009402, 1009403, 1009408)");
    }


    private function removerTabela()
    {
        $this->execute("delete from cgm where z01_nome = 'RECADASTRAMENTO CIVITAS'");
        $this->execute("DROP TABLE IF EXISTS atualizacaoiptuschemamatricula");
        $this->execute("DROP SEQUENCE IF EXISTS atualizacaoiptuschemamatricula_j144_sequencial_seq;");
        $this->execute("DROP TABLE IF EXISTS atualizacaoiptuschemaarquivo");
        $this->execute("DROP SEQUENCE IF EXISTS atualizacaoiptuschemaarquivo_j143_sequencial_seq;");
        $this->execute("DROP TABLE IF EXISTS atualizacaoiptuschema");
        $this->execute("DROP SEQUENCE IF EXISTS atualizacaoiptuschema_j142_sequencial_seq;");
    }
}
