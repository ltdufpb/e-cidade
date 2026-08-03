<?php

use Classes\PostgresMigration;

class M10202FeriasRondonia extends PostgresMigration
{
    public function up()
    {
        $this->dicionarioUp();
        $this->ddlUp();
        $this->migraDiasPagar();
    }

    public function down()
    {
        $this->dicionarioDown();
        $this->ddlDown();
    }

    private function dicionarioUp()
    {
        $tableDBSysCampo = $this->table('db_syscampo', ['schema' => 'configuracoes']);
        $tableDBSysCampo->insert(
          ['codcam','nomecam','conteudo','descricao','valorinicial','rotulo','tamanho','nulo',  'maiusculo','autocompl','aceitatipo','tipoobj','rotulorel'],
          [
            [1009632,'rh110_diaspagar','int4','Número de dias a pagar referente ao período lançado.','0', 'Dias a Pagar',10,'f','f','f',1,'text','Dias a Pagar'],
            [1009635,'rh110_temdireitotercoabono','bool','Controla se para o período de férias, tem direito a 1/3 de abono, quando houverem dias abonados.','f', 'Direito a 1/3 de Abono',1,'f','f','f',5,'text','Direito a 1/3 de Abono']
          ]
        );
        $tableDBSysCampo->saveData();

        $tableDBSysArqCamp = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
        $tableDBSysArqCamp->insert(
          ['codarq', 'codcam', 'seqarq', 'codsequencia'],
          [
            [3374,1009632,15,0],
            [3374,1009635,16,0]
          ]
        );
    }

    private function ddlUp()
    {
        $tableRhFeriasPeriodo = $this->table('rhferiasperiodo', ['schema' => 'pessoal']);
        $tableRhFeriasPeriodo->addColumn('rh110_diaspagar', 'integer', ['null' => true]);
        $tableRhFeriasPeriodo->addColumn('rh110_temdireitotercoabono', 'boolean', ['default' => true]);
        $tableRhFeriasPeriodo->save();
    }

    private function dicionarioDown()
    {
        $this->execute('delete from db_sysarqcamp where codarq = 3374 and codcam in(1009632, 1009635)');
        $this->execute('delete from db_syscampo where codcam in(1009632, 1009635)');
    }

    private function ddlDown()
    {
        $tableRhFeriasPeriodo = $this->table('rhferiasperiodo', ['schema' => 'pessoal']);
        $tableRhFeriasPeriodo->removeColumn('rh110_diaspagar');
        $tableRhFeriasPeriodo->removeColumn('rh110_temdireitotercoabono');
        $tableRhFeriasPeriodo->save();

        $this->execute("DROP TABLE migracao_cadferia_10202");
    }

    private function migraDiasPagar()
    {
        $this->execute('update rhferiasperiodo set rh110_diaspagar = rh110_dias + rh110_diasabono');

        $tableRhFeriasPeriodo = $this->table('rhferiasperiodo', ['schema' => 'pessoal']);
        $tableRhFeriasPeriodo->changeColumn('rh110_diaspagar', 'integer', ['null' => false]);
        $tableRhFeriasPeriodo->save();
    }
}
