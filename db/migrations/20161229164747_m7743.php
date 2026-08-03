<?php

use Classes\PostgresMigration;

class M7743 extends PostgresMigration
{

   public function up() 
   {

     $this->table('eventofinanceiroautomatico', ['schema'=>'pessoal'])
          ->addIndex(['rh181_rubrica','rh181_mes','rh181_selecao','rh181_instituicao'], ['unique' => true, 'name' => 'eventofinanceiroautomatico_rubrica_mes_selecao_instituicao_un'])
          ->save();
   }

   public function down() 
   {
     $this->table('eventofinanceiroautomatico', ['schema'=>'pessoal'])
          ->removeIndexByName('eventofinanceiroautomatico_rubrica_mes_selecao_instituicao_un')
          ->save();
   }
}
