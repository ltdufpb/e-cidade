<?php

//class rotulo extends RotuloBasica{

class RotuloXML extends RotuloBasica {

  private $sXml       = "";
  private $sArqName   = "";
  private $sTableName = "";
  private $oTabela    = [];
  private $aCampos    = [];
  private $oDomXml    = null;

    /**
     * RotuloXML constructor.
     * @param $sTableName
     */
    public function __construct($sTableName)
    {
        $this->oTabela = DDXMLFactory::getInstance($sTableName);
        $this->aCampos = $this->oTabela->getCampos();
    }

  function rlabel($sNomeCampo = "") {

    foreach ( $this->aCampos as $oCampo ) {

      global ${"RL".$oCampo->name};
      ${"RL".$oCampo->name} = ucfirst(mb_convert_encoding($oCampo->labelrel, 'ISO-8859-1'));
      if (isset($sNomeCampo) && trim($sNomeCampo) == $oCampo->name) {
        return true;
      }

    }
  }

  function label($sNomeCampo = "") {

    foreach ( $this->aCampos as $oCampo ) {
    
      $this->makePropertiesDDField($oCampo);
      
      if (isset($sNomeCampo) && trim($sNomeCampo) == $oCampo->name) {
        return true;
      }
    }
  }

  function tlabel($sNome = "") {
  
    global ${"L".$this->oTabela->name};
    ${"L".$this->oTabela->name} = "<strong>".mb_convert_encoding($this->oTabela->label, 'ISO-8859-1').":</strong>";

    global ${"T".$this->oTabela->name};
    ${"T".$this->oTabela->name} = mb_convert_encoding($this->oTabela->description, 'ISO-8859-1');

  }
}
