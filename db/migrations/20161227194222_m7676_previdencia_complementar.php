<?php

use Classes\PostgresMigration;

class M7676PrevidenciaComplementar extends PostgresMigration
{
   public function up() 
   {
      $this->table('rhrubricas', ['schema'=>'pessoal'])
           ->addColumn('rh27_previdenciacomplementar', 'integer', ['null' => true])
           ->save();

      $aSyscampo = [
        'codcam'       => 22305,
        'nomecam'      => 'rh27_previdenciacomplementar',
        'conteudo'     => 'int4',
        'descricao'    => 'Número do CGM que corresponde a previdência complementar.',
        'valorinicial' => '0',
        'rotulo'       => 'Previdência Complementar',
        'tamanho'      => 10,
        'nulo'         => 'f',
        'maiusculo'    => 'f',
        'autocompl'    => 'f',
        'aceitatipo'   => 1,
        'tipoobj'      => 'text',
        'rotulorel'    => 'Previdência Complementar'
      ];

      $this->table('db_syscampo', ['schema'=>'configuracoes'])
           ->insert(array_keys($aSyscampo), [array_values($aSyscampo)])
           ->saveData();

      $aSysarqcamp =  [
        'codarq'       => 1177,
        'codcam'       => 22305,
        'seqarq'       => 31,
        'codsequencia' => 0
      ];
 
      $this->table('db_sysarqcamp', ['schema'=>'configuracoes'])
           ->insert(array_keys($aSysarqcamp), [array_values($aSysarqcamp)])
           ->saveData();
   }

   public function down() 
   {
      $this->table('rhrubricas', ['schema'=>'pessoal'])
           ->removeColumn('rh27_previdenciacomplementar')
           ->save();

      $this->execute('delete from db_sysarqcamp where codcam = 22305');
      $this->execute('delete from db_syscampo where codcam = 22305');
   }
}
