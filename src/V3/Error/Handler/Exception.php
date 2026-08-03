<?php

namespace ECidade\V3\Error\Handler;

use \Exception as PHPException;
use \ECidade\V3\Error\EntityFactory;
use \ECidade\V3\Error\Entity;
use \ECidade\V3\Extension\Registry;
use \ECidade\V3\Error\Renderer;

class Exception implements HandlerInterface {

  public static function register() {
    return set_exception_handler(self::handle(...));
  }

  public static function handle($exception) {

    $entity = EntityFactory::createFromException($exception);

    $message = sprintf("Uncaught exception '%s' with message '%s' in %s on line %d",
      $exception::class,
      $entity->getMessage(),
      $entity->getFile(),
      $entity->getLine()
    );

    $entity->setMessage($message);
    $entity->setCode(Entity::CODE_UNCAUGHT_EXCEPTION);

    Registry::get('app.eventManager')->trigger('app.error', null, [$entity]);
    Renderer::render($entity);

    return $entity;
  }

}
