<?php

use \ECidade\V3\Extension\Registry;

class DBTooltipAviso {

  /**
   * Representa a instância da classe.
   *
   * @var DBTooltipAviso
   */
  private static $oInstance;

  /**
   * Construtor do aviso
   * @param string $sLabel
   * @param string $sAction
   */
  public function __construct(
      /**
       * String com o label a ser mostrado
       */
      private $sLabel,
      /**
       * String com a ação a executar,
       * redirecionar a página
       * abrir uma modal
       */
      private $sAction
  )
  {
  }

  /**
   * Renderiza um aviso
   *
   * @return String
   */
  public function render() {

    if (empty($this->sLabel)) {
      return;
    }

    if (empty($this->sAction)) {
      return;
    }

    $sHtml  = '<div class="db-tooltip-aviso-button">'.PHP_EOL;
    $sHtml .= '  <script type="text/javascript">'.PHP_EOL;
    $sHtml .= '    var lHasReleaseNoteBtnPrevia = false;'.PHP_EOL;

    if (Registry::get('app.container')->get('ECIDADE_DESKTOP')) {
      $sHtml .= "  $('container').parentElement.childElements('div').each(function(node, i) {     \n";
    } else {
      $sHtml .= "  $('db-menu').parentElement.childElements('div').each(function(node, i) {       \n";
    }

    $sHtml .= "      if(node.hasClassName('db-release-note-previa')) {                            \n";
    $sHtml .= "        lHasReleaseNoteBtnPrevia = true;                                           \n";
    $sHtml .= "      }                                                                            \n";
    $sHtml .= "    });                                                                            \n";
    $sHtml .= "    if(lHasReleaseNoteBtnPrevia) {                                                 \n";
    $sHtml .= "      $$('.db-tooltip-aviso-button')[0].addClassName('has-release-note-button')    \n";
    $sHtml .= "    } else {                                                                       \n";
    $sHtml .= "      $$('.db-tooltip-aviso-button')[0].removeClassName('has-release-note-button') \n";
    $sHtml .= "    }                                                                              \n";
    $sHtml .= '  </script>'.PHP_EOL;
    $sHtml .= '  <a onclick="'. $this->sAction .'">'. $this->sLabel .'</a>'.PHP_EOL;
    $sHtml .= '</div>'.PHP_EOL;

    return $sHtml;
  }

  /**
   * Retorna uma instancia da classe para renderizar um aviso
   */
  public static function getInstance($sLabel, $sAction) {

    if (self::$oInstance == null) {
      self::$oInstance = new DBTooltipAviso($sLabel, $sAction);
    }

    return self::$oInstance;
  }
}
