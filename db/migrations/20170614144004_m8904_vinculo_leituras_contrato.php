<?php

use Classes\PostgresMigration;

class M8904VinculoLeiturasContrato extends PostgresMigration
{
  public function up() {

    $oSysCampoTable = $this->table('db_syscampo', ['schema' => 'configuracoes']);
    $aSysCampoData = [
      'codcam'       => 1009335,
      'nomecam'      => 'x21_aguacontrato',
      'conteudo'     => 'int4',
      'descricao'    => 'Contrato',
      'valorinicial' => '',
      'rotulo'       => 'Contrato',
      'tamanho'      => 10,
      'nulo'         => 'true',
      'maiusculo'    => 'false',
      'autocompl'    => 'false',
      'aceitatipo'   => 1,
      'tipoobj'      => 'text',
      'rotulorel'     => 'Contrato',
    ];
    $oSysCampoTable->insert(array_keys($aSysCampoData), [array_values($aSysCampoData)]);
    $oSysCampoTable->save();

    $oSysArqCampTable = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
    $aSysArqCampData = [
      'codarq'       => 1439,
      'codcam'       => 1009335,
      'seqarq'       => 17,
      'codsequencia' => 0,
    ];
    $oSysArqCampTable->insert(array_keys($aSysArqCampData), [array_values($aSysArqCampData)]);
    $oSysArqCampTable->save();

    $oSysForKeyTable = $this->table('db_sysforkey', ['schema' => 'configuracoes']);
    $oSysForKeyData = [
      'codarq'     => 1439,
      'codcam'     => 1009335,
      'sequen'     => 1,
      'referen'    => 3966,
      'tipoobjrel' => 0
    ];
    $oSysForKeyTable->insert(array_keys($oSysForKeyData), [array_values($oSysForKeyData)]);

    $oAguaLeitura = $this->table('agualeitura', ['schema' => 'agua']);
    $oAguaLeitura->addColumn('x21_aguacontrato', 'integer', [
      'null' => true,
      'default' => null
    ]);
    $oAguaLeitura->addForeignKey('x21_aguacontrato', 'agua.aguacontrato', 'x54_sequencial', [
      'constraint' => 'agualeitura_aguacontrato_fk'
    ]);
    $oAguaLeitura->save();

    $this->execute('alter table agua.agualeitura disable trigger user');
  }

  public function down() {

    $this->execute('delete from configuracoes.db_sysforkey  where codarq = 1439 and codcam = 1009335');
    $this->execute('delete from configuracoes.db_sysarqcamp where codarq = 1439 and codcam = 1009335');
    $this->execute('delete from configuracoes.db_syscampo   where codcam = 1009335');

    $oAguaCorteSituacao = $this->table('agualeitura', ['schema' => 'agua']);
    $oAguaCorteSituacao->removeColumn('x21_aguacontrato');
    $oAguaCorteSituacao->save();

    $this->execute('alter table agua.agualeitura enable trigger user');
  }
}
