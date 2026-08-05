<?php

class DDFkXML {
  
  public function __construct(private readonly DOMNode $oFkXml)
  {
  }

  public function __get($sName){
    return $this->oFkXml->getAttribute($sName);          
  }

  public function getFields() {  	
  	$aFields = [];
  	foreach ( $this->oFkXml->getElementsByTagName("fieldfk") as $oFieldFk ) {
  	  $aFields[] = new DDFieldFkXML($oFieldFk);
  	}
  	return $aFields;  	
  }
}
