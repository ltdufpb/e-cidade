<?php 
abstract class RotuloBasica {

  public function makePropertiesDDField ($oCampo) {

    $aMapVariavelCampo = [ "I"  => mb_convert_encoding($oCampo->aceitatipo, 'ISO-8859-1'),
                                "A"  => mb_convert_encoding($oCampo->autocompl, 'ISO-8859-1'), // verificar
                                "U"  => mb_convert_encoding($oCampo->null, 'ISO-8859-1'),
                                "G"  => mb_convert_encoding($oCampo->uppercase, 'ISO-8859-1'),
                                "S"  => mb_convert_encoding($oCampo->label, 'ISO-8859-1'),
                                "L"  => mb_convert_encoding($oCampo->label, 'ISO-8859-1'),     // verificar
                                "LS" => mb_convert_encoding($oCampo->label, 'ISO-8859-1'),
                                "T"  => mb_convert_encoding($oCampo->description, 'ISO-8859-1'),
                                "M"  => mb_convert_encoding($oCampo->size, 'ISO-8859-1'),
                                "N"  => mb_convert_encoding($oCampo->null, 'ISO-8859-1'),      // verificar
                                "RL" => mb_convert_encoding($oCampo->labelrel, 'ISO-8859-1'),
                                "TC" => mb_convert_encoding($oCampo->datatype, 'ISO-8859-1') ];

    foreach ( $aMapVariavelCampo as $sPrefixvar => $sValor ) {
      

      global ${$sPrefixvar.$oCampo->name};
      ${$sPrefixvar.$oCampo->name} = $sValor;          
    }

    /// variavel para determinar o autocomplete
    if (${"A".$oCampo->name} == 'f') {
      ${"A".$oCampo->name} = "off";
    } else {
      ${"A".$oCampo->name} = "on";
    }

    /// variavel para colocar como label de campo
    ${"L".$oCampo->name} = "<strong>".${"L".$oCampo->name}.":</strong>";

    /// variavel para controle de campos nulos
    if (${"N".$oCampo->name} == "t"){
      ${"N".$oCampo->name} = "style=\"background-color:#E6E4F1\"";
    } else {
      ${"N".$oCampo->name} = "";
    }
  }
}
