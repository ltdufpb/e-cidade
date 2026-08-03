<?php

namespace ECidade\V3\Extension;

use \ECidade\V3\Extension\ParameterBag;

class ReferenceBag extends ParameterBag {

  /**
   * Constructor.
   *
   * @param array $data
   */
  public function __construct(array & $data = []) {
    $this->data =& $data;
  }

  /**
   * @return array
   */
  #[\Override]
  public function & all() {
    return $this->data;
  }

  /**
   * Replaces the current data by a new set.
   *
   * @param array
   * @return ParameterBag
   */
  #[\Override]
  public function replace(array & $data = []) {
    $this->data =& $data;
    return $this;
  }

}

