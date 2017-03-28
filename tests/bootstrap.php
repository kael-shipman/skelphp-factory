<?php

require_once __DIR__."/../vendor/autoload.php";

class TestClass {
  protected $one;
  protected $two;

  public function __construct(int $one, int $two) {
    $this->one = $one;
    $this->two = $two;
  }

  public function getOne() { return $this->one; }
  public function getTwo() { return $this->two; }

  public function setOne($val) {
    $this->one = $val;
    return $this;
  }
  public function setTwo($val) {
    $this->two = $val;
    return $this;
  }
}

class DerivTestClass extends TestClass {
  public static function create() {
    return new static(5,6);
  }
}

class TestFactory extends \Skel\Factory {
  public function getClass(string $type, string $subtype=null) {
    if ($type == 'test') {
      return 'TestClass';
    }
    return parent::getClass($type, $subtype);
  }
}

class DerivTestFactory extends TestFactory {
  public function getClass(string $type, string $subtype=null) {
    if ($type == 'test') {
      if ($subtype != 'orig') return 'DerivTestClass';
    }
    return parent::getClass($type, $subtype);
  }
}

