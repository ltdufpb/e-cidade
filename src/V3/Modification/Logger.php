<?php
namespace ECidade\V3\Modification;

use \ECidade\V3\Extension\Logger as ExtensionLogger;
use \ECidade\V3\Extension\Registry;

class Logger extends ExtensionLogger {

  public function __construct(protected $id) {

    $this->setFile(ECIDADE_MODIFICATION_LOG_PATH . $this->id);
    if (Registry::has('app.config')) {
      $this->setVerbosity(
        Registry::get('app.config')->get('app.log.verbosity', Logger::QUIET)
      );
    }
  }

}
