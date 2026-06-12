<?php

class DDFieldFkXML {
  
  public function __construct(private readonly DOMNode $oFieldFkXml)
  {
  }

  public function __get($sName){
    return $this->oFieldFkXml->getAttribute($sName);          
  }
  
}
