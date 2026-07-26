<?php

class DDSequenceXML {
  
  public function __construct(private readonly DOMNode $oSequenceXml)
  {
  }
  
  public function __get($sName){    
    return $this->oSequenceXml->getAttribute($sName);          
  }
  
}
