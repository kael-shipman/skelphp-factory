<?php

use PHPUnit\Framework\TestCase;

class FactoryTests extends TestCase {
  public function testNewFactory() {
    $f = new TestFactory();
    $this->assertEquals('TestClass', $f->getClass('test'));
  }

  public function testThrowsExceptionOnInvalidStaticCreate() {
    $f = new TestFactory();

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
    $f = new TestFactory();

    try {
      $f->new('test');
      $this->fail('Should have thrown an exception');
    } catch(ArgumentCountError $e) {
      $this->assertTrue(true, 'This is the expected behavior');
    }
  }

  public function testThrowsExceptionOnUnknownClass() {
    $f = new TestFactory();

    try {
      $f->new('invalid');
      $this->fail('Should have thrown an exception');
    } catch(\Skel\UnknownClassException $e) {
      $this->assertTrue(true, 'This is the expected behavior');
    }
  }

  public function testCorrectlyInstantiatesClass() {
    $f = new TestFactory();

    $test = $f->new('test', null, 1,2);
    $this->assertTrue($test instanceof TestClass);
  }

  public function testCorrectlyInstantiatesDerivativeClass() {
    $f = new DerivTestFactory();

    $test = $f->new('test', null, 1,2);
    $this->assertTrue($test instanceof DerivTestClass);
  }

  public function testCorrectlyUsesStaticMethod() {
    $f = new DerivTestFactory();

    $test = $f->create('test');
    $this->assertTrue($test instanceof DerivTestClass);
  }
}

