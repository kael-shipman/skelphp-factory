<?php
namespace Skel;

abstract class Factory implements Interfaces\Factory {
  protected $context;

  public function new(string $class, string $type=null) {
    $args = array();
    for($i = 2; $i < func_num_args(); $i++) $args[] = func_get_arg($i);
    return $this->instantiate($class, $type, 'new', $args);
  }

  public function create(string $class, string $type=null) {
    $args = array();
    for($i = 2; $i < func_num_args(); $i++) $args[] = func_get_arg($i);
    return $this->instantiate($class, $type, 'create', $args);
  }

  protected function instantiate(string $class, string $type=null, string $action, array $args) {
    $c = $this->getClass($class, $type);
    if ($action == 'new') {
      $c = new \ReflectionClass($c);
      return $c->newInstanceArgs($args);
    }
    if ($action == 'create') return call_user_func_array(array($c, 'create'), $args);
    throw new \RuntimeException("Don't know how to handle action `$action`. I only know how to handle `new` and `create`.");
  }

  public function getClass(string $class, string $subtype=null) {
    throw new UnknownClassException("Don't know how to create classes for type `$class::$subtype`");
  }

  public function setContext(Interfaces\Context $c) {
    $this->context = $c;
  }
}

