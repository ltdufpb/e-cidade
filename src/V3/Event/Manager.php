<?php

namespace ECidade\V3\Event;

use \Zend\EventManager\EventManager as ZendEventManager;

class Manager {

  /**
   * Zend Event Manager instance
   * @var EventManager
   */
  private $zendEventManager;

  public function __construct() {

    $this->zendEventManager = new ZendEventManager();
    $this->zendEventManager->setIdentifiers([
      self::class,
      static::class
    ]);

  }

  public function register($event, $callback) {
    $this->zendEventManager->attach($event, $callback);
  }

  public function unregister($callback) {
    $this->zendEventManager->detach($callback);
  }

  public function trigger($event, $target = null, array $params = []) {
    $this->zendEventManager->trigger($event, $target, $params);
  }

}
