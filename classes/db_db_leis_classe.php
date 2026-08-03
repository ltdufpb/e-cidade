<?php 
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBSeller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

//MODULO: prefeitura
//CLASSE DA ENTIDADE db_leis
class cl_db_leis { 
   // cria variaveis de erro 
   public $rotulo     = null; 
   public $query_sql  = null; 
   public $numrows    = 0; 
   public $numrows_incluir = 0; 
   public $numrows_alterar = 0; 
   public $numrows_excluir = 0; 
   public $erro_status= null; 
   public $erro_sql   = null; 
   public $erro_banco = null;  
   public $erro_msg   = null;  
   public $erro_campo = null;  
   public $pagina_retorno = null; 
   // cria variaveis do arquivo 
   public $id_lei = 0; 
   public $numerolei = null; 
   public $datalei_dia = null; 
   public $datalei_mes = null; 
   public $datalei_ano = null; 
   public $datalei = null; 
   public $ementa = null; 
   public $texto = null; 
   public $documento = null; 
   // cria propriedade com as variaveis do arquivo 
   public $campos = "
                 id_lei = int4 = Lei 
                 numerolei = varchar(20) = Número 
                 datalei = date = Data 
                 ementa = varchar(200) = Ementa 
                 texto = text = texto 
                 documento = text = Documento 
                 ";
   //funcao construtor da classe 
   function __construct() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("db_leis"); 
     $this->pagina_retorno =  basename((string) $GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
   }
   //funcao erro 
   function erro($mostra,$retorna) { 
     if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
        echo "<script>alert(\"".$this->erro_msg."\");</script>";
        if($retorna==true){
           echo "<script>location.href='".$this->pagina_retorno."'</script>";
        }
     }
   }
   // funcao para atualizar campos
   function atualizacampos($exclusao=false) {
     if($exclusao==false){
       $this->id_lei = ($this->id_lei == ""?@$GLOBALS["HTTP_POST_VARS"]["id_lei"]:$this->id_lei);
       $this->numerolei = ($this->numerolei == ""?@$GLOBALS["HTTP_POST_VARS"]["numerolei"]:$this->numerolei);
       if($this->datalei == ""){
         $this->datalei_dia = ($this->datalei_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["datalei_dia"]:$this->datalei_dia);
         $this->datalei_mes = ($this->datalei_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["datalei_mes"]:$this->datalei_mes);
         $this->datalei_ano = ($this->datalei_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["datalei_ano"]:$this->datalei_ano);
         if($this->datalei_dia != ""){
            $this->datalei = $this->datalei_ano."-".$this->datalei_mes."-".$this->datalei_dia;
         }
       }
       $this->ementa = ($this->ementa == ""?@$GLOBALS["HTTP_POST_VARS"]["ementa"]:$this->ementa);
       $this->texto = ($this->texto == ""?@$GLOBALS["HTTP_POST_VARS"]["texto"]:$this->texto);
       $this->documento = ($this->documento == ""?@$GLOBALS["HTTP_POST_VARS"]["documento"]:$this->documento);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){ 
      $this->atualizacampos();
     if($this->id_lei == null ){ 
       $this->erro_sql = " Campo Lei nao Informado.";
       $this->erro_campo = "id_lei";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->numerolei == null ){ 
       $this->erro_sql = " Campo Número nao Informado.";
       $this->erro_campo = "numerolei";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->datalei == null ){ 
       $this->erro_sql = " Campo Data nao Informado.";
       $this->erro_campo = "datalei_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ementa == null ){ 
       $this->erro_sql = " Campo Ementa nao Informado.";
       $this->erro_campo = "ementa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->texto == null ){ 
       $this->erro_sql = " Campo texto nao Informado.";
       $this->erro_campo = "texto";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->documento == null ){ 
       $this->erro_sql = " Campo Documento nao Informado.";
       $this->erro_campo = "documento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into db_leis(
                                       id_lei 
                                      ,numerolei 
                                      ,datalei 
                                      ,ementa 
                                      ,texto 
                                      ,documento 
                       )
                values (
                                $this->id_lei 
                               ,'$this->numerolei' 
                               ,".($this->datalei == "null" || $this->datalei == ""?"null":"'".$this->datalei."'")." 
                               ,'$this->ementa' 
                               ,'$this->texto' 
                               ,'$this->documento' 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( !str_starts_with(strtolower($this->erro_banco), "duplicate key") ){
         $this->erro_sql   = "Leis () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Leis já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Leis () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ( $oid=null ) { 
      $this->atualizacampos();
     $sql = " update db_leis set ";
     $virgula = "";
     if(trim((string) $this->id_lei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["id_lei"])){ 
       $sql  .= $virgula." id_lei = $this->id_lei ";
       $virgula = ",";
       if(trim((string) $this->id_lei) == null ){ 
         $this->erro_sql = " Campo Lei nao Informado.";
         $this->erro_campo = "id_lei";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim((string) $this->numerolei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["numerolei"])){ 
       $sql  .= $virgula." numerolei = '$this->numerolei' ";
       $virgula = ",";
       if(trim((string) $this->numerolei) == null ){ 
         $this->erro_sql = " Campo Número nao Informado.";
         $this->erro_campo = "numerolei";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim((string) $this->datalei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["datalei_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["datalei_dia"] !="") ){ 
       $sql  .= $virgula." datalei = '$this->datalei' ";
       $virgula = ",";
       if(trim((string) $this->datalei) == null ){ 
         $this->erro_sql = " Campo Data nao Informado.";
         $this->erro_campo = "datalei_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["datalei_dia"])){ 
         $sql  .= $virgula." datalei = null ";
         $virgula = ",";
         if(trim((string) $this->datalei) == null ){ 
           $this->erro_sql = " Campo Data nao Informado.";
           $this->erro_campo = "datalei_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim((string) $this->ementa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ementa"])){ 
       $sql  .= $virgula." ementa = '$this->ementa' ";
       $virgula = ",";
       if(trim((string) $this->ementa) == null ){ 
         $this->erro_sql = " Campo Ementa nao Informado.";
         $this->erro_campo = "ementa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim((string) $this->texto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["texto"])){ 
       $sql  .= $virgula." texto = '$this->texto' ";
       $virgula = ",";
       if(trim((string) $this->texto) == null ){ 
         $this->erro_sql = " Campo texto nao Informado.";
         $this->erro_campo = "texto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim((string) $this->documento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["documento"])){ 
       $sql  .= $virgula." documento = '$this->documento' ";
       $virgula = ",";
       if(trim((string) $this->documento) == null ){ 
         $this->erro_sql = " Campo Documento nao Informado.";
         $this->erro_campo = "documento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
$sql .= "oid = '$oid'";     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Leis nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Leis nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ( $oid=null ,$dbwhere=null) { 
     $sql = " delete from db_leis
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
       $sql2 = "oid = '$oid'";
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Leis nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Leis nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = db_query($sql);
     if($result==false){
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_num_rows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:db_leis";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
}
?>