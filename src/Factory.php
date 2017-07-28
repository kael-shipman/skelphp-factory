<?php
namespace Skel;

abstract class Factory extends \KS\Factory implements Interfaces\Factory {
  protected $context;

  public function setContext(Interfaces\Context $c) {
    $this->context = $c;
  }
}

