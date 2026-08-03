<?php

use Classes\PostgresMigration;

class M9992EnviosEsocial extends PostgresMigration
{
    public function up()
    {
        $this->criarMenu();
    }

    public function down()
    {
        $this->removeritensMenu();
    }

    private function criarMenu()
    {
        // Cria o item de MENU
        $aColumns = ['id_item' ,'descricao' ,'help' ,'funcao' ,'itemativo' ,'manutencao' ,'desctec' ,'libcliente'];
        $aValues  = [
            [10488 ,'Envios eSocial' ,'Envio de Arquivos para o eSocial' ,'eso01_agendamentoenvio.php' ,'1' ,'1' ,'Agendamento dos Eventos para ser enviado ao eSocial.' ,'true'],
        ];

        $table = $this->table('db_itensmenu', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();

        // Vincula item de menu
        $aColumns = ['id_item' ,'id_item_filho' ,'menusequencia' ,'modulo'];
        $aValues  = [
            [32 ,10488 ,496 ,10216],
        ];

        $table =  $this->table('db_menu', ['schema' => 'configuracoes']);
        $table->insert($aColumns, $aValues);
        $table->saveData();
    }

    private function removeritensMenu()
    {
        $this->execute("delete from configuracoes.db_menu where id_item_filho in (10488) AND modulo = 10216");
        $this->execute("delete from configuracoes.db_itensmenu where id_item in (10488)");
    }
}
