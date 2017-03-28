<?php

use PHPUnit\Framework\TestCase;

class FactoryTests extends TestCase {
  public function testNewFactory() {
    $f = TestFactory::getInstance();
    $this->assertEquals('TestClass', $f->getClass('test'));
  }

  public function testThrowsExceptionOnInvalidStaticCreate() {
    $f = TestFactory::getInstance();

    try {
      $f->create('test');
      $this->fail('Should have thrown an exception');
    } catch(\PHPUnit\Framework\AssertionFailedError $e) {
      throw $e;
    } catch(Exception $e) {
      $this->assertTrue(true, 'This is the expected behavior');
    }
  }

  public function testThrowsExceptionOnInvalidInstatiationParams() {
    $f = TestFactory::getInstance();

    try {
      $f->new('test');
      $this->fail('Should have thrown an exception');
    } catch(ArgumentCountError $e) {
      $this->assertTrue(true, 'This is the expected behavior');
    }
  }

  public function testThrowsExceptionOnUnknownClass() {
    $f = TestFactory::getInstance();

    try {
      $f->new('invalid');
      $this->fail('Should have thrown an exception');
    } catch(\Skel\UnknownClassException $e) {
      $this->assertTrue(true, 'This is the expected behavior');
    }
  }

  public function testCorrectlyInstantiatesClass() {
    $f = TestFactory::getInstance();

    $test = $f->new('test', null, 1,2);
    $this->assertTrue($test instanceof TestClass);
  }

  public function testCorrectlyInstantiatesDerivativeClass() {
    $f = DerivTestFactory::getInstance();

    $test = $f->new('test', null, 1,2);
    $this->assertTrue($test instanceof DerivTestClass);
  }

  public function testCorrectlyUsesStaticMethod() {
    $f = DerivTestFactory::getInstance();

    $test = $f->create('test');
    $this->assertTrue($test instanceof DerivTestClass);
  }
}

