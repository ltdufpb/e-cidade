<?php

use Classes\PostgresMigration;

class M8641DispensaPontoEletronico extends PostgresMigration
{

  public function up()
  {
    $this->criarDicionario();
    $this->adicionarCampo();
  }

  public function down()
  {
    $this->removerCampo();
    $this->excluirDicionario();
  }

  private function criarDicionario() {

    // campos
    $aColumns = ['codcam', 'nomecam', 'conteudo', 'descricao', 'valorinicial', 'rotulo', 'tamanho', 'nulo', 'maiusculo', 'autocompl', 'aceitatipo', 'tipoobj', 'rotulorel'];
    $aValues  = [
      [1009351,'rh01_registrapontoeletronico','bool','Controla se o servidor bate o ponto ou se ele é lançado automaticamente, de acordo com a sua jornada.','t', 'Registra Ponto Eletrônico',1,'f','f','f',5,'text','Registra Ponto Eletrônico'],
    ];
    $table = $this->table('db_syscampo', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();

    // vincula os campos as tabelas
    $aColumns = ['codarq', 'codcam', 'seqarq', 'codsequencia'];
    $aValues  = [
      [1153,1009351,27,0],
    ];
    $table    = $this->table('db_sysarqcamp', ['schema' => 'configuracoes']);
    $table->insert($aColumns, $aValues);
    $table->saveData();
  }

  private function adicionarCampo() {

    $this->table('rhpessoal',    ['schema'=>'pessoal'])
      ->addColumn('rh01_registrapontoeletronico', 'boolean', ['default' => true])
      ->save();
  }

  private function removerCampo() {

    $this->table('rhpessoal', ['schema' => 'pessoal'])
      ->removeColumn('rh01_registrapontoeletronico')
      ->save();
  }

  private function excluirDicionario() {

    $this->execute('delete from db_sysarqcamp where codcam = 1009351');
    $this->execute('delete from db_syscampo where codcam = 1009351');
  }
}
